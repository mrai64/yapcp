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

test('guest cannot access contest patronage remove page and is redirected to login', function () {
    $this->get(route('organization.design.contest-patronage.remove', ['contest_patronage' => $this->contestPatronage]))
        ->assertRedirect(route('login'));
});

test('unauthorized user not member of organization is forbidden from accessing remove patronage page', function () {
    $nonMemberUser = User::factory()->create();

    $this->actingAs($nonMemberUser)
        ->get(route('organization.design.contest-patronage.remove', ['contest_patronage' => $this->contestPatronage]))
        ->assertForbidden();
});

test('authorized member of organization can access contest patronage remove page via HTTP get', function () {
    $response = $this->actingAs($this->user)
        ->get(route('organization.design.contest-patronage.remove', ['contest_patronage' => $this->contestPatronage]));

    $response->assertSuccessful()
        ->assertSeeLivewire('organization.design.contest-patronage.remove')
        ->assertSee(__('Federation Patronage Code Remove'))
        ->assertSee(__('LAST CALL. Are you SURE to delete that?'))
        ->assertSee(route('user.dashboard'))
        ->assertSee(route('organization.dashboard', ['organization' => $this->organization]))
        ->assertSee(route('organization.design.contest-patronage.listed', ['contest' => $this->contest]))
        ->assertSee('IFIAF')
        ->assertSee('2026/01F')
        ->assertSee('Federazione Italiana Associazioni Fotografiche');
});

test('admin user can access contest patronage remove page via authorization policy', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('organization.design.contest-patronage.remove', ['contest_patronage' => $this->contestPatronage]))
        ->assertSuccessful()
        ->assertSeeLivewire('organization.design.contest-patronage.remove');
});

test('mounts correctly with existing contest patronage details for a contest created on the fly', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.remove', ['contest_patronage' => $this->contestPatronage])
        ->assertSet('contestPatronage.id', $this->contestPatronage->id)
        ->assertSet('contest.id', $this->contest->id)
        ->assertSet('organization.id', $this->organization->id)
        ->assertSee('IFIAF')
        ->assertSee('2026/01F')
        ->assertSee('Federazione Italiana Associazioni Fotografiche');
});

test('authorized user can remove a contest patronage successfully via Livewire action', function () {
    $this->actingAs($this->user);

    Volt::test('organization.design.contest-patronage.remove', ['contest_patronage' => $this->contestPatronage])
        ->call('removeContestPatronage')
        ->assertHasNoErrors()
        ->assertRedirect(route('organization.design.contest-patronage.listed', ['contest' => $this->contest]))
        ->assertSessionHas('success', __('Federation Patronage modified, enjoy!'));

    // Verifica che il record sia stato soft-deleted
    $this->assertSoftDeleted('contest_patronages', [
        'id' => $this->contestPatronage->id,
        'contest_id' => $this->contest->id,
        'federation_id' => $this->federation->id,
    ]);
});

test('admin user can remove a contest patronage successfully via Livewire action', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin);

    Volt::test('organization.design.contest-patronage.remove', ['contest_patronage' => $this->contestPatronage])
        ->call('removeContestPatronage')
        ->assertHasNoErrors()
        ->assertRedirect(route('organization.design.contest-patronage.listed', ['contest' => $this->contest]))
        ->assertSessionHas('success', __('Federation Patronage modified, enjoy!'));

    // Verifica che il record sia stato soft-deleted
    $this->assertSoftDeleted('contest_patronages', [
        'id' => $this->contestPatronage->id,
        'contest_id' => $this->contest->id,
        'federation_id' => $this->federation->id,
    ]);
});
