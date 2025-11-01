<?php
/**
 * Contest Section Jury Board
 * list 
 * CLASS: app/Livewire/Contest/Jury/Board.php
 * VIEW:  resources/views/livewire/contest/jury/board.blade.php
 * single
 * CLASS: app/Livewire/Contest/Jury/BoardWork.php
 * VIEW:  resources/views/livewire/contest/jury/board-work.blade.php
 * 
 * juror_id == Auth::id()
 *
 */

namespace App\Livewire\Contest\Jury;

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\ContestWork;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class Board extends Component
{
    public $juror_id;
    public $juror;
    public $contest_section_id;
    public $contest_section;
    public $contest;
    public $today;
    public $participant_works;
    public $voted_works;
    public $voted_ids;
    public $vote_rule;

    /**
     * 1. Before the show
     */
    public function mount(string $sid) // route()
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        $this->juror_id = Auth::id();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' juror_id:' . $this->juror_id );
        $this->juror    = UserContact::where('user_id', $this->juror_id)->first();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' juror:' . json_encode( $this->juror ) );

        $this->contest_section_id = $sid;
        $this->contest_section = ContestSection::where('id', $this->contest_section_id)->first();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' contest_section:' . json_encode( $this->contest_section ) );

        $this->contest = Contest::where('id', $this->contest_section->contest_id)->first();
        $this->vote_rule = $this->contest->vote_rule;
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' contest:' . json_encode( $this->contest ) );
        //
        //
        // SET of voted - temporary set 
        // $this->voted_works = ContestWork::where('contest_id', $this->contest->id)->where('section_id', $this->contest_section->id)->orderBy('work_id')->get();
        $this->voted_works = ContestVote::where('contest_id', $this->contest->id)->where('section_id', $this->contest_section->id)->orderByDesc('vote')->orderBy('work_id')->get();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' voted_works:' . json_encode( $this->voted_works ) );
        
        $this->voted_ids = ContestVote::voted_ids( $this->contest->id, $this->contest_section->id);
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' voted_ids:' . json_encode( $this->voted_ids ) );

        // SET of un-voted
        if ($this->voted_ids->count()) {
            $this->participant_works = DB::table( ContestWork::table_name)->whereNotIn('work_id', $this->voted_ids )->get();

        } else {
            $this->participant_works = ContestWork::where('contest_id', $this->contest->id)->where('section_id', $this->contest_section->id)->orderBy('work_id')->get();
        }
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' participant_works:' . json_encode( $this->participant_works ) );

    }
    /**
     * 2. Show
     */
    public function render()
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        return view('livewire.contest.jury.board');
    }

}
