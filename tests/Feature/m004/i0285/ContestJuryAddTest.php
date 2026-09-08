<?php

use App\Models\Contest;
use App\Models\ContestJury;
use App\Models\ContestSection;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserRole;
use Livewire\Volt\Volt;

beforeEach(function () {
    // Create an organization and contest with sections for testing
    $this->organization = Organization::factory()->create();
    $this->contest = Contest::factory()->create([
        'organization_id' => $this->organization->id,
        'day_3_jury_opening' => now()->addDays(1)->format('Y-m-d H:i:s'),
        'day_4_jury_closing' => now()->addDays(10)->format('Y-m-d H:i:s'),
    ]);
    $this->section = ContestSection::factory()->create([
        'contest_id' => $this->contest->id,
        'code' => 'A',
        'name_en' => 'Open Color',
    ]);
});

it('redirects to step 3 when checking email of an existing user contact', function () {
    // 1. Arrange: Existing user contact in DB
    $user = User::factory()->create([
        'name' => 'Juror, Existing',
        'email' => 'existing.juror@example.com',
    ]);
    $userContact = $user->contact;

    // 2. Act & Assert: Test Step 1 Livewire Volt component
    Volt::test('organization.design.contest-jury.add1', ['contest_section' => $this->section])
        ->set('contestJurorEmail', 'existing.juror@example.com')
        ->call('checkEmail')
        ->assertSessionHas('contest_juror_email', 'existing.juror@example.com')
        ->assertSessionHas('contest_juror_id', $userContact->id)
        ->assertRedirect(route('organization.design.contest-jury.add3', ['contest_section' => $this->section]));
});

it('redirects to step 2 when checking email of a new juror', function () {
    Volt::test('organization.design.contest-jury.add1', ['contest_section' => $this->section])
        ->set('contestJurorEmail', 'new.juror@example.com')
        ->call('checkEmail')
        ->assertSessionHas('contest_juror_email', 'new.juror@example.com')
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('organization.design.contest-jury.add2', ['contest_section' => $this->section]));
});

it('validates and registers a new juror user contact in step 2', function () {
    // Set up session from Step 1
    session()->put('contest_juror_email', 'new.juror@example.com');

    Volt::test('organization.design.contest-jury.add2', ['contest_section' => $this->section])
        ->set('contestJurorFirstName', 'Mario')
        ->set('contestJurorLastName', 'Rossi')
        ->set('contestJurorCountryId', 'ITA')
        ->set('contestJurorEmail', 'new.juror@example.com')
        ->call('addUserContact')
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('organization.design.contest-jury.add3', ['contest_section' => $this->section]));

    // Assert UserContact created
    $this->assertDatabaseHas('user_contacts', [
        'email' => 'new.juror@example.com',
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'country_id' => 'ITA',
    ]);
});

it('creates contest jury with qualify field and assigns juror user role atomically', function () {
    // Arrange: User contact exists
    $user = User::factory()->create([
        'name' => 'Final, Juror',
        'email' => 'juror.final@example.com',
    ]);
    $userContact = $user->contact;
    session()->put('contest_juror_id', $userContact->id);

    // Act: Final Step 3
    Volt::test('organization.design.contest-jury.add3', ['contest_section' => $this->section])
        ->set('contestJurorQualify', 'President of Photo Club Milan')
        ->set('contestJurorIsPresident', true)
        ->call('addContestJury')
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('organization.design.contest-jury.listed', ['contest' => $this->contest]));

    // Assert ContestJury created with qualify field
    $this->assertDatabaseHas('contest_juries', [
        'contest_id' => $this->contest->id,
        'section_id' => $this->section->id,
        'user_id' => $userContact->id,
        'is_president' => true,
        'qualify' => 'President of Photo Club Milan',
    ]);

    // Assert UserRole created
    $this->assertDatabaseHas('user_roles', [
        'user_id' => $userContact->id,
        'role' => 'juror',
        'contest_id' => $this->contest->id,
    ]);

    // Check sessions cleared
    expect(session()->has('contest_juror_id'))->toBeFalse();
    expect(session()->has('contest_juror_email'))->toBeFalse();
});

it('renders the section jurors list with correct eager loading and qualification display', function () {
    $user = User::factory()->create([
        'name' => 'Verdi, Giuseppe',
        'email' => 'giuseppe.verdi.1813@example.com'
    ]);
    $userContact = $user->contact;

    ContestJury::create([
        'contest_id' => $this->contest->id,
        'section_id' => $this->section->id,
        'user_id' => $userContact->id,
        'is_president' => true,
        'qualify' => 'Eminent Photographer EFIAP',
    ]);

    Volt::test('organization.design.contest-jury.listed', ['contest' => $this->contest])
        ->assertSee('Open Color')
        ->assertSee('Giuseppe')
        ->assertSee('Verdi')
        ->assertSee('Eminent Photographer EFIAP')
        ->assertSee('Jury President');
});
