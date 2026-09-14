<?php

/**
 * test for backup User, userContact, userContactMore
 *
 */

use App\Jobs\Backups\UserAndRelatedBackupJob;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserContactMore;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;

beforeEach(function () {
    // Isoliamo il file system usando un disco 'local' fittizio
    Storage::fake('local');
    // agiamo come admin no User::factory->createAsAdmin() but factory->admin()->create()
    $this->admin = User::factory()->admin()->create();
    $this->actingAs($this->admin);
});

test('esegue il backup completo creando il file yaml corretto', function () {
    // 1. Arrange: Creiamo un utente con i relativi contatti
    $user = User::factory()->create();
    $userContact = $user->contact;

    // 2. Act: Eseguiamo il Job in modo sincrono
    UserAndRelatedBackupJob::dispatchSync(requesterUser: $this->admin);

    // 3. Assert: Verifichiamo che il file sia stato generato nella cartella corretta
    $files = Storage::disk('local')->files('private/backups');

    expect($files)->not->toBeEmpty();
    expect($files[0])->toContain('UserAndRelatedBackupJob_');

    // Leggiamo il contenuto YAML per confermare la presenza dei dati
    $content = Storage::disk('local')->get($files[0]);
    $parsedYaml = Yaml::parse($content);

    expect($parsedYaml)->toHaveKeys(['metadata', 'data'])
        ->and($parsedYaml['data'])->toHaveKeys([
            User::TABLENAME,
            UserContact::TABLENAME,
            UserContactMore::TABLENAME,
        ]);
});

test('esegue il backup incrementale filtrando per data', function () {
    // Record vecchio di 10gg (non deve comparire)
    $this->travelTo(now()->subDays(10));
    $oldUser = User::factory()->create();

    // Record recente (deve comparire)
    $this->travelBack(); // a dispetto del nome back torniamo al presente
    $newUser = User::factory()->create();

    // Lanciamo il backup per le modifiche degli ultimi 5 giorni
    UserAndRelatedBackupJob::dispatchSync(requesterUser: $this->admin, backupSince: now()->subDays(5));

    $files = Storage::disk('local')->files('private/backups');
    $parsedYaml = Yaml::parse(Storage::disk('local')->get($files[0]));
    // echo "\n\n" . var_dump($parsedYaml);

    $exportedUserIds = collect($parsedYaml['data'][User::TABLENAME])->pluck('id')->toArray();
    // echo "\nnew user" . ($newUser->id) . ' name:' . $newUser->name;
    // echo "\nold user" . ($oldUser->id) . ' name:' . $oldUser->name;
    // echo "\n\n" . var_dump($exportedUserIds);

    expect($exportedUserIds)->toContain($newUser->id)
        ->and($exportedUserIds)->not->toContain($oldUser->id);
});
