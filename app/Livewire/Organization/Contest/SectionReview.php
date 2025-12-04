<?php
/**
 * Contest Section - Work List for Organization Review
 * That page show a header with contest data then a (too short)
 * list of works. List of works must be followed by 2
 * butto for approve /deny work participation based on
 * human review i.e. of mark sign in photo.
 * Sorry to see that every single image sucks 70 sec to be processed.
 *
 * CLASS: app/Livewire/Organization/Contest/Section.php
 * VIEW:  resources/views/livewire.organization.contest.section-review.blade.php
 *
 */

namespace App\Livewire\Organization\Contest;

use App\Models\ContestSection;
use App\Models\ContestWaiting;
use App\Models\Work;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
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
     * 
     */
    public function mount(string $sid) // route()
    {
        Log::info('Component '.__CLASS__.' f:'. __FUNCTION__.' l:'.__LINE__. ' called');
        $this->section_id = $sid; 
        
        // for headers
        // ContestSection - don't change in pagination
        $this->section = ContestSection::where('id', $sid )->first();
        Log::info('Component '.__CLASS__.' f:'. __FUNCTION__.' l:'.__LINE__. ' section:' . json_encode($this->section) );

    }

    /**
     * 2. pagination: index
     * The set must be refreshed, so we need recreate here
     */
    public function render() : View
    {
        Log::info('Component '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__. ' called ' );
        $section   = $this->section; 

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
            ->join('user_contacts', 'works.user_id', '=', 'user_contacts.user_id')
            ->join('contest_works', 'works.id', '=', 'contest_works.work_id')
            ->where('contest_works.section_id', '=', $this->section->id)
            ->simplePaginate(12); // dozen as half camera roll
         */
        // already examined work_id set
        $examinedWorksSet = DB::table('contest_waitings')
            ->select('work_id')->where('section_id', $this->section->id)
            ->union( DB::table('work_validations')->select('work_id') )
            ->get();
        // simplified array()
        $examinedWorksIds = collect($examinedWorksSet)->pluck('work_id')->toArray();

        $userWorksSet = DB::table('works')->select([ 'works.*', 'user_contacts.country_id', 'user_contacts.last_name', 'user_contacts.first_name'])
            ->join('user_contacts', 'works.user_id', '=', 'user_contacts.user_id')
            ->join('contest_works', 'works.id', '=', 'contest_works.work_id')
            ->where('contest_works.section_id', '=', $this->section->id)
            ->whereNotIn('work_id', $examinedWorksIds)
            ->simplePaginate(12); // dozen as half camera roll

        Log::info('Component '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' out: ' . json_encode($userWorksSet ) );

        //NO return view('')->with([ 'user_works_set' => $this->user_works_set ]);
        // no snake_case but camelCase
        return view('', [ 
            'userWorksSet' => $userWorksSet, 
            'section'      => $section,
        ]);
    }
}
