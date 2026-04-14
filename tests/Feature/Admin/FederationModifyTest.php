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

it('mounts correctly with federation data - admin user', function () {
    // Arrange
    $country = Country::factory()->create();
    $adminUser = User::factory()->admin()->create(); // admin user
    $federation = Federation::factory()->create([
        'name_en' => 'International Federation',
        'website' => 'https://example.org',
        'country_id' => $country->id,
        'timezone_id' => 'Europe/Rome',
        'contact_info' => 'Contact details here',
    ]);
    // Act Assert
    // form fields vs record fields
    Livewire::actingAs($adminUser)
        ->test(Modify::class, ['federation' => $federation])
        ->assertStatus(200)
        ->assertSet('federationId', $federation->id)
        ->assertSet('federationNameEn', $federation->name_en)
        ->assertSet('website', $federation->website)
        ->assertSet('countryId', $federation->country_id)
        ->assertSet('federationContact', $federation->contact_info)
        ->call('updateFederation');
    //
    $this->assertDatabaseHas('federations', [
        'id' => $federation->id,
        'name_en' => $federation->name_en,
    ]);
});

it('federation name is required', function () {
    // Arrange
    $country = Country::factory()->create();
    $adminUser = User::factory()->admin()->create(); // admin user
    $federation = Federation::factory()->create([
        'name_en' => 'International Federation',
        'website' => 'https://example.org',
        'country_id' => $country->id,
        'contact_info' => 'Contact details here',
    ]);
    // Act Assert
    Livewire::actingAs($adminUser)
        ->test(Modify::class, ['federation' => $federation])
        ->set('federationNameEn', '')
        ->call('updateFederation')
        ->assertHasErrors(['federationNameEn' => 'required']);
});

it('website must be valid url', function () {
    // Arrange
    $country = Country::factory()->create();
    $adminUser = User::factory()->admin()->create(); // admin user
    $federation = Federation::factory()->create([
        'name_en' => 'International Federation',
        'website' => 'https://example.org',
        'country_id' => $country->id,
        'contact_info' => 'Contact details here',
    ]);
    // Act Assert
    Livewire::actingAs($adminUser)
        ->test(Modify::class, ['federation' => $federation])
        ->set('website', 'invalid-url')
        ->call('updateFederation')
        ->assertHasErrors(['website' => 'url']);
});

it('country id must exitst', function () {
    // Arrange
    $country = Country::factory()->create();
    $adminUser = User::factory()->admin()->create(); // admin user
    $federation = Federation::factory()->create([
        'name_en' => 'International Federation',
        'website' => 'https://example.org',
        'country_id' => $country->id,
        'contact_info' => 'Contact details here',
    ]);
    // Act Assert
    Livewire::actingAs($adminUser)
        ->test(Modify::class, ['federation' => $federation])
        ->set('countryId', 'ZZZ')
        ->call('updateFederation')
        ->assertHasErrors(['countryId' => 'exists']);
});

it('update federation saves changes and redirects', function () {
    $oldCountry = Country::find('USA');
    $newCountry = Country::find('CAN');
    $adminUser = User::factory()->admin()->create(); // admin user

    $federation = Federation::factory()->create([
        'name_en' => 'International Federation',
        'website' => 'https://example.org',
        'country_id' => $oldCountry->id,
        'contact_info' => 'Contact details here',
    ]);

    Livewire::actingAs($adminUser)
        ->test(Modify::class, ['federation' => $federation])
        ->set('federationNameEn', 'Updated Name')
        ->set('website', 'https://updated.com')
        ->set('countryId', $newCountry->id)
        ->set('federationContact', 'New Contact')
        ->call('updateFederation')
        ->assertRedirectToRoute('federation.list')
        ->assertSessionHas('success');

    $this->assertDatabaseHas('federations', [
        'id' => $federation->id,
        'name_en' => 'Updated Name',
        'website' => 'https://updated.com',
        'country_id' => $newCountry->id,
        'contact_info' => 'New Contact',
    ]);
});
