<?php

/**
 * Contest live - Organization works review for compliance
 *   to section theme after automatic check
 *
 * For every works submitted in contest some automatic check are done
 *   by platform. Others must be done thru human review.
 *   The good news is that check is recorded and unnecessary
 *   for the same work and same section already reviewed in
 *   previous contests.
 *
 */

namespace App\Livewire\Organization\PreJury;

use App\Models\ContestSection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class SectionReview extends Component
{
    use WithPagination;

    public string $section_id;

    public $section;

    public $contest;

    public $contest_flag;

    public $section_set;

    public $contest_works_set;

    public $user_works_set;

    /**
     * 1. Before the show
     */
    public function mount(ContestSection $section) // as in route()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');
        $this->section = $section;
        $this->section_id = $section->id;
    }

    /**
     * 2. pagination: index
     * The set must be refreshed, everytime
     */
    public function render(): View
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');
        $section = $this->section;

        // works that are present in contest_works w/section_id
        // NOTE this is a *complete list* ignoring validated works and warning works
        /*
        $userWorksSet = DB::table( 'works' )
            ->join( 'contest_works', function (JoinClause $join) {
                $join->on( 'works.id', '=', 'contest_works.work_id' )
                ->where( 'contest_works.section_id', '=', $this->section->id );
            })
            ->simplePaginate(12); // dozen as half camera roll
         */
        /* Same as previous, entire list
        $userWorksSet = Work::select([ 'works.*', 'user_contacts.country_id', 'user_contacts.last_name', 'user_contacts.first_name'])
            ->join('user_contacts', 'works.user_id', '=', 'user_contacts.id')
            ->join('contest_works', 'works.id', '=', 'contest_works.work_id')
            ->where('contest_works.section_id', '=', $this->section->id)
            ->simplePaginate(12); // dozen as half camera roll
         */

        // already examined work_id set
        $examinedWorksSet = DB::table('contest_waitings')
            ->select('work_id')->where('section_id', $this->section->id)
            ->union(DB::table('work_validations')->select('work_id'))
            ->get();
        // simplified array()
        $examinedWorksIds = collect($examinedWorksSet)->pluck('work_id')->toArray();

        $userWorksSet = DB::table('works')->select(['works.*', 'user_contacts.country_id', 'user_contacts.last_name', 'user_contacts.first_name'])
            ->join('user_contacts', 'works.user_id', '=', 'user_contacts.id')
            ->join('contest_works', 'works.id', '=', 'contest_works.work_id')
            ->where('contest_works.section_id', '=', $this->section->id)
            ->whereNotIn('work_id', $examinedWorksIds)
            ->orderBy('works.user_id')
            ->orderBy('works.updated_at')
            ->simplePaginate(12); // dozen as half camera roll

        Log::debug('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' out: ' . json_encode($userWorksSet));

        // NO return view('')->with([ 'user_works_set' => $this->user_works_set ]);
        // no snake_case but camelCase
        return view('livewire.organization.pre-jury.section-review', [
            'userWorksSet' => $userWorksSet,
            'section' => $section,
        ]);
    }
}
