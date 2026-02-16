<?php

/**
 * Contest Participant Complete payment status Y > N
 */

namespace App\Livewire\Contest\Participants;

use App\Models\ContestParticipant;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Remove extends Component
{
    public string $contest_id;

    public string $participant_id;

    public string $fee_payment_completed;

    public $participant;

    /**
     * 1. Before the Show
     */
    public function mount(string $data_json) // @livewire
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' in:' . $data_json);
        $data = json_decode($data_json);
        $this->contest_id = $data->contest_id;
        $this->participant_id = $data->participant_id;

        if (isset($data->fee_payment_completed)) {
            $this->fee_payment_completed = $data->fee_payment_completed;
        } else {
            $data->fee_payment_completed =
            ContestParticipant::where('user_id', $this->participant_id)
                ->where('contest_id', $this->contest_id)
                ->get('fee_payment_completed')[0]['fee_payment_completed'];
        }

        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' out:' . json_encode($this));

    }

    /**
     * 2. Show
     */
    public function render()
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');

        return view('livewire.contest.participants.remove');
    }

    /**
     * 3. Validate rules only
     */
    public function rules()
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');

        return [];
    }

    /**
     * 4. Do your job, Bob
     */
    public function payment_waiting()
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' this:' . json_encode($this));
        $participant = ContestParticipant::where('user_id', $this->participant_id)->where('contest_id', $this->contest_id)->get()[0];
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' this:' . json_encode($participant));
        $participant->fee_payment_completed = 'N';
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' this:' . json_encode($participant));
        $participant->save();
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' exit:');

        //
        return redirect()
            ->route('modify-participant-list', ['cid' => $this->contest_id]);
    }
}
