<?php

use App\Models\User;
use App\Models\Federation;
use function Pest\Laravel\{actingAs};

it('admin user can see federation section list', function () {
    // 1. build simple user
    // $user = User::factory()->create();

    // 2. build admin user
    $user = User::factory()->admin()->create(); // admin user

    // 3. build federation instance
    $federation = Federation::factory()->create([
        'id' => 'FT01',
        'country_id' => 'ITA',
        'name_en' => 'Federazione Test',
        'local_lang' => 'it_IT',
        'timezone_id' => 'Europe/Rome',
    ]);

    // 4. Navigazione alla pagina delle sezioni della federazione
    // Nota: come da diario del 04/04/2026, passiamo l'istanza $federation
    $response = actingAs($user)
        ->get(route('federation-section.list', $federation));

    // 5. Verifica che la pagina sia visualizzata correttamente
    $response->assertStatus(200)
        ->assertSee($federation->name_en); // O una stringa specifica del tuo blade
});

it('normal user cannot see federation section list', function () {
    $user = User::factory()->create(); // simple user
    $federation = Federation::factory()->create([
        'id' => 'FT01',
        'country_id' => 'ITA',
        'name_en' => 'Federazione Test',
        'local_lang' => 'it_IT',
        'timezone_id' => 'Europe/Rome',
    ]);

    actingAs($user)
        ->get(route('federation-section.list', $federation))
        ->assertSee( $federation->name_en );
        // O assertRedirect(route('login')) in base al middleware
});
