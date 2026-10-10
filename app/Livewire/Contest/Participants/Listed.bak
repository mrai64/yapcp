<?php

/**
 * Contest (user) Participant list
 *
 * organization members can / must change status
 * admin can
 * others readonly status
 *
 * @see /resources/views/livewire/contest/participants/listed.blade.php
 */

namespace App\Livewire\Contest\Participants;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Listed extends Component
{
    public string $contestId;

    public Contest $contest;

    public $contestSectionsSet;

    public $contestParticipantsSet;

    public bool $canUpdate = false;

    public string $userCanRevokeId;

    /**
     * 1. before
     */
    public function mount(Contest $contest) // as route
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');
        $this->contest = $contest;
        $this->contestId = $contest->id;

        $this->canUpdate = Auth::check() && Auth::user()->can('update', $contest);
        $this->userCanRevokeId = Auth::user()->id;

        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' contest:' . json_encode($this->contest));

        $this->contestSectionsSet = ContestSection::where('contestId', $contest->id)->get();

        $this->contestParticipantsSet = ContestParticipant::contestParticipantsCollection($contest->id);
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' contestParticipantsSet:' . json_encode($this->contestParticipantsSet));
    }

    /**
     * 2 show
     */
    public function render()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');
        return view('livewire.contest.participants.listed');
    }
}
