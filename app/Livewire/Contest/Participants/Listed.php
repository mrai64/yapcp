<?php

/**
 * Contest (user) Participant list 1
 * Status readonly
 */

namespace App\Livewire\Contest\Participants;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestSection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Listed extends Component
{
    public string $contest_id;

    public $contest;

    public $contest_section_list;

    public $participant_list;

    /**
     * 1. before
     */
    public function mount(string $cid) // as route
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $this->participant_list = [];
        $this->contest_id = $cid;

        $this->contest = Contest::where('id', $cid)->get()[0];
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' contest:'.json_encode($this->contest));

        $this->contest_section_list = ContestSection::where('contest_id', $cid)->get();

        $this->participant_list = ContestParticipant::contestParticipantsArray($cid);
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' participant_list:'.json_encode($this->participant_list));

    }

    /**
     * 2 show
     */
    public function render()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');

        return view('livewire.contest.participants.listed');
    }
}
