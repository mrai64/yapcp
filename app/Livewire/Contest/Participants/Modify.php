<?php
/**
 * Contest Participant (list) Modify
 *
 * - a participant should change only own record
 * - a member of organization can change all record, one at time
 * others are redirected to "readonly" page
 *
 */
namespace App\Livewire\Contest\Participants;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestSection;
use App\Models\UserContact;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Modify extends Component
{
    public string $contest_id;
    public        $contest;
    public        $contest_section_list;
    public        $participant_list;
    public        $user_contact;
    public string $participant_id;

    /**
     * 1. Before the show
     */
    public function mount(string $cid) // see route()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $this->participant_list = [];
        $this->contest_id       = $cid;

        $this->contest          = Contest::where('id', $cid)->get()[0];
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' contest:'.json_encode($this->contest));

        $this->contest_section_list = ContestSection::where('contest_id', $cid)->get();

        $this->participant_list = ContestParticipant::get_participant_list($cid);
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' participant_list:'.json_encode($this->participant_list));

    }
    /**
     * 2. Show the list
    */
    public function render()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        return view('livewire.contest.participants.modify');
    }
    /**
     * 3. validation rules
    */
    public function rules()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');

    }
    /**
     * 4. do the job
    */
    public function update_contest_participant()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');

    }
}
