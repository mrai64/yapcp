<?php

use App\Models\Federation;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->admin = User::factory()->admin()->create();
});

test('admin can reach federation add page', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('federation.add'));

    $response->assertOk();
});

test('non admin user cannot reach federation add page', function () {
    $response = $this->actingAs($this->user)
        ->get(route('federation.add'));

    $response->assertForbidden();
});

test('guest cannot reach federation add page', function () {
    $response = $this->get(route('federation.add'));

    $response->assertRedirect(route('login'));
});

test('an admin can add a federation-section record', function () {
    $this->actingAs($this->admin);
    // user route reference federation
    Volt::test('federation.add')
        ->set('federationId', 'FIAP:LUX')
        ->set('federationCountryId', 'LUX')
        ->set('federationNameEn', "Fédération Internationale de l'Art Photographique")
        ->set('federationWebsite', 'https://fiap.net')
        ->set('federationContactInfo', 'President mr Aldo Busi')
        ->set('federationLocalLang', 'fr')
        ->set('federationNameLocal', "Fédération Internationale de l'Art Photographique")
        ->set('federationTimezoneId', "Europe/Luxembourg")
        ->call('addFederation')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation.listed'));
    // in Database use table name federations
    $this->assertDatabaseHas('federations', [
        'id' => 'FIAP:LUX',
        'website' => 'https://fiap.net',
        'contact_info' => 'President mr Aldo Busi',
        'timezone_id' => 'Europe/Luxembourg',
    ]);
});

test('validation fails when required fields are missing', function () {
    $this->actingAs($this->admin);

    Volt::test('federation.add')
        ->call('addFederation')
        ->assertHasErrors([
            'federationId' => 'required',
            'federationCountryId' => 'required',
            'federationNameEn' => 'required',
            'federationContactInfo' => 'required',
            'federationTimezoneId' => 'required',
        ]);
});
