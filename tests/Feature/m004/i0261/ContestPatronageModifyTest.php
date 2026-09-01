<?php

use App\Models\Contest;
use App\Models\ContestPatronage;
use App\Models\Country;
use App\Models\Federation;
use App\Models\Organization;
use App\Models\User;
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

    // Creazione dell'organizzazione
    $this->organization = Organization::factory()->create([
        'country_id' => $this->country->id,
        'name' => 'Circolo Fotografico Nazionale',
    ]);

    // Ruolo membro dell'organizzazione
    UserRolesRoleSet::firstOrCreate(['role' => 'member']);

    // Utente autenticato e associato all'organizzazione con ruolo valido
    $this->user = User::factory()->create();
    UserRole::create([
        'user_id' => $this->user->id,
        'role' => 'member',
        'organization_id' => $this->organization->id,
        'role_opening' => now()->subDays(10),
        'role_closing' => now()->addYear(),
    ]);

    // Concorso creato al volo associato all'organizzazione
    $this->contest = Contest::factory()->create([
        'organization_id' => $this->organization->id,
        'country_id' => $this->country->id,
        'name_en' => 'Grand Photo Cup 2026',
        'name_local' => 'Gran Coppa Fotografica 2026',
    ]);

    // Creazione della federazione di prova
    $this->federation = Federation::factory()->create([
        'id' => 'IFIAF',
        'country_id' => $this->country->id,
        'name_en' => 'Federazione Italiana Associazioni Fotografiche',
    ]);

    // Creazione del patrocinio associato al concorso creato al volo
    $this->contestPatronage = ContestPatronage::create([
        'contest_id' => $this->contest->id,
        'federation_id' => $this->federation->id,
        'patronage_code' => '2026/01F',
    ]);
});

test('guest cannot access contest patronage modify page and is redirected to login', function () {
    $this->get(route('organization.design.contest-patronage.modify', ['contest_patronage' => $this->contestPatronage]))
        ->assertRedirect(route('login'));
});

test('unauthorized user not member of organization is forbidden from accessing modify patronage page', function () {
    $nonMemberUser = User::factory()->create();

    $this->actingAs($nonMemberUser)
        ->get(route('organization.design.contest-patronage.modify', ['contest_patronage' => $this->contestPatronage]))
        ->assertForbidden();
});

test('authorized member of organization can access contest patronage modify page via HTTP get', function () {
    $response = $this->actingAs($this->user)
        ->get(route('organization.design.contest-patronage.modify', ['contest_patronage' => $this->contestPatronage]));

    $response->assertSuccessful()
        ->assertSeeLivewire('organization.design.contest-patronage.modify')
        ->assertSee(__('Modify Federation Patronage Code'))
        ->assertSee(__('Check, then Modify'))
        ->assertSee(route('user.dashboard'))
        ->assertSee(route('organization.dashboard', ['organization' => $this->organization]))
        ->assertSee(route('organization.design.contest-patronage.listed', ['contest' => $this->contest]))
        ->assertSee('IFIAF')
        ->assertSee('Federazione Italiana Associazioni Fotografiche');
});

test('admin user can access contest patronage modify page via authorization policy', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('organization.design.contest-patronage.modify', ['contest_patronage' => $this->contestPatronage]))
        ->assertSuccessful()
        ->assertSeeLivewire('organization.design.contest-patronage.modify');
});

test('mounts correctly with existing contest patronage data for contest created on the fly', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.modify', ['contest_patronage' => $this->contestPatronage])
        ->assertSet('contPatrFederationId', $this->federation->id)
        ->assertSet('contPatrPatronageCode', '2026/01F')
        ->assertSet('contest.id', $this->contest->id)
        ->assertSet('organization.id', $this->organization->id);
});

test('user can update patronage code keeping the same federation for a contest created on the fly', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.modify', ['contest_patronage' => $this->contestPatronage])
        ->set('contPatrFederationId', $this->federation->id)
        ->set('contPatrPatronageCode', '2026/99MOD')
        ->call('modifyContestPatronage')
        ->assertHasNoErrors()
        ->assertRedirect(route('organization.design.contest-patronage.listed', ['contest' => $this->contest]))
        ->assertSessionHas('success', __('Federation Patronage modified, enjoy!'));

    $this->assertDatabaseHas('contest_patronages', [
        'id' => $this->contestPatronage->id,
        'contest_id' => $this->contest->id,
        'federation_id' => $this->federation->id,
        'patronage_code' => '2026/99MOD',
        'deleted_at' => null,
    ]);
});

test('user can update patronage by switching to another federation', function () {
    $newFederation = Federation::factory()->create([
        'id' => 'IFIAP',
        'country_id' => $this->country->id,
        'name_en' => 'Federation Internationale de l\'Art Photographique',
    ]);

    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.modify', ['contest_patronage' => $this->contestPatronage])
        ->set('contPatrFederationId', $newFederation->id)
        ->set('contPatrPatronageCode', '2026/FIAP01')
        ->call('modifyContestPatronage')
        ->assertHasNoErrors()
        ->assertRedirect(route('organization.design.contest-patronage.listed', ['contest' => $this->contest]))
        ->assertSessionHas('success', __('Federation Patronage modified, enjoy!'));

    // Il vecchio record è stato cancellato (soft deleted)
    $this->assertSoftDeleted('contest_patronages', [
        'id' => $this->contestPatronage->id,
        'federation_id' => $this->federation->id,
    ]);

    // Il nuovo record con la nuova federazione è presente
    $this->assertDatabaseHas('contest_patronages', [
        'contest_id' => $this->contest->id,
        'federation_id' => $newFederation->id,
        'patronage_code' => '2026/FIAP01',
        'deleted_at' => null,
    ]);
});

test('validation rules fail when required patronage fields are missing or empty', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.modify', ['contest_patronage' => $this->contestPatronage])
        ->set('contPatrFederationId', '')
        ->set('contPatrPatronageCode', '')
        ->call('modifyContestPatronage')
        ->assertHasErrors([
            'contPatrFederationId' => 'required',
            'contPatrPatronageCode' => 'required',
        ]);
});

test('validation rules fail when federation does not exist in database', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.modify', ['contest_patronage' => $this->contestPatronage])
        ->set('contPatrFederationId', 'NONEXISTENT')
        ->set('contPatrPatronageCode', 'CODE123')
        ->call('modifyContestPatronage')
        ->assertHasErrors(['contPatrFederationId' => 'exists']);
});

test('validation rules fail when patronage code is lowercase or exceeds maximum length', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.modify', ['contest_patronage' => $this->contestPatronage])
        ->set('contPatrFederationId', $this->federation->id)
        ->set('contPatrPatronageCode', 'lowercase_code_123')
        ->call('modifyContestPatronage')
        ->assertHasErrors(['contPatrPatronageCode' => 'uppercase']);

    Volt::test('organization.design.contest-patronage.modify', ['contest_patronage' => $this->contestPatronage])
        ->set('contPatrFederationId', $this->federation->id)
        ->set('contPatrPatronageCode', str_repeat('A', 25))
        ->call('modifyContestPatronage')
        ->assertHasErrors(['contPatrPatronageCode' => 'max']);
});
