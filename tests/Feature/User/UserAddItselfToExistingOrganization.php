<?php

use App\Models\User;
use App\Models\UserContact;
use App\Models\Organization;
use App\Models\UserRolesRoleContext;
use App\Models\UserRole;
use Livewire\Volt\Volt;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->userContact = UserContact::firstOrCreate(
        ['id' => $this->user->id],
        [
            'email' => $this->user->email,
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'country_id' => 'ITA',
        ]
    );

    $this->organization = Organization::factory()->create([
        'id' => Str::uuid7(),
        'country_id' => 'ITA',
    ]);
});

it('allows authenticated users to access organization.user.add page', function () {
    $this->actingAs($this->user)
        ->get(route('organization.user.add', ['organization' => $this->organization]))
        ->assertSuccessful()
        ->assertSeeLivewire('organization.user.add');
});

it('successfully adds user to organization with member role', function () {
    // Assicuriamo che il ruolo 'member' esista nel DB per superare la validazione 'exists:user_roles_role_sets,role'
    UserRolesRoleContext::factory()->create([
        'context_type' => 'organizations',
        'role'         => 'member',
        'green'        => true,
    ]);

    $this->actingAs($this->user);

    Volt::test('organization.user.add', ['organization' => $this->organization])
        ->set('userRoleRole', 'member')
        ->call('addUserToOrganizationInUserRole')
        ->assertHasNoErrors()
        ->assertRedirect(route('user.dashboard'));

    // Verifica la presenza del record nella tabella dei ruoli utenti
    $this->assertDatabaseHas('user_roles', [
        'user_id'         => $this->userContact->id,
        'organization_id' => $this->organization->id,
        'role'            => 'member',
    ]);
});

it('fails validation when providing an invalid role like something', function () {
    $this->actingAs($this->user);

    Volt::test('organization.user.add', ['organization' => $this->organization])
        ->set('userRoleRole', 'something')
        ->call('addUserToOrganizationInUserRole')
        ->assertHasErrors(['userRoleRole' => 'exists']);
});
