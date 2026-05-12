<?php

namespace Database\Seeders;

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestWork;
use Illuminate\Database\Seeder;

class ContestAwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Assicuriamoci che esistano dei concorsi su cui lavorare
        $contests = Contest::all();
        if ($contests->isEmpty()) {
            $contests = Contest::factory()->count(2)->create();
        }

        foreach ($contests as $contest) {
            // 2. Per ogni sezione del concorso (es. DIG, BN, etc.)
            $sections = $contest->sections;

            foreach ($sections as $section) {
                // 3. Generiamo 3 premi per ogni sezione
                for ($i = 1; $i <= 3; $i++) {
                    // Costruiamo un award_code che includa il codice sezione per l'unicità
                    $awardCode = $section->code . '-P' . $i;

                    // Creiamo il premio solo se non esiste già per questo concorso
                    if (!ContestAward::where('contest_id', $contest->id)->where('award_code', $awardCode)->exists()) {

                        // Tenta di trovare un'opera partecipante a caso in questa sezione per assegnare il premio
                        $winner = ContestWork::where('contest_id', $contest->id)
                            ->where('section_id', $section->id)
                            ->inRandomOrder()
                            ->first();

                        ContestAward::factory()->create([
                            'contest_id'     => $contest->id,
                            'section_id'     => $section->id,
                            'section_code'   => $section->code,
                            'award_code'     => $awardCode,
                            'winner_work_id' => $winner ? $winner->user_work_id : null,
                            'winner_user_id' => $winner ? $winner->user_id : null,
                        ]);
                    }
                }
            }
        }
    }
}
