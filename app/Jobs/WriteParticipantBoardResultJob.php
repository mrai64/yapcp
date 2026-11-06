<?php

/**
 * Build, if not present a static html file with
 *   contest infos then participants results list
 *
 */

namespace App\Jobs;

use App\Models\Contest;
use App\Models\ContestParticipant;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class WriteParticipantBoardResultJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $timeout = 300;
    protected Contest $contest;

    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    public function handle(): void
    {
        $jobName = class_basename($this);
        //
        try {
            $isAfterRevelations = true || now()->greaterThan($this->contest->day_5_revelations);
            $sections = $this->contest->contestSections()->orderBy('code')->get();
            Log::info($jobName . ' 1');

            $baseQuery = ContestParticipant::where('contest_id', $this->contest->id)
                ->with(['userContact.country'])
                ->join('user_contacts', 'contest_participants.user_contact_id', '=', 'user_contacts.id')
                ->select('contest_participants.*')
                ->orderBy('user_contacts.country_id')
                ->orderBy('user_contacts.last_name')
                ->orderBy('user_contacts.first_name');

            Log::info($jobName . ' 2');

            foreach ($sections as $section) {
                $sectionCode = $section->code;

                $baseQuery->withCount([
                    'contestWorks as section_' . $sectionCode . '_works_count' => function ($q) use ($section) {
                        $q->where('section_id', $section->id);
                    }
                ]);

                $admitCondition = function ($q) use ($section) {
                    $q->where('section_id', $section->id)->where('is_admit', 1);
                };

                if (!$isAfterRevelations) {
                    $admitCondition = function ($q) use ($section) {
                        $q->where('section_id', $section->id)->whereRaw('0 = 1');
                    };
                }

                $baseQuery->withCount([
                    'contestWorks as section_' . $sectionCode . '_admit_count' => $admitCondition
                ]);
            }

            // GESTIONE A TRANCHE ESPLICITA (Chunking)
            // Usiamo chunkById specificando la tabella per evitare ambiguità sull'ID a causa della join
            $participantsCollection = collect();
            Log::info($jobName . ' 3');

            /**
             *
            $baseQuery->chunkById(200, function ($participantsChunk) use ($participantsCollection) {
                foreach ($participantsChunk as $participant) {
                    $participantsCollection->push($participant);
                }
            }, 'contest_participants.id'); // Specifichiamo la chiave primaria corretta
             *
             */

            foreach ($baseQuery->lazy(200) as $participant) {
                $participantsCollection->push($participant);
            }

            Log::info($jobName . ' 4');

            // Compilazione della vista Blade statica con la collezione completa ma sicura per la memoria
            $html = view('exports.contest-participants-static', [
                'contest'              => $this->contest,
                'organization'         => $this->contest->organization,
                'contestSections'      => $sections,
                'contestParticipants'  => $participantsCollection,
                'isAfterRevelations'   => $isAfterRevelations,
                'generatedAt'          => now()->timezone("UTC")->toIso8601String(),
            ])->render();

            Log::info($jobName . ' 5');

            // 3. Salvataggio del file HTML nella cartella public
            $directory = public_path("contests/{$this->contest->id}");

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $filePath = $directory . '/participants_board.html';
            File::put($filePath, $html);

            Log::info($jobName . ": END Static Participation Board html page for contest ID: {$this->contest->id} in {$filePath}");
        } catch (\Exception $e) {
            Log::error($jobName . ": Error in _ Participation Board static html page generation _ for contest-id {$this->contest->id}: " . $e->getMessage());
            throw $e;
        }
    }
}
