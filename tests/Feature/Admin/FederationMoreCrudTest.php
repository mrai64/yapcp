<?php

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    // Nota: adegua la logica di creazione admin al tuo sistema di ruoli
    // was: $this->admin = User::factory()->create(['is_admin' => true]);
    $this->admin = User::factory()->admin()->create();
    $this->federation = Federation::factory()->create();
});

test('federation-more-fields list access by an admin', function () {
    $this->actingAs($this->admin)
        ->get(route('federation-more.list', ['federation' => $this->federation]))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});

test('an admin can reach federation-more-field add page', function () {
    $this->actingAs($this->admin)
        ->get(route('federation-more.add', $this->federation))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});

test('an admin can add a federation-more-field record', function () {
    $this->actingAs($this->admin);

    Volt::test('federation-more.⚡add', ['federation' => $this->federation]) // component file name
        ->set('referencedTable', 'user_contact_mores') // valid value
        ->set('fieldName', 'ItalianTaxId')
        ->set('fieldLabel', 'Codice Fiscale')
        ->set('fieldValidation', 'string')
        ->set('fieldDefault', 'XXXXXXXXXXXXXXXX')
        ->set('fieldSuggest', 'Suggest')
        ->call('addFederationMore')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation-more.list', $this->federation));

    $this->assertDatabaseHas('federation_mores', [
        'federation_id' => $this->federation->id,
        'referenced_table' => 'user_contact_mores',
        'field_label' => 'Codice Fiscale',
    ]);
});

test('an admin can reach federation-more-field modify page', function () {
    $federationMore = FederationMore::factory()->create(
        [
            'federation_id' => $this->federation->id,
            'referenced_table' => 'user_contact_mores',
            'field_name' => 'ItalianTaxId',
            'field_label' => 'Codice Fiscale',
            'field_validation_rules' => 'string',
            'field_default_value' => 'XXXXXXXXXXXXXXXX',
            'field_suggest' => 'Suggest'
        ]
    );

    $this->actingAs($this->admin)
        ->get(route('federation-more.modify', $federationMore))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});

test('an admin can update a federation-more-field record', function () {
    $federationMore = FederationMore::factory()->create(
        [
            'federation_id' => $this->federation->id,
            'referenced_table' => 'user_contact_mores',
            'field_name' => 'ItalianTaxId',
            'field_label' => 'Codice Fiscale',
            'field_validation_rules' => 'string',
            'field_default_value' => 'XXXXXXXXXXXXXXXX',
            'field_suggest' => 'Suggest'
        ]
    );

    $this->actingAs($this->admin);

    Volt::test('federation-more.⚡modify', ['federation_more' => $federationMore])
        ->set('fieldLabel', 'Nuovo Label')
        ->call('modifyFederationMore')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation-more.list', $this->federation));

    expect($federationMore->fresh()->field_label)->toBe('Nuovo Label');
});

test('an admin can remove a federation-more-field record', function () {
    $federationMore = FederationMore::factory()->create(
        [
            'federation_id' => $this->federation->id,
            'referenced_table' => 'user_contact_mores',
            'field_name' => 'ItalianTaxId',
            'field_label' => 'Codice Fiscale',
            'field_validation_rules' => 'string',
            'field_default_value' => 'XXXXXXXXXXXXXXXX',
            'field_suggest' => 'Suggest'
        ]
    );

    $this->actingAs($this->admin);

    Volt::test('federation-more.⚡remove', ['federation_more' => $federationMore])
        ->call('removeFederationMore')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation-more.list', $this->federation));

    // was:     $this->assertDatabaseMissing('federation_mores', ['id' => $federationMore->id]);
    // ok only for phisical deletion, for softdeete instead must be used
    $this->assertSoftDeleted($federationMore);
});

test('un utente non autorizzato non può accedere alle funzioni admin', function () {
    // was: $user = User::factory()->create(['is_admin' => false]);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('federation-more.add', $this->federation))
        ->assertStatus(403);
});
