<?php
/**
 * Contest Participation Add
 * special name: Contest Subscribe
 * 
 */
namespace App\Livewire\Contest;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestSection;
use App\Models\UserContact;
use App\Models\Work;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Subscribe extends Component
{
    //
    public $user_id;
    public $contest_id;
    public $work_list;
    public $contest_participant;
    public $contest_participant_list;
    public $contest_section_list;
    public DateTimeImmutable $today;

    public $contest;
    public $country_id;
    public $section_id; // to leave
    public $work_id; //    to leave

    /**
     * 1. Before the show
     */
    public function mount(string $cid) // cid from route()
    {
        $this->user_id         = Auth::id();
        $this->contest_id      = $cid;
        $this->today           = new DateTimeImmutable("now");
        $this->contest         = Contest::where('id', $cid)
            ->where('day_2_closing', '>=', $this->today->format('Y-m-d H:i:s'))
            ->get()[0];
        $this->contest_section_list = ContestSection::where('contest_id', $cid)->get();
        $this->work_list       = Work::where('user_id', $this->user_id)->get();
        $this->section_id      = '';
        $this->work_id         = '';
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' work_list:'.json_encode($this->work_list));
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.json_encode($this));
    }
    /**
     * 2. Show
    */
    public function render()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in:'.json_encode($this));
        return view('livewire.contest.subscribe');
    }
}
