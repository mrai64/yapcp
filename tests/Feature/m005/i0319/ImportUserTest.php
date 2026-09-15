<?php

/**
 * test for backup User, userContact, userContactMore
 *
 */

use App\Jobs\Backups\UserAndRelatedBackupJob;
use App\Jobs\Imports\ImportUserAndRelatedJob;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserContactMore;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;

beforeEach(function () {
    // Isoliamo il file system usando un disco 'local' fittizio
    Storage::fake('local');
    Storage::fake('public');
    // agiamo come admin no User::factory->createAsAdmin() but factory->admin()->create()
    $this->admin = User::factory()->admin()->create();
    $this->actingAs($this->admin);
});

test('esegue l\'importazione con successo creando tutti i record nel database', function () {
    $userId = (string) Str::uuid7();

    $yamlData = [
        'metadata' => [
            'created_at' => now()->toIso8601String(),
            'version' => '1.0',
        ],
        'data' => [
            User::TABLENAME => [
                [
                    'id' => $userId,
                    'name' => 'Mario Rossi',
                    'email' => 'mario.rossi@example.com',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.RAW2Oi1zA',
                    'created_at' => '2026-08-18 15:20:00',
                    'updated_at' => '2026-08-18 15:20:00',
                    'deleted_at' => null,
                ],
            ],
            UserContact::TABLENAME => [
                [
                    'id' => $userId,
                    'country_id' => 'ITA',
                    'first_name' => 'Mario',
                    'last_name' => 'Rossi',
                    'email' => 'mario.rossi@example.com',
                    'cellular' => '+393331234567',
                    'address' => 'Via Roma 1',
                    'city' => 'Roma',
                    'region' => 'Lazio',
                    'postal_code' => '00100',
                    'lang_code' => 'it',
                    'timezone_id' => 'Europe/Rome',
                    'created_at' => '2026-08-18 15:20:00',
                    'updated_at' => '2026-08-18 15:20:00',
                    'deleted_at' => null,
                ],
            ],
            UserContactMore::TABLENAME => [
                [
                    'id' => 999,
                    'user_id' => $userId,
                    'federation_id' => 'FIAF',
                    'field_name' => 'tessera',
                    'field_value' => '123456',
                    'created_at' => '2026-08-18 15:20:00',
                    'updated_at' => '2026-08-18 15:20:00',
                    'deleted_at' => null,
                ],
            ],
        ],
    ];

    $filePath = 'imports/test_import_valid.yaml';
    Storage::disk('public')->put($filePath, Yaml::dump($yamlData, 4, 2));

    ImportUserAndRelatedJob::dispatchSync($this->admin, $filePath);

    $this->assertDatabaseHas(User::TABLENAME, [
        'id' => $userId,
        'email' => 'mario.rossi@example.com',
    ]);

    $this->assertDatabaseHas(UserContact::TABLENAME, [
        'id' => $userId,
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
    ]);

    $this->assertDatabaseHas(UserContactMore::TABLENAME, [
        'id' => 999,
        'user_id' => $userId,
        'federation_id' => 'FIAF',
        'field_value' => '123456',
    ]);

    $reportPath = 'imports/test_import_valid_report.txt';
    Storage::disk('public')->assertExists($reportPath);
    expect(Storage::disk('public')->get($reportPath))->toContain('All works fine');
});

test('aggiorna un utente e i relativi dati esistenti tramite upsert', function () {
    $existingUser = User::factory()->create([
        'name' => 'Nome Originario',
    ]);

    $yamlData = [
        'data' => [
            User::TABLENAME => [
                [
                    'id' => $existingUser->id,
                    'name' => 'Nome Modificato',
                    'email' => $existingUser->email,
                    'password' => $existingUser->password,
                ],
            ],
            UserContact::TABLENAME => [
                [
                    'id' => $existingUser->id,
                    'first_name' => 'Giuseppe',
                    'last_name' => 'Verdi',
                    'email' => $existingUser->email,
                    'country_id' => 'ITA',
                    'cellular' => '+393339999999',
                    'address' => 'Corso Vittorio Emanuele II 15',
                    'city' => 'Milano',
                    'region' => 'Lombardia',
                    'postal_code' => '20121',
                    'lang_code' => 'it',
                    'timezone_id' => 'Europe/Rome',
                ],
            ],
            UserContactMore::TABLENAME => [],
        ],
    ];

    $filePath = 'imports/test_import_update.yaml';
    Storage::disk('public')->put($filePath, Yaml::dump($yamlData, 4, 2));

    ImportUserAndRelatedJob::dispatchSync($this->admin, $filePath);

    $this->assertDatabaseHas(User::TABLENAME, [
        'id' => $existingUser->id,
        'name' => 'Nome Modificato',
    ]);

    $this->assertDatabaseHas(UserContact::TABLENAME, [
        'id' => $existingUser->id,
        'first_name' => 'Giuseppe',
        'last_name' => 'Verdi',
    ]);

    expect(User::where('id', $existingUser->id)->count())->toBe(1);
});

test('gestisce il caso di file inesistente generando il report di errore', function () {
    $filePath = 'imports/file_inesistente.yaml';

    ImportUserAndRelatedJob::dispatchSync($this->admin, $filePath);

    $reportPath = 'imports/file_inesistente_report.txt';
    Storage::disk('public')->assertExists($reportPath);
    expect(Storage::disk('public')->get($reportPath))->toContain('File non trovato');
});
