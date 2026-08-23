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

test('an admin can remove a federation-section record', function () {
    $section = FederationSection::factory()->create(['federation_id' => $this->federation->id]);

    $this->actingAs($this->admin);

    Volt::test('federation-section.remove', ['federation_section' => $section])
        ->call('removeFederationSection')
        ->assertHasNoErrors()
        ->assertRedirect(route('federation-section.listed', $this->federation));

    $this->assertSoftDeleted($section);
});

test('non admin user cannot reach federation-section add page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('federation-section.add', $this->federation))
        ->assertStatus(403);
});
