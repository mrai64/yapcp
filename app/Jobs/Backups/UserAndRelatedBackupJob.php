<?php

/**
 * Create a yaml file with export of all
 * - User
 * - UserContact
 * - UserContactMore
 * the contest of file is limited to the format
 * field_name: field_value
 *
 */

namespace App\Jobs\Backups;

use App\Models\User;
use App\Models\UserContact;
use App\Models\UserContactMore;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Gate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;

class UserAndRelatedBackupJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Data e ora per il backup incrementale (opzionale).
     */
    protected ?Carbon $backupSince;
    // Richiedente
    protected User $requesterUser;

    /**
     * Create a new job instance.
     *
     * @param User $requesterUser admin che ha richiesto il backup
     * @param DateTimeInterface|string|null $backupSince Data/ora opzionale per il backup incrementale
     */
    public function __construct(
        ?User $requesterUser = null,
        DateTimeInterface|string|null $backupSince = null
    ) {
        $this->backupSince   = $backupSince ? Carbon::parse($backupSince) : null;
        $this->requesterUser = $requesterUser ?? Auth::user();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Requested job: ' . class_basename($this) . ' / 1. started');
        // 0. verifica abilitazione - no ->authorize()
        if ($this->requesterUser && ! FacadesGate::forUser($this->requesterUser)->allows('access-admin')) {
            Log::info('Requested job: ' . class_basename($this) . ' / 2. Unauthorized');
            throw new AuthorizationException(
                message: __("Backup unauthorized")
            );
        }
        //
        // 1. Inizializzazione delle query per i modelli
        $jobName = class_basename($this);
        $timestamp = now()->format('Y-m-d_His');
        $filename = "{$jobName}_{$timestamp}.yaml";
        $relativePath = "private/backups/{$filename}";

        // Assicura l'esistenza della cartella di destinazione
        Storage::disk('local')->makeDirectory('backups');
        $fullPath = Storage::disk('local')->path($relativePath);

        // Apriamo lo stream in scrittura su file
        $fileHandle = fopen($fullPath, 'w');
        Log::info('Requested job: ' . class_basename($this) . ' / 2. output opened');

        // 1. Scrittura Metadata
        $metadata = [
            'metadata' => [
                'job' => static::class,
                'created_at' => now()->toIso8601String(),
                'incremental' => $this->backupSince !== null,
                'backup_since' => $this->backupSince?->toIso8601String(),
                'requester admin' => [
                    'name' => $this->requesterUser->name,
                    'id' => $this->requesterUser->id,
                ],
            ]
        ];
        fwrite($fileHandle, Yaml::dump($metadata, 4, 2));
        fwrite($fileHandle, "#\n# Note: all datetime values are in UTC.\n#\n");
        fwrite($fileHandle, "data:\n");
        Log::info('Requested job: ' . class_basename($this) . ' / 3. headers written');

        // 2. Query Base
        $contactsQuery = UserContact::query()
            ->with(['user', 'contactMores'])
            ->orderBy('country_id', 'asc')
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->orderBy('created_at', 'asc');

        if ($this->backupSince) {
            $contactsQuery->where(function ($q) {
                $q->where('updated_at', '>=', $this->backupSince)
                  ->orWhereHas('user', fn($u) =>$u->where('updated_at', '>=', $this->backupSince))
                  ->orWhereHas('contactMores', fn($m) =>$m->where('updated_at', '>=', $this->backupSince));
            });
        }

        Log::info('Requested job: ' . class_basename($this) . ' / 4. query ready');
        // 3. Elaborazione a blocchi di memoria con lazy()
        // lazy(100) recupera 100 record alla volta dal DB usando i LazyCollection
        $contactsLazy = $contactsQuery->lazy(100);

        Log::info('Requested job: ' . class_basename($this) . ' / 5. query done');

        // Scrittura Sezione User
        fwrite($fileHandle, "  " . User::TABLENAME . ":\n");
        foreach ($contactsLazy as $contact) {
            if ($contact->user) {
                $userData = $contact->user->getAttributes();

                // Converte il singolo record e formatta con l'indentazione corretta per lo YAML
                $yamlRecord = Yaml::dump([$userData], 4, 2);
                fwrite($fileHandle, $this->indentYamlBlock($yamlRecord, 4));
            }
        }
        Log::info('Requested job: ' . class_basename($this) . ' / 6. written block for: ' . User::TABLENAME);

        // Scrittura Sezione UserContact
        fwrite($fileHandle, "  " . UserContact::TABLENAME . ":\n");
        foreach ($contactsLazy as $contact) {
            $contactData = $contact->unsetRelation('user')->unsetRelation('contactMores')->getAttributes();
            $yamlRecord = Yaml::dump([$contactData], 4, 2);
            fwrite($fileHandle, $this->indentYamlBlock($yamlRecord, 4));
        }
        Log::info('Requested job: ' . class_basename($this) . ' / 7. written block for: ' . UserContact::TABLENAME);

        // Scrittura Sezione UserContactMore
        fwrite($fileHandle, "  " . UserContactMore::TABLENAME . ":\n");
        foreach ($contactsLazy as $contact) {
            foreach ($contact->contactMores as $more) {
                $moreData = $more->getAttributes();
                $yamlRecord = Yaml::dump([$moreData], 4, 2);
                fwrite($fileHandle, $this->indentYamlBlock($yamlRecord, 4));
            }
        }
        Log::info('Requested job: ' . class_basename($this) . ' / 9. written block for: ' . UserContactMore::TABLENAME);

        // Chiusura dello stream
        fclose($fileHandle);
        Log::info('Requested job: ' . class_basename($this) . ' / 10. closed file ');
    }

    /**
     * Helper per ri-indentare le righe YAML generate per il singolo record
     */
    private function indentYamlBlock(string $yaml, int $spaces = 4): string
    {
        $indentation = str_repeat(' ', $spaces);
        $lines = explode("\n", rtrim($yaml));

        $indentedLines = array_map(function ($line) use ($indentation) {
            return $indentation . $line;
        }, $lines);

        return implode("\n", $indentedLines) . "\n";
    }
}
