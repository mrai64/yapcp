<?php

use App\Models\Country;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserContact;
use Livewire\Volt\Volt;

beforeEach(function () {
    // Creazione di uno Stato di riferimento per la chiave esterna country_id
    $this->country = Country::factory()->create();

    // Creazione dell'utente e del relativo contatto associato
    $this->user = User::factory()->create();
    $this->userContact = UserContact::updateOrCreate(
        [
        'id' => $this->user->id,
        ],
        [
        'country_id' => $this->country->id,
        ]
    );
});

test('authenticated user can access organization add page', function () {
    $this->actingAs($this->user)
        ->get(route('organization.add')) // Assicurati che la route corrisponda alla tua configurazione
        ->assertStatus(200)
        ->assertSee($this->userContact->first_name);
});

test('user can add a new organization successfully', function () {
    $this->actingAs($this->user);

    Volt::test('organization.add')
        ->set('organizationName', 'Open Source Foundation')
        ->set('country_id', $this->country->id)
        ->set('organizationEmail', 'contact@opensource.org')
        ->set('organizationWebsite', 'https://opensource.org')
        ->set('organizationContact', '123 Tech Street, Silicon Valley')
        ->call('addOrganization')
        ->assertHasNoErrors()
        ->assertRedirect(route('organization.listed'));

    // Verifica che l'organizzazione sia stata inserita correttamente nel database
    $this->assertDatabaseHas('organizations', [
        'name' => 'Open Source Foundation',
        'country_id' => $this->country->id,
        'email' => 'contact@opensource.org',
        'website' => 'https://opensource.org',
        'contact' => '123 Tech Street, Silicon Valley',
    ]);
});

test('organization add validation rules work properly', function () {
    $this->actingAs($this->user);

    Volt::test('organization.add')
        ->set('organizationName', 'AB') // Troppo corto (min: 3)
        ->set('country_id', '99999')   // Stato inesistente
        ->set('organizationEmail', 'email-non-valida') // Email non valida
        ->set('organizationWebsite', 'sito-non-valido') // URL non valido
        ->call('addOrganization')
        ->assertHasErrors([
            'organizationName',
            'country_id',
            'organizationEmail',
            'organizationWebsite',
        ]);
});

test('unauthenticated user cannot access organization add page', function () {
    $this->get(route('organization.add'))
        ->assertRedirect(route('login'));
});
