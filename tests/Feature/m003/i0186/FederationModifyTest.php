<?php

use App\Models\Country;
use App\Models\Federation;
use App\Models\Timezone;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->admin = User::factory()->admin()->create();

    $this->country = Country::firstOrCreate(
        ['id' => 'ITA'],
        ['country' => 'Italy', 'lang_code' => 'it_IT']
    );

    $this->timezone = Timezone::firstOrCreate(
        ['id' => 'Europe/Rome'],
        ['region_id' => 1]
    );

    $this->federation = Federation::factory()->create([
        'country_id' => $this->country->id,
        'name_en' => 'Italian Federation of Photographic Associations',
        'website' => 'https://fiaf.net',
        'contact_info' => 'Via San Francesco 1, Torino, Italy',
        'local_lang' => 'it',
        'name_local' => 'Federazione Italiana Associazioni Fotografiche',
        'timezone_id' => $this->timezone->id,
    ]);
});

test('guest cannot reach federation modify page and is redirected to login', function () {
    $response = $this->get(route('federation.modify', $this->federation));

    $response->assertRedirect(route('login'));
});

test('non admin user cannot reach federation modify page', function () {
    $response = $this->actingAs($this->user)
        ->get(route('federation.modify', $this->federation));

    $response->assertForbidden();
});

test('admin can reach federation modify page', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('federation.modify', $this->federation));

    $response->assertOk()
        ->assertSeeLivewire('federation.modify');
});

test('mounts correctly with existing federation data', function () {
    $this->actingAs($this->admin);

    Volt::test('federation.modify', ['federation' => $this->federation])
        ->assertSet('federationId', $this->federation->id)
        ->assertSet('federationCountryId', 'ITA')
        ->assertSet('federationNameEn', 'Italian Federation of Photographic Associations')
        ->assertSet('federationWebsite', 'https://fiaf.net')
        ->assertSet('federationContactInfo', 'Via San Francesco 1, Torino, Italy')
        ->assertSet('federationLocalLang', 'it')
        ->assertSet('federationNameLocal', 'Federazione Italiana Associazioni Fotografiche')
        ->assertSet('federationTimezoneId', 'Europe/Rome');
});

test('an admin can update a federation record successfully (happy path)', function () {
    $newCountry = Country::firstOrCreate(
        ['id' => 'FRA'],
        ['country' => 'France', 'lang_code' => 'fr_FR']
    );

    $newTimezone = Timezone::firstOrCreate(
        ['id' => 'Europe/Paris'],
        ['region_id' => 1]
    );

    $this->actingAs($this->admin);

    Volt::test('federation.modify', ['federation' => $this->federation])
        ->set('federationCountryId', $newCountry->id)
        ->set('federationNameEn', 'Federation Photographique de France')
        ->set('federationWebsite', 'https://federation-photo.fr')
        ->set('federationContactInfo', '5 rue Jules Breton, Paris, France')
        ->set('federationLocalLang', 'fr')
        ->set('federationNameLocal', 'Fédération Photographique de France')
        ->set('federationTimezoneId', $newTimezone->id)
        ->call('modifyFederation')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation.listed'))
        ->assertSessionHas('success', __('Federation updated successfully'));

    $this->assertDatabaseHas('federations', [
        'id' => $this->federation->id,
        'country_id' => 'FRA',
        'name_en' => 'Federation Photographique de France',
        'website' => 'https://federation-photo.fr',
        'contact_info' => '5 rue Jules Breton, Paris, France',
        'local_lang' => 'fr',
        'name_local' => 'Fédération Photographique de France',
        'timezone_id' => 'Europe/Paris',
    ]);
});

test('validation fails when required fields are missing', function () {
    $this->actingAs($this->admin);

    Volt::test('federation.modify', ['federation' => $this->federation])
        ->set('federationId', '')
        ->set('federationCountryId', '')
        ->set('federationNameEn', '')
        ->set('federationContactInfo', '')
        ->set('federationTimezoneId', '')
        ->call('modifyFederation')
        ->assertHasErrors([
            'federationId' => 'required',
            'federationCountryId' => 'required',
            'federationNameEn' => 'required',
            'federationContactInfo' => 'required',
            'federationTimezoneId' => 'required',
        ]);
});

test('validation fails when country does not exist', function () {
    $this->actingAs($this->admin);

    Volt::test('federation.modify', ['federation' => $this->federation])
        ->set('federationCountryId', 'NONEXISTENT')
        ->call('modifyFederation')
        ->assertHasErrors(['federationCountryId' => 'exists']);
});

test('validation fails when timezone does not exist', function () {
    $this->actingAs($this->admin);

    Volt::test('federation.modify', ['federation' => $this->federation])
        ->set('federationTimezoneId', 'Invalid/Timezone')
        ->call('modifyFederation')
        ->assertHasErrors(['federationTimezoneId' => 'exists']);
});

test('validation fails when website is not a valid url', function () {
    $this->actingAs($this->admin);

    Volt::test('federation.modify', ['federation' => $this->federation])
        ->set('federationWebsite', 'not-a-valid-url')
        ->call('modifyFederation')
        ->assertHasErrors(['federationWebsite']);
});

test('validation fails when federation id is already taken by another federation', function () {
    $otherFederation = Federation::factory()->create([
        'country_id' => $this->country->id,
        'timezone_id' => $this->timezone->id,
    ]);

    $this->actingAs($this->admin);

    Volt::test('federation.modify', ['federation' => $this->federation])
        ->set('federationId', $otherFederation->id)
        ->call('modifyFederation')
        ->assertHasErrors(['federationId']);
});
