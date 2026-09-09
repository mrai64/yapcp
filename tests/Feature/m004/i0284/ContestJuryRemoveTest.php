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
    // add an Organization member and act as
    $this->userOrganization = User::factory()->create();
    $this->memberOf = UserRole::factory()->create([
        'user_id' => $this->userOrganization->id,
        'role' => 'member',
        'organization_id' => $this->organization->id,
        'role_opening' => now()->subDays(20)->format('Y-m-d\TH:i:s'),
        'role_closing' => now()->addDays(40)->format('Y-m-d\TH:i:s'),
    ]);
    $this->ActingAs($this->userOrganization);
});

it('add and remove a juror leaving from display', function () {
    $juror = User::factory()->create([
        'name' => 'Verdi, Giuseppe',
        'email' => 'giuseppe.verdi.1813@example.com'
    ]);
    $userContact = $juror->contact;

    $contestJuror = ContestJury::create([
        'contest_id' => $this->contest->id,
        'section_id' => $this->section->id,
        'user_id' => $juror->id,
        'is_president' => true,
        'qualify' => 'Eminent Photographer EFIAP',
    ]);
    $this->userRole = UserRole::create([
        'user_id' => $juror->id,
        'role' => 'juror',
        'contest_id' => $this->contest->id,
        'role_opening' => now()->subDays(2)->format('Y-m-d\TH:i'),
        'role_closing' => now()->addDays(20)->format('Y-m-d\TH:i'),
    ]);

    Volt::test('organization.design.contest-jury.listed', ['contest' => $this->contest])
        ->assertSee('Open Color')
        ->assertSee('Giuseppe')
        ->assertSee('Verdi')
        ->assertSee('Eminent Photographer EFIAP')
        ->assertSee('Jury President');

    Volt::test('organization.design.contest-jury.remove', ['contest_jury' => $contestJuror])
        ->call('removeContestJury')
        ->assertStatus(200);

    Volt::test('organization.design.contest-jury.listed', ['contest' => $this->contest])
        ->assertDontSeeText('Giuseppe')
        ->assertDontSeeText('Verdi');
});
