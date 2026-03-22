<?php

/**
 * that's FederationModifyTest.php
 *
 * @see blade: /resources/views/livewire/federation/modify.blade.php
 * @see controller: /app/Livewire/Federation/Modify.php
 *
 */
use App\Livewire\Federation\Modify;
use App\Models\Country;
use App\Models\Federation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('mounts correctly with federation data', function () {
    $user = User::factory()->create();
    $country = Country::factory()->create(['id' => 'USA', 'country' => 'United States']);

    $federation = Federation::factory()->create([
        'name_en' => 'International Federation',
        'website' => 'https://example.org',
        'country_id' => $country->id,
        'contact_info' => 'Contact details here',
    ]);

    Livewire::actingAs($user)
        ->test(Modify::class, ['federation' => $federation])
        ->assertStatus(200)
        ->assertSet('id', $federation->id)
        ->assertSet('federationNameEn', 'International Federation')
        ->assertSet('website', 'https://example.org')
        ->assertSet('countryId', $country->id)
        ->assertSet('federationContact', 'Contact details here')
        ->assertSee('International Federation');
});

test('federation name is required', function () {
    $country = Country::factory()->create();
    $federation = Federation::factory()->create(['country_id' => $country->id]);

    Livewire::test(Modify::class, ['federation' => $federation])
        ->set('federationNameEn', '')
        ->call('updateFederation')
        ->assertHasErrors(['federationNameEn' => 'required']);
});

test('website must be valid url', function () {
    $country = Country::factory()->create();
    $federation = Federation::factory()->create(['country_id' => $country->id]);

    Livewire::test(Modify::class, ['federation' => $federation])
        ->set('website', 'invalid-url')
        ->call('updateFederation')
        ->assertHasErrors(['website' => 'url']);
});

test('country id must exist', function () {
    $country = Country::factory()->create();
    $federation = Federation::factory()->create(['country_id' => $country->id]);

    Livewire::test(Modify::class, ['federation' => $federation])
        ->set('countryId', 'ZZZ') // Non-existent
        ->call('updateFederation')
        ->assertHasErrors(['countryId' => 'exists']);
});

test('update federation saves changes and redirects', function () {
    $oldCountry = Country::factory()->create(['id' => 'USA']);
    $newCountry = Country::factory()->create(['id' => 'CAN']);

    $federation = Federation::factory()->create([
        'name_en' => 'Old Name',
        'country_id' => $oldCountry->id,
    ]);

    Livewire::test(Modify::class, ['federation' => $federation])
        ->set('federationNameEn', 'Updated Name')
        ->set('website', 'https://updated.com')
        ->set('countryId', $newCountry->id)
        ->set('federationContact', 'New Contact')
        ->call('updateFederation')
        ->assertRedirect(route('federation.list'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('federations', [
        'id' => $federation->id,
        'name_en' => 'Updated Name',
        'website' => 'https://updated.com',
        'country_id' => $newCountry->id,
        'contact_info' => 'New Contact',
    ]);
});
