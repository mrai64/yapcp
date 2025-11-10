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
 * VIEW:  resources/views/livewire/organization.contest.section.blade.php
 *
 */

namespace App\Livewire\Organization\Contest;

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\Work;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Section extends Component
{
    use WithPagination;

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
        // for headers
        // ContestSection
        $this->section = ContestSection::where('id', $sid)->first();
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
        $sectionId = $this->section->id; 

        // works that are present in contest_works w/section_id
        $userWorksSet = DB::table( 'works' )
            ->join( 'contest_works', function (JoinClause $join) {
                $join->on( 'works.id', '=', 'contest_works.work_id' )
                ->where( 'contest_works.section_id', '=', $this->section->id );
            })
            ->simplePaginate(12); // dozen as half camera roll
        Log::info('Component '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' out: ' . json_encode($userWorksSet ) );

        //NO return view('livewire.organization.contest.section')->with([ 'user_works_set' => $this->user_works_set ]);
        // no snake_case but camelCase
        return view('livewire.organization.contest.section', [ 
            'userWorksSet' => $userWorksSet, 
            'sectionId'    => $sectionId,
            'section'      => $section,
        ]);
    }
}
