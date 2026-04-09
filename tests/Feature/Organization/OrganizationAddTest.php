<?php

use App\Livewire\Organization\Add;
use App\Models\Country;
use App\Models\User;
use Livewire\Livewire;


it('allows an authorized user to create a new organization', function () {
    // Arrange
    $user = User::factory()->create();
    // Country::factory()->create(['id' => 'ITA']);

    // Act & Assert using Livewire
    Livewire::actingAs($user)
        ->test(Add::class)
        ->set('name', 'Circolo Fotografico Arno')
        ->set('countryId', 'ITA')
        ->set('email', 'info@cf-arno.test')
        ->set('organizationWebsite', 'https://cf-arno.test')
        ->set('organizationContact', 'Segreteria CF Arno - via Romea n.17 - 50163 FIGLINE VALDARNO FI')
        ->call('saveNewOrganization')
        ->assertRedirect(route('organization.list'))
        ->assertSessionHas('success');
    //
    $this->assertDatabaseHas('organizations', [
        'name' => 'Circolo Fotografico Arno',
        'email' => 'info@cf-arno.test',
    ]);
});

it('fails validation if organization name is missing', function () {
    $user = User::factory()->create();
    // Country::factory()->create(['id' => 'ITA']);

    Livewire::actingAs($user)
        ->test(Add::class)
        ->set('name', '') //
        ->set('countryId', 'ITA')
        ->set('email', 'test@org.test')
        ->call('saveNewOrganization')
        ->assertHasErrors(['name' => 'required']);
});
