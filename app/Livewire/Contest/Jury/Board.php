<?php
/**
 * Contest Section Jury Board
 * CLASS: app/Livewire/Contest/Jury/Board.php
 * VIEW:  resources/views/livewire/contest/jury/board.blade.php
 * 
 * juror_id == Auth::id()
 * 
 */

namespace App\Livewire\Contest\Jury;

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Carbon\CarbonImmutable;


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

    /**
     * 1. Before the show 
     */
    public function mount(string $sid) // route()
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        $this->juror_id = Auth::id();
        $this->juror    = UserContact::where('user_id', $this->juror_id)->first();

        $this->contest_section_id = $sid;
        $this->contest_section = ContestSection::where('id', $this->contest_section_id)->first();

        $this->contest = Contest::where('id', $this->contest_section->contest_id)->first();
        
        $this->participant_works = ContestWork::where('contest_id', $this->contest->id)->where('section_id', $this->contest_section->id)->orderBy('work_id')->get();


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
