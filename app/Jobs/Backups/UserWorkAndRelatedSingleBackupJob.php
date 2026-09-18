<?php

/**
 * Create a yaml file with export of all
 * - User
 * - UserContact
 * - UserWork
 * - UserWorkMore
 *
 * The contents of file are used for archive restoration.
 * For user_works.file_path, an additional url_path field is generated.
 */

namespace App\Jobs\Backups;

use App\Models\User;
use App\Models\UserContact;
use App\Models\UserWork;
use App\Models\UserWorkMore;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Auth\Access\AuthorizationException;
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

class UserWorkAndRelatedSingleBackupJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    // Data e ora per il backup incrementale (opzionale).
    protected ?Carbon $backupSince;
    // Richiedente
    protected ?User $requesterUser;

    protected ?User $backuppedUser;

    /**
     * Create a new job instance.
     *
     * @param User|null $requesterUser admin che ha richiesto il backup
     * @param DateTimeInterface|string|null $backupSince Data/ora opzionale per il backup incrementale
     */
    public function __construct(
        User $requesterUser, // not null
        User|null $backuppedUser = null,
        DateTimeInterface|string|null $backupSince = null
    ) {
        // assignment
        $this->backupSince   = $backupSince ? Carbon::parse($backupSince) : null;
        $this->requesterUser = $requesterUser ?? Auth::user();
        $this->backuppedUser = $backuppedUser ?? null;
        // log
        $jobName = class_basename($this);
        Log::info('Requested job: ' . $jobName . ' / construct backuppedUser  ' . json_encode($this->backuppedUser));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobName = class_basename($this);
        Log::info('Requested job: ' . $jobName . ' / 1. started');

        // 0. Verifica abilitazione
        if ($this->requesterUser && ! FacadesGate::forUser($this->requesterUser)->allows('access-admin')) {
            Log::info('Requested job: ' . $jobName . ' / 2. Unauthorized');
            throw new AuthorizationException(
                message: __("Backup unauthorized")
            );
        }
        Log::info('Requested job: ' . $jobName . ' / 1. since ' . ($this->backupSince ? $this->backupSince : 'ever'));
        Log::info('Requested job: ' . $jobName . ' / 1. from  ' . $this->requesterUser->name);
        Log::info('Requested job: ' . $jobName . ' / 1. for   ' . json_encode($this->backuppedUser ?? (string) 'all'));

        // 1. Inizializzazione del file di output
        $jobName = class_basename($this);
        $timestamp = now()->format('Y-m-d_His');
        $filename = "{$jobName}_{$timestamp}.yaml";
        $relativePath = "private/backups/{$filename}";

        // Assicura l'esistenza della cartella di destinazione
        Storage::disk('local')->makeDirectory('private/backups');
        $fullPath = Storage::disk('local')->path($relativePath);

        // Apertura stream in scrittura su file
        $fileHandle = fopen($fullPath, 'w');
        Log::info('Requested job: ' . $jobName . ' / 2. output opened');

        // 2. Scrittura Metadata
        $metadata = [
            'metadata' => [
                'job' => static::class,
                'created_at' => now()->toIso8601String(),
                'incremental' => $this->backupSince !== null,
                'backup_since' => $this->backupSince?->toIso8601String(),
                'for' => $this->backuppedUser->name ?? (string) 'all',
                'requester admin' => [
                    'name' => $this->requesterUser?->name,
                    'id' => $this->requesterUser?->id,
                ],
            ]
        ];
        fwrite($fileHandle, Yaml::dump($metadata, 4, 2));
        fwrite($fileHandle, "#\n# Note: all datetime values are in UTC.\n#\n");
        fwrite($fileHandle, "data:\n");
        Log::info('Requested job: ' . $jobName . ' / 3. headers written');

        // 3. Query Base con Eager Loading per User, UserWork e UserWorkMore
        $contactsQuery = UserContact::query()
            ->withTrashed()
            ->with([
                'user' => fn ($query) => $query->withTrashed(),
                'userWorks' => fn ($query) => $query->withTrashed(),
                'userWorks.userWorkMore' => fn ($query) => $query->withTrashed(),
                ])
            ->orderBy('country_id', 'asc')
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->orderBy('created_at', 'asc');

        if ($this->backuppedUser) {
            Log::info('Requested job: ' . $jobName . ' / 3. add query for an id');
            $contactsQuery->where(function ($q) {
                $q->where('id', $this->backuppedUser->id);
            });
        }

        if ($this->backupSince) {
            Log::info('Requested job: ' . $jobName . ' / 3. add query for backupSince');
            $contactsQuery->where(function ($q) {
                $q->where('updated_at', '>=', $this->backupSince)
                  ->orWhereHas('user', fn($u) => $u->where('updated_at', '>=', $this->backupSince))
                  ->orWhereHas('userWorks', fn($w) => $w->where('updated_at', '>=', $this->backupSince))
                  ->orWhereHas('userWorks.userWorkMore', fn($m) => $m->where('updated_at', '>=', $this->backupSince));
            });
        }

        Log::info('Requested job: ' . $jobName . ' / 4. query ready');

        // 4. Elaborazione lazy a blocchi per ottimizzare la memoria
        $contactsLazy = $contactsQuery->lazy(100);
        Log::info('Requested job: ' . $jobName . ' / 5. query done');

        // --- Scrittura Sezione User ---
        fwrite($fileHandle, "  " . User::TABLENAME . ":\n");
        foreach ($contactsLazy as $contact) {
            if ($contact->user) {
                $userData = $contact->user->getAttributes();
                $yamlRecord = Yaml::dump([$userData], 4, 2);
                fwrite($fileHandle, $this->indentYamlBlock($yamlRecord, 4));
            }
        }
        Log::info('Requested job: ' . $jobName . ' / 6. written block for: ' . User::TABLENAME);

        // --- Scrittura Sezione UserContact ---
        fwrite($fileHandle, "  " . UserContact::TABLENAME . ":\n");
        foreach ($contactsLazy as $contact) {
            $contactData = $contact->unsetRelation('user')
                ->unsetRelation('userWorks')
                ->getAttributes();

            $yamlRecord = Yaml::dump([$contactData], 4, 2);
            fwrite($fileHandle, $this->indentYamlBlock($yamlRecord, 4));
        }
        Log::info('Requested job: ' . $jobName . ' / 7. written block for: ' . UserContact::TABLENAME);

        // --- Scrittura Sezione UserWork ---
        fwrite($fileHandle, "  " . UserWork::TABLENAME . ":\n");
        foreach ($contactsLazy as $contact) {
            foreach ($contact->userWorks as $work) {
                $attributes = $work->unsetRelation('userWorkMore')->getAttributes();

                // Costruzione dell'array dei campi inserendo url_path subito dopo file_path
                $workData = [];
                foreach ($attributes as $key => $value) {
                    $workData[$key] = $value;
                    if ($key === 'file_path') {
                        $workData['url_path'] = 'https://yapcp.test/photos/' . $value;
                    }
                }

                // Fallback nel caso in cui file_path fosse assente nelle chiavi
                if (! array_key_exists('url_path', $workData) && isset($attributes['file_path'])) {
                    $workData['url_path'] = 'https://yapcp.test/photos/' . $attributes['file_path'];
                }

                $yamlRecord = Yaml::dump([$workData], 4, 2);
                fwrite($fileHandle, $this->indentYamlBlock($yamlRecord, 4));
            }
        }
        Log::info('Requested job: ' . $jobName . ' / 8. written block for: ' . UserWork::TABLENAME);

        // --- Scrittura Sezione UserWorkMore ---
        fwrite($fileHandle, "  " . UserWorkMore::TABLENAME . ":\n");
        foreach ($contactsLazy as $contact) {
            foreach ($contact->userWorks as $work) {
                foreach ($work->userWorkMore as $more) {
                    $moreData = $more->getAttributes();
                    $yamlRecord = Yaml::dump([$moreData], 4, 2);
                    fwrite($fileHandle, $this->indentYamlBlock($yamlRecord, 4));
                }
            }
        }
        Log::info('Requested job: ' . $jobName . ' / 9. written block for: ' . UserWorkMore::TABLENAME);

        // Chiusura dello stream
        fclose($fileHandle);
        Log::info('Requested job: ' . $jobName . ' / 10. closed file');
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
