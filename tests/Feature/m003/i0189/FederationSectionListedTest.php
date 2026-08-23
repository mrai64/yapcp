<?php

use App\Models\Federation;
use App\Models\FederationSection;
use App\Models\User;

beforeEach(function () {
    // Creiamo un utente standard (non admin)
    $this->user = User::factory()->create();

    // Creiamo la federation con id "FIAF"
    // $this->federation = Federation::factory()->create(['id' => 'FIAF']);
    $this->federation = Federation::find('FIAF');

    // Creiamo alcune sezioni di federazione collegate a FIAF
    $this->sections = FederationSection::factory()
        ->count(5)
        ->create(['federation_id' => $this->federation->id]);
});

test('federation-section.listed route requires authentication', function () {
    // Un utente non autenticato non può accedere alla rotta
    $this->get(route('federation-section.listed', ['federation' => $this->federation]))
        ->assertRedirect('/login');
});

test('federation-section.listed route is accessible to authenticated user', function () {
    // Un utente autenticato può accedere alla rotta
    $this->actingAs($this->user)
        ->get(route('federation-section.listed', ['federation' => $this->federation]))
        ->assertStatus(200);
});

test('federation-section.listed displays federation name', function () {
    // La pagina deve visualizzare il nome della federazione
    $this->actingAs($this->user)
        ->get(route('federation-section.listed', ['federation' => $this->federation]))
        ->assertSee($this->federation->name_en);
});

test('federation-section.listed displays federation sections', function () {
    // La pagina deve visualizzare le sezioni della federazione
    $this->actingAs($this->user)
        ->get(route('federation-section.listed', ['federation' => $this->federation]))
        ->assertStatus(200)
        ->assertSee($this->sections[0]->name_en)
        ->assertSee($this->sections[1]->name_en)
        ->assertSee($this->sections[2]->name_en);
});

test('federation-section.listed with FIAF federation', function () {
    // Test specifico per FIAF
    $fiafFederation = Federation::find('FIAF') ?? Federation::factory()->create(['id' => 'FIAF']);
    
    $this->actingAs($this->user)
        ->get(route('federation-section.listed', ['federation' => $fiafFederation]))
        ->assertStatus(200)
        ->assertSee($fiafFederation->name_en);
});

test('federation-section.listed does not show admin-only elements to standard user', function () {
    // Un utente standard non dovrebbe vedere elementi di gestione admin
    // (Se la view contiene bottoni admin, questi non dovrebbero essere visibili)
    $this->actingAs($this->user)
        ->get(route('federation-section.listed', ['federation' => $this->federation]))
        ->assertStatus(200)
        // Verificare che non ci siano link admin (modificare secondo la view effettiva)
        ->assertDontSee('btn-edit'); // o altro selettore specifico della view
});
