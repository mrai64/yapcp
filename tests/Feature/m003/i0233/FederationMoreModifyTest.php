<?php

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\FederationMoresReferencedSet;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    // Creazione di un utente admin e di una federazione di riferimento
    $this->admin = User::factory()->admin()->create();
    $this->federation = Federation::factory()->create();
    $this->federationMore = FederationMore::factory()->create(
      [
        'referenced' => 'user_work_mores',
        'federation_id' => $this->federation->id,
      ]
    );
});

test('federation-more modify access by an admin', function () {
    $this->actingAs($this->admin)
        ->get(route('federation-more.modify', ['federation_more' => $this->federationMore]))
        ->assertStatus(200)
        ->assertSee($this->federation->name_en);
});

