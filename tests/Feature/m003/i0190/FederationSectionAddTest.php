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
        ->get(route('federation-section.listed', ['federation' => $this->federation]))
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
        ->set('short_size_max', 1080)
        ->set('long_size_max', 1080)
        ->set('file_size_max', 500000)
        ->set('unique_prize', true)
        ->call('saveNewFederationSection')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation-section.listed', $this->federation));

    $this->assertDatabaseHas('federation_sections', [
        'federation_id' => $this->federation->id,
        'code' => 'CL',
        'name_en' => 'Open Color Theme',
        'synopsis' => 'General rules for color digital images',
        'short_size_max' => 1080,
        'long_size_max' => 1080,
        'file_size_max' => 500000,
        'unique_prize' => true,
    ]);
});

test('non admin user cannot reach add federation-section page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('federation-section.add', $this->federation))
        ->assertStatus(403);
});
