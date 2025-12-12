<?php

/**
 * Contest live - award assignment page - contest page
 *
 * After Jury admit assignment, next act is assign
 * section, then contest awards.
 * And that page serve it.
 *
 * TODO Organization members only
 */

namespace App\Livewire\Organization\Award;

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ContestAssign extends Component
{
    public string $contest_id;

    public $contest;

    public $contest_awards;

    public $award_assigned;

    public $all_assigned;

    public $incomplete_sections;

    public $sections;

    /**
     * 1.
     */
    public function mount(string $cid) // route
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $this->contest_id = $cid;
        $this->contest = Contest::where('id', $this->contest_id)->first();

        /**
         * Check if every section prize and mention are assigned:
         * true: expose contest prizes form
         * false: expose section assignment links
         */
        // section_code, total_awards, assigned_awards
        $this->award_assigned = ContestAward::query()
            ->selectRaw('
                (CASE 
                    WHEN (section_code > "") THEN section_code 
                    ELSE "Contest" 
                END) as code
            ')
            ->selectRaw('
                count(*) AS total_awards
            ')
            ->selectRaw('
                SUM(
                    CASE
                        WHEN (`winner_work_id` IS NOT NULL AND `winner_work_id` != "")
                        OR (`winner_user_id` IS NOT NULL AND `winner_user_id` != "")
                        OR (`winner_name` IS NOT NULL AND `winner_name` != "")
                        THEN 1
                        ELSE 0
                    END
                ) AS assigned_awards
            ')
            ->selectRaw('section_id')
            ->where('contest_id', $this->contest_id)
            ->where('section_id', '>', '')
            ->groupBy('section_code')
            ->groupBy('section_id')
            ->get();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' set: '.json_encode($this->award_assigned));

        $this->incomplete_sections = [];
        foreach ($this->award_assigned as $section_award) {

            if ($section_award->total_awards > $section_award->assigned_awards) {
                $this->incomplete_sections[] = $section_award->section_id;
            }
        }
        $this->all_assigned = (count($this->incomplete_sections) === 0);
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' set: '.json_encode($this->incomplete_sections));
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' all_assigned: '.json_encode($this->all_assigned));
        if (count($this->incomplete_sections)) {
            $this->sections = ContestSection::whereIn('id', $this->incomplete_sections)->get();
        } else {
            $this->sections = [];
        }
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' sections: '.json_encode($this->sections));

        // Qui invece va preparata la struttura per assegnare i premi di concorso.

    }

    /**
     * 2.
     */
    public function render()
    {
        return view('livewire.organization.award.contest-assign');
    }
}
