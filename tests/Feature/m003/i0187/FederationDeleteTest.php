<?php

/**
 * Pest test for FederationDeletePolicy
 *
 * info:
 *   bash: vendor/bin/pest tests/Feature/m003/i0114/FederationDeletePolicyTest.php
 *   bash: vendor/bin/pest tests/Feature/m003/i0187/FederationDeleteTest.php
 */

use App\Models\Contest;
use App\Models\Federation;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    // 1. Utente Normale
    $this->user = User::factory()->create();
    // 2. Utente Admin
    $this->admin = User::factory()->admin()->create();
    // 3. Federazione di test (senza concorsi attivi di default)
    $this->federation = Federation::factory()->create();
    // Log::info('§TEST ' . __FILE__ . ' federation ' . $this->federation->id);
});

test('policy denies admin when active contests present', function () {
    $now = now();

    // Creazione concorso attivo legato alla federazione
    $contest = Contest::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'country_id' => 'ITA',
        'day_1_opening' => $now->copy()->subDays(5),
        'day_8_closing' => $now->copy()->addDays(5), // Attivo
        'timezone_id' => 'Europe/Rome',
    ]);

    // Associa il concorso alla federazione tramite la tabella pivot contest_patronages
    $this->federation->contests()->attach($contest->id, ['patronage_code' => 'PAT-123']);

    expect($this->admin->can('delete', $this->federation))->toBeFalse();
});

/*
|--------------------------------------------------------------------------
| Feature / Route Tests (Volt Route)
|--------------------------------------------------------------------------
*/

test('delete endpoint returns 403 for non-admin user', function () {
    // Tenta di accedere alla rotta con l'utente non admin
    $response = $this->actingAs($this->user)
        ->get(route('federation.remove', $this->federation));

    // Il middleware 'can:delete,federation' blocca con 403
    $response->assertStatus(403);

    // Verifica che la federazione non sia stata eliminata
    $this->assertDatabaseHas('federations', ['id' => $this->federation->id]);
});

test('delete endpoint access allowed when no active contests and user is admin', function () {
    // L'admin accede alla rotta della federazione senza concorsi attivi
    $response = $this->actingAs($this->admin)
        ->get(route('federation.remove', $this->federation));

    // La policy permette l'accesso (HTTP 200 OK)
    $response->assertStatus(200);
});

test('delete endpoint returns 403 when active contests are present even for admin', function () {
    $now = now();

    // Crea concorso attivo legato alla federazione
    $contest = Contest::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'country_id' => 'ITA',
        'day_1_opening' => $now->copy()->subDays(5),
        'day_8_closing' => $now->copy()->addDays(5),
        'timezone_id' => 'Europe/Rome',
    ]);
    $this->federation->contests()->attach($contest->id, ['patronage_code' => 'PAT-123']);

    // Anche se admin, la presenza del concorso attivo fa fallire la policy
    $response = $this->actingAs($this->admin)
        ->get(route('federation.remove', $this->federation));

    // Il middleware 'can:delete,federation' restituisce 403 Forbidden
    $response->assertStatus(403);
    $this->assertDatabaseHas('federations', ['id' => $this->federation->id]);
});

test('delete endpoint returns 200 when no active contests are present, for admin', function () {
    // Anche se admin, la presenza del concorso attivo fa fallire la policy
    $response = $this->actingAs($this->admin)
        ->get(route('federation.remove', $this->federation));

    // Il middleware 'can:delete,federation' restituisce 200 Ok
    $response->assertStatus(200);
    // Questa non funziona perché delegata al job
    // $this->assertDatabaseMissing('federations', ['id' => $this->federation->id]);
});
