<?php

use App\Models\Contest;
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
    \App\Models\UserRolesRoleSet::firstOrCreate(['role' => 'member']);

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

    // Creazione di una federazione di prova
    $this->federation = Federation::factory()->create([
        'id' => 'IFIAF',
        'country_id' => $this->country->id,
        'name_en' => 'Federazione Italiana Associazioni Fotografiche',
    ]);
});

test('guest cannot access contest patronage add page and is redirected to login', function () {
    $this->get(route('organization.design.contest-patronage.add', ['contest' => $this->contest]))
        ->assertRedirect(route('login'));
});

test('unauthorized user not member of organization is forbidden from accessing add patronage page', function () {
    $nonMemberUser = User::factory()->create();

    $this->actingAs($nonMemberUser)
        ->get(route('organization.design.contest-patronage.add', ['contest' => $this->contest]))
        ->assertForbidden();
});

test('authorized member of organization can access contest patronage add page via HTTP get', function () {
    $response = $this->actingAs($this->user)
        ->get(route('organization.design.contest-patronage.add', ['contest' => $this->contest]));

    $response->assertSuccessful()
        ->assertSeeLivewire('organization.design.contest-patronage.add')
        ->assertSee(__('Add Federation Patronage Code'))
        ->assertSee(route('user.dashboard'))
        ->assertSee(route('organization.dashboard', ['organization' => $this->organization]))
        ->assertSee(route('organization.design.contest-patronage.listed', ['contest' => $this->contest]))
        ->assertSee('IFIAF')
        ->assertSee('Federazione Italiana Associazioni Fotografiche');
});

test('admin user can access contest patronage add page via authorization policy', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('organization.design.contest-patronage.add', ['contest' => $this->contest]))
        ->assertSuccessful()
        ->assertSeeLivewire('organization.design.contest-patronage.add');
});

test('user can add a new contest patronage successfully to a contest created on the fly', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.add', ['contest' => $this->contest])
        ->set('contPatrFederationId', $this->federation->id)
        ->set('contPatrPatronageCode', '2026/01F')
        ->call('addContestPatronage')
        ->assertHasNoErrors()
        ->assertRedirect(route('organization.design.contest-patronage.listed', ['contest' => $this->contest]));

    // Verifica inserimento a database del patrocinio legato al concorso creato al volo
    $this->assertDatabaseHas('contest_patronages', [
        'contest_id' => $this->contest->id,
        'federation_id' => $this->federation->id,
        'patronage_code' => '2026/01F',
    ]);
});

test('validation rules fail when required patronage fields are missing or invalid', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.add', ['contest' => $this->contest])
        ->set('contPatrFederationId', '')
        ->set('contPatrPatronageCode', '')
        ->call('addContestPatronage')
        ->assertHasErrors([
            'contPatrFederationId' => 'required',
            'contPatrPatronageCode' => 'required',
        ]);
});

test('validation rules fail when federation does not exist in database', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.add', ['contest' => $this->contest])
        ->set('contPatrFederationId', 'NONEXISTENT')
        ->set('contPatrPatronageCode', 'CODE123')
        ->call('addContestPatronage')
        ->assertHasErrors(['contPatrFederationId' => 'exists']);
});

test('validation rules fail when patronage code is lowercase or exceeds maximum length', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.add', ['contest' => $this->contest])
        ->set('contPatrFederationId', $this->federation->id)
        ->set('contPatrPatronageCode', 'lowercase_code_123')
        ->call('addContestPatronage')
        ->assertHasErrors(['contPatrPatronageCode' => 'uppercase']);

    Volt::test('organization.design.contest-patronage.add', ['contest' => $this->contest])
        ->set('contPatrFederationId', $this->federation->id)
        ->set('contPatrPatronageCode', str_repeat('A', 25))
        ->call('addContestPatronage')
        ->assertHasErrors(['contPatrPatronageCode' => 'max']);
});
