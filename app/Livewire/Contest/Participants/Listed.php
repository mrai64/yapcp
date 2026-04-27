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

    public Contest $contest;

    public $contestSectionsSet;

    public $contestParticipantsSet;

    /**
     * 1. before
     */
    public function mount(Contest $contest) // as route
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $this->contest = $contest;
        $this->contest_id = $contest->id;
        $this->contestParticipantsSet = [];

        Log::info(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' contest:' . json_encode($this->contest));

        $this->contestSectionsSet = ContestSection::where('contest_id', $cid)->get();

        $this->contestParticipantsSet = ContestParticipant::contestParticipantsArray($cid);
        Log::info(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' contestParticipantsSet:' . json_encode($this->contestParticipantsSet));

    }

    /**
     * 2 show
     */
    public function render()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        return view('livewire.contest.participants.listed');
    }
}
