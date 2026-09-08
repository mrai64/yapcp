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
    // 1. Setup organizzazione e utente autenticato (proprietario/gestore dell'organizzazione)
    $this->user = User::factory()->create();
    $this->organization = Organization::factory()->create();
    $this->userOrganization = UserRole::create([
        'user_id' => $this->user->id,
        'role' => 'member',
        'organization_id' => $this->organization->id,
        'role_opening' => now()->subDays(20)->format('Y-m-d\TH:i'),
        'role_closing' => now()->addDays(40)->format('Y-m-d\TH:i'),
    ]);

    // 2. Setup contest e sezione
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

    // 3. Setup giurato (User, UserContact, ContestJury, UserRole)
    $this->jurorUser = User::factory()->create([
        'name' => 'Giurato, Mario',
        'email' => 'mario.giurato@example.com',
    ]);
    $this->jurorContact = $this->jurorUser->contact;

    $this->contestJury = ContestJury::create([
        'contest_id' => $this->contest->id,
        'section_id' => $this->section->id,
        'user_id' => $this->jurorContact->id,
        'is_president' => false,
        'qualify' => 'International Photographer',
    ]);

    $this->userRole = UserRole::create([
        'user_id' => $this->jurorContact->id,
        'role' => 'juror',
        'contest_id' => $this->contest->id,
        'role_opening' => now()->subDays(2)->format('Y-m-d\TH:i'),
        'role_closing' => now()->addDays(20)->format('Y-m-d\TH:i'),
    ]);

    // Autenticazione dell'utente responsabile
    $this->actingAs($this->user);
});

it('mounts the component with correct initial data', function () {
    Volt::test('organization.design.contest-jury.modify', ['contest_jury' => $this->contestJury])
        ->assertSet('contestJurorIsPresident', false)
        ->assertSet('contestJurorQualify', 'International Photographer')
        ->assertSee('Mario')
        ->assertSee('Giurato');
});

it('validates required fields when modifying a juror', function () {
    Volt::test('organization.design.contest-jury.modify', ['contest_jury' => $this->contestJury])
        ->set('contestJurorQualify', '') // Vuoto
        ->call('modifyContestJury')
        ->assertHasErrors(['contestJurorQualify' => 'required']);
});

it('updates juror qualification and president status successfully', function () {
    Volt::test('organization.design.contest-jury.modify', ['contest_jury' => $this->contestJury])
        ->set('contestJurorQualify', 'Jury President EFIAP')
        ->set('contestJurorIsPresident', true)
        ->call('modifyContestJury')
        ->assertSessionHasNoErrors()
        ->assertSessionHas('success', __('Juror updated.'))
        ->assertRedirect(route('organization.design.contest-jury.listed', ['contest' => $this->contest]));

    // Verifica la persistenza nel Database
    $this->assertDatabaseHas('contest_juries', [
        'id' => $this->contestJury->id,
        'is_president' => true,
        'qualify' => 'Jury President EFIAP',
    ]);
});

it('handles juror resignation gracefully and closes role dates atomically', function () {
    Volt::test('organization.design.contest-jury.modify', ['contest_jury' => $this->contestJury])
        ->call('resignContestJury')
        ->assertSessionHasNoErrors()
        ->assertSessionHas('success', __('Juror retired.'))
        ->assertRedirect(route('organization.design.contest-jury.listed', ['contest' => $this->contest]));

    // 1. Verifica la cancellazione SoftDelete del giurato
    $this->assertSoftDeleted('contest_juries', [
        'id' => $this->contestJury->id,
    ]);

    // 2. Verifica che le date in UserRole siano state aggiornate (chiusura del ruolo)
    $today = now()->format('Y-m-d\TH:i');

    $this->assertDatabaseHas('user_roles', [
        'id' => $this->userRole->id,
        'user_id' => $this->jurorContact->id,
        'role' => 'juror',
        'contest_id' => $this->contest->id,
        'role_opening' => $today,
        'role_closing' => $today,
    ]);
});
