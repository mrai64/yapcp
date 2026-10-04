<?php

/**
 * Contest and related models backup (2nd phase)
 *
 * Esegue backup in formato YAML dei modelli correlati a Contest:
 * - ContestJury
 * - ContestParticipant
 * - ContestVote
 * - ContestWaiting
 * - ContestWork
 *
 * Struttura gerarchica:
 * - Contest (padre primo)
 *   - ContestSection (padre secondo)
 *     - ContestJury
 *     - ContestWork
 *       - ContestVote
 *   - ContestParticipant
 *   - ContestWaiting
 *
 */

 namespace App\Jobs\Backups;

 use App\Models\Contest;
 use App\Models\ContestJury;
 use App\Models\ContestParticipant;
 use App\Models\ContestSection;
 use App\Models\ContestVote;
 use App\Models\ContestWaiting;
 use App\Models\ContestWork;
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

class ContestAndRelatedBackup2ndJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Timeout del Job in secondi (es. 20 minuti per concorsi di grandi dimensioni).
     */
    public int $timeout = 1200;

    protected ?Carbon $backupSince;
    protected User $requesterUser;
    protected string $contestId;

    /**
     * Create a new job instance.
     *
     * @param User|null $requesterUser Admin/User richiedente il backup
     * @param DateTimeInterface|string|null $backupSince Data/ora per il backup incrementale
     */
    public function __construct(
        ?User $requesterUser = null,
        DateTimeInterface|string|null $backupSince = null,
        string $contestId
    ) {
        $this->backupSince   = $backupSince ? Carbon::parse($backupSince) : null;
        $this->requesterUser = $requesterUser ?? Auth::user();
        $this->contestId     = $contestId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobName   = class_basename($this);
        Log::info('Job: ' . $jobName . ' -> Avvio processo backup contest e modelli correlati (fase 2).');

        // 1. Controllo Autorizzazioni
        if ($this->requesterUser && !FacadesGate::forUser($this->requesterUser)->allows('access-admin')) {
            Log::warning('Job: ' . $jobName . ' -> Utente non autorizzato: ' . $this->requesterUser->id);
            throw new AuthorizationException(__("Operazione di backup non autorizzata."));
        }

        // 2. Definizione del Path e Stream File
        $timestamp = now()->format('Y-m-d_His');
        $filename  = "{$jobName}_{$timestamp}.yaml";
        $relativePath = "private/backups/{$filename}";

        Storage::disk('local')->makeDirectory('private/backups');
        $fullPath = Storage::disk('local')->path($relativePath);

        $fileHandle = fopen($fullPath, 'w');
        if (!$fileHandle) {
            Log::error('Job: ' . $jobName . ' -> Impossibile aprire il file per la scrittura: ' . $fullPath);
            return;
        }

        Log::info('Job: ' . $jobName . ' -> Scrittura intestazione e metadati YAML.');

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
        fwrite($fileHandle, "contests_related_data:\n");

        // 4. Query Base per i Concorsi
        $contestsQuery = Contest::query()
           ->with([
               'contestSections',
               'participants',
               'waitings',
               'contestWorks',
           ])
           ->orderBy('created_at', 'desc');

        // Filtro concorso - contestId già filtrato da rules()
        Log::info('Job: ' . $jobName . ' -> contestId: (' . $this->contestId . ')');
        if ($this->contestId && $this->contestId != 'all') {
            $contestsQuery->where(function ($q) {
                $q->where('id', $this->contestId);
            });
        }

        // Filtro Incrementale
        if ($this->backupSince) {
            $contestsQuery->where(function ($q) {
                $q->where('updated_at', '>=', $this->backupSince)
                 ->orWhereHas('participants', fn($p) => $p->where('updated_at', '>=', $this->backupSince))
                 ->orWhereHas('waitings', fn($w) => $w->where('updated_at', '>=', $this->backupSince))
                 ->orWhereHas('contestWorks', fn($cw) => $cw->where('updated_at', '>=', $this->backupSince))
                 ->orWhereHas('contestSections.contestJuries', fn($j) => $j->where('updated_at', '>=', $this->backupSince))
                 ->orWhereHas('contestSections', fn($s) => $s->where('updated_at', '>=', $this->backupSince));
            });
        }

        // 5. Elaborazione a blocchi (Chunk) per ottimizzare la memoria RAM
        $contestsQuery->chunk(50, function ($contests) use ($fileHandle) {
            foreach ($contests as $contest) {
                $contestArray = $this->transformContestRelatedDataToBackupArray($contest);

                // Formattazione YAML indentata
                $yamlDump = Yaml::dump([$contestArray], 6, 2);
                $yamlDump = preg_replace('/^---\n/', '', $yamlDump);

                fwrite($fileHandle, $this->indentText($yamlDump, 2));
            }
        });

        fclose($fileHandle);

        Log::info('Job: ' . $jobName . ' -> Backup completato con successo. File salvato in: ' . $relativePath);
    }

    /**
     * Trasforma i dati correlati a Contest in un array strutturato ed esaustivo per il backup.
     * Contiene tutti i campi di tutti i modelli correlati.
     */
    protected function transformContestRelatedDataToBackupArray(Contest $contest): array
    {
        return [
           'contest_id'    => $contest->id,
           'contest_name'  => $contest->name_en,

           // ContestParticipant - Livello Contest
           'participants' => $contest->participants->map(fn($participant) => [
                'id'                      => $participant->id,
                'contest_id'              => $participant->contest_id,
                'user_contact_id'         => $participant->user_contact_id,
                'fee_payment_completed'   => $participant->fee_payment_completed,
                'created_at'              => $participant->created_at?->toIso8601String(),
                'updated_at'              => $participant->updated_at?->toIso8601String(),
                'deleted_at'              => $participant->deleted_at?->toIso8601String(),
            ])->toArray(),

           // ContestWaiting - Livello Contest
           'waitings' => $contest->contestWaitings->map(fn($waiting) => [
                'id'                      => $waiting->id,
                'contest_id'              => $waiting->contest_id,
                'section_id'              => $waiting->section_id,
                'participant_user_id'     => $waiting->participant_user_id,
                'user_work_id'            => $waiting->user_work_id,
                'portfolio_sequence'      => $waiting->portfolio_sequence,
                'email'                   => $waiting->email,
                'because'                 => $waiting->because,
                'organization_user_id'    => $waiting->organization_user_id,
                'created_at'              => $waiting->created_at?->toIso8601String(),
                'updated_at'              => $waiting->updated_at?->toIso8601String(),
                'deleted_at'              => $waiting->deleted_at?->toIso8601String(),
            ])->toArray(),

           // Sezioni e Dati Correlati (ContestJury, ContestWork, ContestVote)
           'sections' => $contest->contestSections->map(fn($section) => [
                'id'                      => $section->id,
                'contest_id'              => $section->contest_id,
                'code'                    => $section->code,
                'under_patronage'         => $section->under_patronage,
                'federation_section_id'   => $section->federation_section_id,
                'name_en'                 => $section->name_en,
                'name_local'              => $section->name_local,
                'synopsis'                => $section->synopsis,
                'file_formats'            => $section->file_formats,
                'min_works'               => $section->min_works,
                'max_works'               => $section->max_works,
                'short_size_max'          => $section->short_size_max,
                'long_size_max'           => $section->long_size_max,
                'file_size_max'           => $section->file_size_max,
                'monochromatic_required'  => $section->monochromatic_required,
                'raw_required'            => $section->raw_required,
                'unique_prize'            => $section->unique_prize,
                'created_at'              => $section->created_at?->toIso8601String(),
                'updated_at'              => $section->updated_at?->toIso8601String(),
                'deleted_at'              => $section->deleted_at?->toIso8601String(),

                // ContestJury - Livello ContestSection
                'juries' => $section->contestJuries->map(fn($jury) => [
                    'id'                  => $jury->id,
                    'contest_id'          => $jury->contest_id,
                    'section_id'          => $jury->section_id,
                    'user_id'             => $jury->user_id,
                    'is_president'        => $jury->is_president,
                    'qualify'             => $jury->qualify,
                    'created_at'          => $jury->created_at?->toIso8601String(),
                    'updated_at'          => $jury->updated_at?->toIso8601String(),
                    'deleted_at'          => $jury->deleted_at?->toIso8601String(),
                ])->toArray(),

                // ContestWork - Livello ContestSection
                'works' => $section->works->map(fn($work) => [
                    'id'                  => $work->id,
                    'contest_id'          => $work->contest_id,
                    'section_id'          => $work->section_id,
                    'country_id'          => $work->country_id,
                    'user_id'             => $work->user_id,
                    'user_work_id'        => $work->user_work_id,
                    'portfolio_sequence'  => $work->portfolio_sequence,
                    'is_admit'            => $work->is_admit,
                    'created_at'          => $work->created_at?->toIso8601String(),
                    'updated_at'          => $work->updated_at?->toIso8601String(),
                    'deleted_at'          => $work->deleted_at?->toIso8601String(),

                    // ContestVote - Livello ContestWork
                    'votes' => ContestVote::where('contest_work_id', $work->id)
                        ->get()
                        ->map(fn($vote) => [
                            'id'                  => $vote->id,
                            'contest_id'          => $vote->contest_id,
                            'section_id'          => $vote->section_id,
                            'contest_work_id'     => $vote->contest_work_id,
                            'juror_user_id'       => $vote->juror_user_id,
                            'vote'                => $vote->vote,
                            'review_required'     => $vote->review_required ?? 0,
                            'created_at'          => $vote->created_at?->toIso8601String(),
                            'updated_at'          => $vote->updated_at?->toIso8601String(),
                            'deleted_at'          => $vote->deleted_at?->toIso8601String(),
                        ])->toArray(),
                ])->toArray(),
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
