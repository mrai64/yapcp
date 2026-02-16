<?php

/**
 * Contest Participant (list) Modify
 *
 * - a participant should change only own record
 * - a member of organization can change all record, one at time
 * others are redirected to "readonly" page
 */

namespace App\Livewire\Contest\Participants;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestSection;
use Livewire\Component;

class Modify extends Component
{
    public string $contestId;

    public $contest;

    public $contestSectionSet;

    public $participantSet;

    public $user_contact;

    public string $participant_id;

    /**
     * 1. Before the show
     */
    public function mount(string $cid) // see route()
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');
        $this->participantSet = [];
        $this->contestId = $cid;
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' this:' . json_encode($this));

        $this->contest = Contest::where('id', $cid)->first(); // was: ->get()[0];
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' contest:' . json_encode($this->contest));

        $this->contestSectionSet = ContestSection::where('contest_id', $cid)->get();

        $this->participantSet = ContestParticipant::contestParticipantsArray($cid);
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' participantSet:' . json_encode($this->participantSet));
    }

    /**
     * 2. Show the list
     */
    public function render()
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' §§ this:' . json_encode($this));

        return view('livewire.contest.participants.modify');
    }

    /**
     * 3. validation rules
     */
    public function rules()
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');
    }

    /**
     * 4. do the job
     */
    public function updateContestParticipant()
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');
    }
}
