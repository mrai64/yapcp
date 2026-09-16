<?php

/**
 * test for import backup User, userContact, userContactMore
 *
 */

use App\Jobs\Backups\UserAndRelatedBackupJob;
use App\Jobs\Imports\ImportUserAndRelatedJob;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserContactMore;
use Illuminate\Support\Facades\DB;
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
    // 1. si creano dati da salvare
    // 2. si crea il file di backup
    // 2.bis si legge il file di backup
    // 2.ter spostamento da disco a disco
    // 3. si svuota la tabella
    // 4. si carica il file
    // 5. s verifica che i dati siano quelli
    //
    // 1. si creano dati da salvare
    $user = User::factory()->create();
    // echo "\n" . '1. user creato';
    $updateOk = $user->contact->update([
        'cellular' => '+393331234567',
        'address' => 'Via Roma 1',
        'city' => 'Roma',
        'region' => 'RM',
        'postal_code' => '00100',
        'lang_code' => 'it',
        'timezone_id' => 'Europe/Rome',
    ]);
    $userContact = $user->contact;
    // echo "\n" . '2. user_contact creato, aggiornato';
    $userContactMore = UserContactMore::factory()->create([
        'user_id'       => $user->id,
        'federation_id' => 'FIAF',
        'field_name'    => 'fiafCardId',
        'field_value'   => '054321',
    ]);
    //
    // 2. si crea il file di backup
    UserAndRelatedBackupJob::dispatchSync(
        requesterUser: $this->admin
    );
    // 2.bis si legge il file di backup
    $files = Storage::disk('local')->files('private/backups');
    expect($files)->not->toBeEmpty();
    // echo "\n" . '2.bis files:';
    // var_dump($files);
    // echo "\n\n" . '$files[0] contains:' . "\n---\n";
    // echo Storage::disk('local')->get($files[0]);
    // echo "\n" . '...';
    expect($files[0])->toContain('UserAndRelatedBackupJob_');
    //
    // 2.ter spostamento da disco a disco
    // Storage::disk('local')->copyToDisk('public', $files[0], 'imports/test_import_valid.txt');
    Storage::disk('public')->makeDirectory('imports');
    Storage::disk('public')->put('imports/test_import_valid.txt', Storage::disk('local')->get($files[0]));

    //
    // 3. si svuota la tabella
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table(UserContactMore::TABLENAME)->truncate();
    DB::table(UserContact::TABLENAME)->truncate();
    DB::table(User::TABLENAME)->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    // truncate rimuove anche admin, un admin è obbligatorio anche se diverso
    $newAdmin = User::factory()->admin()->create();
    $this->actingAs($newAdmin);
    // echo "\n" . '3. clear db';

    //
    // 4. si carica il file
    $importFiles = Storage::disk('public')->files('imports');
    expect($importFiles)->not->toBeEmpty();
    // echo "\n" . '4. files:';
    // var_dump($importFiles);
    // echo "\n\n" . '$importFiles[0] contains:' . "\n---\n";
    // echo Storage::disk('public')->get($importFiles[0]);
    // echo "\n" . '...';
    ImportUserAndRelatedJob::dispatchSync(
        requesterUser: $newAdmin,
        relativeFilePath: $importFiles[0]
    );

    // 5. s verifica che i dati siano quelli
    // echo "\n" . '5. has user:';
    // echo "\n" . 'id:' . $user->id;
    // echo "\n" . 'email:' . $user->email;
    $this->assertDatabaseHas(User::TABLENAME, [
        'id' => $user->id,
        'email' => $user->email,
    ]);

    // echo "\n" . '5. has UserContact:';
    $this->assertDatabaseHas(UserContact::TABLENAME, [
        'id' => $userContact->id,
        'first_name' => $userContact->first_name,
        'last_name' => $userContact->last_name,
        'cellular' => '+393331234567',
    ]);

    // echo "\n" . '5. has UserContactMore:';
    $this->assertDatabaseHas(UserContactMore::TABLENAME, [
        'user_id' => $user->id,
        'federation_id' => 'FIAF',
        'field_value' => '054321',
    ]);

    $reportPath = 'imports/test_import_valid_report.txt';
    Storage::disk('public')->assertExists($reportPath);
    expect(Storage::disk('public')->get($reportPath))->toContain('All works fine');
});

/**
 *
 */
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
    // echo Storage::disk('public')->get($reportPath);
    expect(Storage::disk('public')->get($reportPath))->toContain('does not exist.');
});
