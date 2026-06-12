<?php

use App\Models\Federation;
use App\Models\FederationSection;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    // Creazione di un utente admin e di una federazione di riferimento
    $this->admin = User::factory()->admin()->create();
    $this->federation = Federation::factory()->create();
});

test('federation-section list access by an admin', function () {
    $this->actingAs($this->admin)
        ->get(route('federation-section.list', ['federation' => $this->federation]))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});

test('an admin can reach federation-section add page', function () {
    $this->actingAs($this->admin)
        ->get(route('federation-section.add', $this->federation))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});

test('an admin can add a federation-section record', function () {
    $this->actingAs($this->admin);

    Volt::test('federation-section.add', ['federation' => $this->federation])
        ->set('code', 'CL')
        ->set('name_en', 'Open Color Theme')
        ->set('synopsis', 'General rules for color digital images')
        ->set('short_size_max', 1920)
        ->set('long_size_max', 1080)
        ->set('file_size_max', 500000)
        ->set('unique_prize', true)
        ->call('saveNewFederationSection')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation-section.list', $this->federation));

    $this->assertDatabaseHas('federation_sections', [
        'federation_id' => $this->federation->id,
        'code' => 'CL',
        'name_en' => 'Open Color Theme',
        'synopsis' => 'General rules for color digital images',
        'short_size_max' => 1920,
        'long_size_max' => 1080,
        'file_size_max' => 500000,
        'unique_prize' => true,
    ]);
});

test('an admin can reach federation-section modify page', function () {
    $section = FederationSection::factory()->create([
        'federation_id' => $this->federation->id,
        'name_en' => 'Monochrome',
    ]);

    $this->actingAs($this->admin)
        ->get(route('federation-section.modify', $section))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en)
        ->assertSee('Monochrome');
});

test('an admin can update a federation-section record', function () {
    $section = FederationSection::factory()->create([
        'federation_id' => $this->federation->id,
        'code' => 'CL',
        'name_en' => 'Open Color Theme',
        'synopsis' => 'General rules for color digital images',
        'min_works' => 0,
        'max_works' => 4,
        'short_size_max' => 1920,
        'long_size_max' => 1080,
        'file_size_max' => 500000,
        'monochromatic_required' => true,
        'raw_required' => false,
        'unique_prize' => true,
    ]);

    $this->actingAs($this->admin);

    Volt::test('federation-section.modify', ['federation_section' => $section])
        ->set('name_en', 'Updated Theme Name')
        ->set('synopsis', 'Updated rules')
        ->call('modifyFederationSection')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation-section.list', $this->federation));

    expect($section->fresh()->name_en)->toBe('Updated Theme Name');
    expect($section->fresh()->synopsis)->toBe('Updated rules');
});

test('an admin can remove a federation-section record', function () {
    $section = FederationSection::factory()->create(['federation_id' => $this->federation->id]);

    $this->actingAs($this->admin);

    Volt::test('federation-section.remove', ['federation_section' => $section])
        ->call('removeFederationSection')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation-section.list', $this->federation));

    $this->assertSoftDeleted($section);
});

test('un utente non autorizzato non può accedere alle funzioni admin di federation-section', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('federation-section.add', $this->federation))
        ->assertStatus(403);
});