<?php

namespace App\Livewire\Contest\Participants;

use Livewire\Component;

class Revoke extends Component
{
    public Contest $contest;

    public ContestParticipant $participant;


    // 1. before the show()
    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->participant = ContestParticipant::where('contest_id', $contest->id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();
    }

    // 2. show
    public function render()
    {
        return view('livewire.contest.participants.revoke');
    }

    // 3. rules

    // 4. act
    public function revokeParticipation()
    {
    }
}
