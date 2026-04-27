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
    public string $contest_id;

    public Contest $contest;

    public $contestSectionsSet;

    public $contestParticipantsSet;

    public bool $canUpdate = false;

    /**
     * 1. before
     */
    public function mount(Contest $contest) // as route
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');
        $this->contest = $contest;
        $this->contest_id = $contest->id;
        $this->contestParticipantsSet = [];

        // Esempio: verifichiamo se l'utente può aggiornare i partecipanti di questo contest
        // La policy 'update' su ContestParticipant potrebbe controllare se l'utente
        // è un membro dell'organizzazione o un admin.
        $this->canUpdate = Auth::check() && Auth::user()->can('update', $contest);

        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' contest:' . json_encode($this->contest));

        $this->contestSectionsSet = ContestSection::where('contest_id', $contest->id)->get();

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
