<?php

use App\Models\User;
use App\Models\Federation;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, get};

uses(Tests\TestCase::class, RefreshDatabase::class);

it('consente a un amministratore di visualizzare le sezioni di una federazione', function () {
    // 1. Creazione di un utente
    $user = User::factory()->create();

    // 2. Associazione al gruppo admin
    // Basato sul diario del 22/09/2025 e 21/03/2026, creiamo il record del ruolo.
    // Se usi un sistema personalizzato o un trait, adatta questa riga.
    UserRole::factory()->create([
        'user_id' => $user->id,
        'role' => 'admin',
    ]);

    // 3. Creazione di una federazione
    $federation = Federation::factory()->create([
        'name' => 'Federazione Test',
        'code' => 'FT01',
    ]);

    // 4. Navigazione alla pagina delle sezioni della federazione
    // Nota: come da diario del 04/04/2026, passiamo l'istanza $federation
    $response = actingAs($user)
        ->get(route('federation.sections', $federation));

    // 5. Verifica che la pagina sia visualizzata correttamente
    $response->assertStatus(200)
        ->assertSee($federation->name)
        ->assertSee('Sezioni'); // O una stringa specifica del tuo blade
});

it('impedisce l\'accesso alle sezioni della federazione agli utenti non admin', function () {
    $user = User::factory()->create();
    $federation = Federation::factory()->create();

    actingAs($user)
        ->get(route('federation.sections', $federation))
        ->assertForbidden(); // O assertRedirect(route('login')) in base al middleware
});
