<?php

/**
 * Contest and related models backup
 *
 */

namespace App\Jobs\Backups;

use App\Models\Contest;
use App\Models\User;
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

class ContestAndRelatedBackup1stJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Timeout del Job in secondi (es. 15 minuti per concorsi di grandi dimensioni).
     */
    public int $timeout = 900;

    protected ?Carbon $backupSince;
    protected User $requesterUser;

    /**
     * Create a new job instance.
     *
     * @param User|null $requesterUser Admin/User richiedente il backup
     * @param DateTimeInterface|string|null $backupSince Data/ora per il backup incrementale
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
        Log::info('Job: ' . class_basename($this) . ' -> Avvio processo backup concorsi.');

        // 1. Controllo Autorizzazioni
        if ($this->requesterUser && ! FacadesGate::forUser($this->requesterUser)->allows('access-admin')) {
            Log::warning('Job: ' . class_basename($this) . ' -> Utente non autorizzato: ' . $this->requesterUser->id);
            throw new AuthorizationException(__("Operazione di backup non autorizzata."));
        }

        // 2. Definizione del Path e Stream File
        $jobName   = class_basename($this);
        $timestamp = now()->format('Y-m-d_His');
        $filename  = "{$jobName}_{$timestamp}.yaml";
        $relativePath = "private/backups/{$filename}";

        Storage::disk('local')->makeDirectory('private/backups');
        $fullPath = Storage::disk('local')->path($relativePath); // /storage/private/private/backups/

        $fileHandle = fopen($fullPath, 'w');
        if (!$fileHandle) {
            Log::error('Job: ' . class_basename($this) . ' -> Impossibile aprire il file per la scrittura: ' . $fullPath);
            return;
        }

        Log::info('Job: ' . class_basename($this) . ' -> Scrittura intestazione e metadati YAML.');

        // 3. Scrittura Metadati
        $metadata = [
            'metadata' => [
                'job'          => static::class,
                'created_at'   => now()->toIso8601String(),
                'incremental'  => $this->backupSince !== null,
                'backup_since' => $this->backupSince?->toIso8601String(),
                'requester'    => [
                    'id'   => $this->requesterUser->id,
                    'name' => $this->requesterUser->name ?? $this->requesterUser->email,
                ],
            ]
        ];

        fwrite($fileHandle, Yaml::dump($metadata, 4, 2));
        fwrite($fileHandle, "#\n# Note: datetime values are exported in ISO-8601 UTC.\n#\n");
        fwrite($fileHandle, "contests:\n");

        // 4. Query Base per i Concorsi e Relazioni
        $contestsQuery = Contest::query()
            ->with([
                'organization:id,name,email,country_id',
                'contestSections',
                'contestPatronage.federation',
                'awards',
                'contestSections.contestJuries.userContact', // Giuria per Sezione con Anagrafica
            ])
            ->orderBy('created_at', 'desc');

        // Filtro Incrementale
        if ($this->backupSince) {
            $contestsQuery->where(function ($q) {
                $q->where('updated_at', '>=', $this->backupSince)
                  ->orWhereHas('contestSections', fn($s) => $s->where('updated_at', '>=', $this->backupSince))
                  ->orWhereHas('contestPatronage', fn($p) => $p->where('updated_at', '>=', $this->backupSince))
                  ->orWhereHas('awards', fn($a) => $a->where('updated_at', '>=', $this->backupSince));
            });
        }

        // 5. Elaborazione a blocchi (Chunk) per ottimizzare la memoria RAM
        $contestsQuery->chunk(50, function ($contests) use ($fileHandle) {
            foreach ($contests as $contest) {
                $contestArray = $this->transformContestToBackupArray($contest);

                // Formattazione YAML indentata sotto "contests:"
                $yamlDump = Yaml::dump([$contestArray], 6, 2);

                // Pulizia della prima riga se contiene l'indicatore di inizio documento di Symfony Yaml
                $yamlDump = preg_replace('/^---\n/', '', $yamlDump);

                fwrite($fileHandle, $this->indentText($yamlDump, 2));
            }
        });

        fclose($fileHandle);

        Log::info('Job: ' . class_basename($this) . ' -> Backup completato con successo. File salvato in: ' . $relativePath);
    }

    /**
     * Trasforma l'istanza Contest in un array strutturato ed esaustivo per il controllo umano.
     */
    protected function transformContestToBackupArray(Contest $contest): array
    {
        return [
            'id'                  => $contest->id,
            'name_en'             => $contest->name_en,
            'is_circuit'          => $contest->is_circuit,
            'circuit_id'          => $contest->circuit_id,
            'country_id'          => $contest->country_id,
            'vote_rule'           => $contest->vote_rule,
            'dates' => [
                'day_1_opening'      => $contest->day_1_opening?->toIso8601String(),
                'day_2_closing'      => $contest->day_2_closing?->toIso8601String(),
                'day_3_jury_opening' => $contest->day_3_jury_opening?->toIso8601String(),
                'day_4_jury_closing' => $contest->day_4_jury_closing?->toIso8601String(),
                'day_5_revelations'  => $contest->day_5_revelations?->toIso8601String(),
                'day_6_awards'       => $contest->day_6_awards?->toIso8601String(),
                'day_7_catalogues'   => $contest->day_7_catalogues?->toIso8601String(),
                'day_8_closing'      => $contest->day_8_closing?->toIso8601String(),
            ],
            'organization' => $contest->organization ? [
                'id'       => $contest->organization->id,
                'name'     => $contest->organization->name,
                'email'    => $contest->organization->email,
                'country'  => $contest->organization->country_id,
            ] : null,

            // Patrocini
            'patronages' => $contest->contestPatronage->map(fn($patronage) => [
                'id'             => $patronage->id,
                'federation_id'  => $patronage->federation_id,
                'patronage_code' => $patronage->patronage_code,
            ])->toArray(),

            // Sezioni & Giuria integrata
            'sections' => $contest->contestSections->map(fn($section) => [
                'id'                      => $section->id,
                'code'                    => $section->code,
                'name_en'                 => $section->name_en,
                'under_patronage'         => $section->under_patronage,
                'monochromatic_required'  => $section->monochromatic_required,
                'raw_required'            => $section->raw_required,
                'rules' => [
                    'min_works'      => $section->min_works,
                    'max_works'      => $section->max_works,
                    'short_size_max' => $section->short_size_max,
                    'long_size_max'  => $section->long_size_max,
                    'file_size_max'  => $section->file_size_max,
                ],
                'juries' => $section->contestJuries->map(fn($jury) => [
                    'id'           => $jury->id,
                    'user_id'      => $jury->user_id,
                    'is_president' => $jury->is_president,
                    'qualify'      => $jury->qualify,
                    'contact_info' => $jury->userContact ? [
                        'first_name' => $jury->userContact->first_name,
                        'last_name'  => $jury->userContact->last_name,
                        'email'      => $jury->userContact->email,
                        'country_id' => $jury->userContact->country_id,
                    ] : null,
                ])->toArray(),
            ])->toArray(),

            // Premi e Riconoscimenti
            'awards' => $contest->awards->map(fn($award) => [
                'id'             => $award->id,
                'section_id'     => $award->section_id,
                'section_code'   => $award->section_code,
                'award_code'     => $award->award_code,
                'award_name'     => $award->award_name,
                'is_award'       => $award->is_award,
                'winner_user_id' => $award->winner_user_id,
                'winner_work_id' => $award->winner_work_id,
                'winner_name'    => $award->winner_name,
            ])->toArray(),
        ];
    }

    /**
     * Aggiunge l'indentazione corretta per la formattazione YAML ad albero.
     */
    protected function indentText(string $text, int $spaces = 2): string
    {
        $indentation = str_repeat(' ', $spaces);
        return $indentation . str_replace("\n", "\n" . $indentation, rtrim($text)) . "\n";
    }
}
