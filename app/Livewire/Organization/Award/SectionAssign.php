<?php

/**
 * Contest live - award assignment page - section page
 *
 * After Jury admit assignment, next act is assign
 * section, then contest awards.
 * And that page serve it.
 *
 * table A: assigned awards and HM
 * table B: admit works / paginated
 *
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

    public string $section_id;

    public ContestSection $section;

    public string $contest_id;

    public Contest $contest;

    public $section_awards;

    public $admitted_works;

    // 1. before the show
    public function mount(ContestSection $contestSection) // route()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');
        $this->section = $contestSection;
        $this->section_id = $contestSection->id;
        $this->contest = $contestSection->contest;
        $this->contest_id = $contestSection->contest_id;
        $this->section_awards = $contestSection->awards;
    }

    // 2. render - update admitted works w/pagination
    public function render(): View
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');

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
        Log::debug('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' aw_set:' . json_encode($admittedWorks_set));

        return view('livewire.organization.award.section-assign', [
            'section_id' => $this->section_id,
            'section' => $this->section,
            'contest_id' => $this->contest_id,
            'sectionAwards' => $this->section_awards,
            'admittedWorksSet' => $admittedWorks_set,
        ]);
    }
}
