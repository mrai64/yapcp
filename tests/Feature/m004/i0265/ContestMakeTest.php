<?php

use App\Models\Contest;
use App\Models\Country;
use App\Models\Organization;
use App\Models\Timezone;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserRole;
use App\Models\UserRolesRoleSet;
use Livewire\Volt\Volt;

beforeEach(function () {
    // Creazione del paese di riferimento
    $this->country = Country::firstOrCreate(
        ['id' => 'ITA'],
        [
            'country' => 'Italy',
            'lang_code' => 'it_IT',
            'flag_code' => '🇮🇹',
        ]
    );

    // Creazione del fuso orario di riferimento
    $this->timezone = Timezone::firstOrCreate(
        ['id' => 'Europe/Rome'],
        ['region_id' => 1]
    );

    // Creazione dell'organizzazione
    $this->organization = Organization::factory()->create([
        'country_id' => $this->country->id,
        'name' => 'Circolo Fotografico Nazionale',
    ]);

    // Ruolo membro dell'organizzazione
    UserRolesRoleSet::firstOrCreate(['role' => 'member']);

    // Utente autenticato e associato all'organizzazione con contatto
    $this->user = User::factory()->create();
    $this->userContact = UserContact::updateOrCreate(
        ['id' => $this->user->id],
        [
            'country_id' => $this->country->id,
            'timezone_id' => $this->timezone->id,
            'lang_local' => 'it',
        ]
    );

    UserRole::create([
        'user_id' => $this->user->id,
        'role' => 'member',
        'organization_id' => $this->organization->id,
        'role_opening' => now()->subDays(10),
        'role_closing' => now()->addYear(),
    ]);
});

test('guest cannot access contest make page and is redirected to login', function () {
    $this->get(route('organization.design.contest.make', ['organization' => $this->organization]))
        ->assertRedirect(route('login'));
});

test('authenticated user accessing contest make creates a new contest and redirects to modify name blade', function () {
    $response = $this->actingAs($this->user)
        ->get(route('organization.design.contest.make', ['organization' => $this->organization]));

    $contest = Contest::where('organization_id', $this->organization->id)->latest()->first();

    expect($contest)->not->toBeNull();

    $response->assertRedirect(route('organization.design.contest.modify-name', ['contest' => $contest]))
        ->assertSessionHas('success', __('Start Modify your Contest'));

    // Verifica inserimento a database con federation_list vuota (in attesa di rimozione colonna)
    $this->assertDatabaseHas('contests', [
        'id' => $contest->id,
        'organization_id' => $this->organization->id,
        'country_id' => $this->organization->country_id,
        'federation_list' => '',
        'name_en' => '',
        'timezone_id' => $this->userContact->timezone_id,
    ]);
});

test('user lands successfully on contest modify name blade after redirect', function () {
    $this->actingAs($this->user)
        ->get(route('organization.design.contest.make', ['organization' => $this->organization]));

    $contest = Contest::where('organization_id', $this->organization->id)->latest()->first();

    $modifyResponse = $this->actingAs($this->user)
        ->get(route('organization.design.contest.modify-name', ['contest' => $contest]));

    $modifyResponse->assertSuccessful()
        ->assertSeeLivewire('organization.design.contest.modify-name')
        ->assertSee(__('Modify Contest infos'))
        ->assertSee(route('user.dashboard'))
        ->assertSee(route('organization.dashboard', ['organization' => $this->organization]));
});

test('contest make Volt component mounts and creates draft contest with correct default values', function () {
    $this->actingAs($this->user);

    $initialContestsCount = Contest::where('organization_id', $this->organization->id)->count();

    Volt::test('organization.design.contest.make', ['organization' => $this->organization])
        ->assertHasNoErrors();

    $newContestsCount = Contest::where('organization_id', $this->organization->id)->count();
    expect($newContestsCount)->toBe($initialContestsCount + 1);

    $contest = Contest::where('organization_id', $this->organization->id)->latest()->first();

    expect($contest->organization_id)->toBe($this->organization->id)
        ->and($contest->country_id)->toBe($this->organization->country_id)
        ->and($contest->federation_list)->toBe('')
        ->and($contest->timezone_id)->toBe($this->userContact->timezone_id)
        ->and($contest->day_1_opening)->not->toBeNull()
        ->and($contest->day_2_closing)->not->toBeNull();
});
