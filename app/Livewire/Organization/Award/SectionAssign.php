<?php

/**
 * Contest live - award assignment page - section page
 *
 * After Jury admit assignment, next act is assign
 * section, then contest awards.
 * And that page serve it.
 *
 * TODO Organization members only
 *
 * table A: assigned awards and HM
 * table B: admit works / paginated
 */

namespace App\Livewire\Organization\Award;

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class SectionAssign extends Component
{
    use WithPagination;

    public $section_id;

    public $section;

    public $contest_id;

    public $contest;

    public $section_awards;

    public $admitted_works;

    public function mount(string $sid) // route()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        $this->section_id = $sid;

        $this->section = ContestSection::where('id', $this->section_id)->first();

        $this->contest_id = $this->section->contest_id;

        $this->contest = Contest::where('id', $this->contest_id)->first();

        // all awards list
        $this->section_awards = ContestAward::where('section_id', $this->section_id)
            ->where('contest_id', $this->contest_id)->orderBy('award_code')->get();

    }

    public function render(): View
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        // all admitted works but not already awarded - paginate
        $admittedWorks_set = DB::table('contest_works')
            ->select(['contest_works.work_id', 'contest_works.section_id', 'contest_works.contest_id', 'contest_works.extension', 'contest_works.user_id'])
            ->leftJoin('contest_awards', function ($join) {
                $join->on('contest_awards.contest_id', '=', 'contest_works.contest_id')
                    ->on('contest_awards.section_id', '=', 'contest_works.section_id')
                    ->on('contest_awards.winner_work_id', '=', 'contest_works.work_id');
            })
            ->where('contest_works.contest_id', $this->contest_id)
            ->where('contest_works.section_id', $this->section_id)
            ->where('contest_works.is_admit', true)
            ->orderBy('user_id')
            ->orderBy('work_id')
            ->simplePaginate(12);
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' aw_set:'.json_encode($admittedWorks_set));

        return view('livewire.organization.award.section-assign', [
            'section_id' => $this->section_id,
            'section' => $this->section,
            'contest_id' => $this->contest_id,
            'sectionAwards' => $this->section_awards,
            'admittedWorksSet' => $admittedWorks_set,
        ]);
    }
}
