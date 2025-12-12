<?php

/**
 * Contest live - During last jury review section and contest
 * (and if, circuit) prizes and mentions are assigned
 * based on admitted works.
 * A navigation header is required to look status of
 * assigned prizes and mentions (counter only)
 */

namespace App\Livewire\Organization\Award;

use App\Models\Contest;
use App\Models\ContestAward;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SectionNav extends Component
{
    public string $contest_id;

    public $contest;

    public $contest_awards;

    public $contest_award_assigned;

    public function mount(string $cid) // livewire
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        // $cid
        $this->contest_id = $cid;
        $this->contest = Contest::where('id', $this->contest_id)->first();

        // section_code, total_awards, assigned_awards
        $this->contest_award_assigned = ContestAward::query()
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
            ->where('contest_id', $this->contest_id)
            ->groupBy('section_code')
            ->orderBy('section_code')
            ->get();

    }

    public function render()
    {
        return view('livewire.organization.award.section-nav');
    }
}
