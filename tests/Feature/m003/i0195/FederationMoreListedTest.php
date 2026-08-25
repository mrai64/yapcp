<?php

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    // Creazione di un utente admin e di una federazione di riferimento
    $this->user  = User::factory()->create();
    $this->admin = User::factory()->admin()->create();
    $this->federation = Federation::factory()->create();
});

test('federation-more list access by a user', function () {
    $this->actingAs($this->user)
        ->get(route('federation-more.listed', ['federation' => $this->federation]))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});

test('federation-more list access by an admin', function () {
    $this->actingAs($this->admin)
        ->get(route('federation-more.listed', ['federation' => $this->federation]))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});

