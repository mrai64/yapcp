<?php

/**
 * Contest Participant (list) Modify
 *
 * participant her/him self can
 * organization members can
 * admin can
 * others cannot - redirect to list
 *
 *
 */

namespace App\Livewire\Contest\Participants;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Modify extends Component
{
    public Contest $contest;

    public string $contestId;

    public $contestSectionSet;

    public $participantSet;

    public $user_contact;

    public string $participant_id;

    public bool $isManager = false;

    public array $workCounts = [];

    /**
     * 1. Before the show
     */
    public function mount(Contest $contest) // see route()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');
        $this->contest = $contest;
        $this->contestId = $contest->id;
        $this->participantSet = [];

        // Calcolo permessi una volta sola
        $this->isManager = Auth::check() && Auth::user()->can('update', $this->contest);

        $this->contestSectionSet = ContestSection::where('contest_id', $this->contestId)->get();

        // Caricamento massivo conteggi per evitare N+1
        $this->workCounts = DB::table('contest_works')
            ->whereIn('section_id', $this->contestSectionSet->pluck('id'))
            ->select('user_id', 'section_id', DB::raw('count(*) as total'))
            ->groupBy('user_id', 'section_id')
            ->get()
            ->groupBy('user_id')
            ->map(fn ($group) => $group->pluck('total', 'section_id'))
            ->toArray();

        $this->participantSet = ContestParticipant::contestParticipantsCollection($this->contestId);
    }

    /**
     * 2. Show the list
     */
    public function render()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');

        return view('livewire.contest.participants.modify');
    }
}
