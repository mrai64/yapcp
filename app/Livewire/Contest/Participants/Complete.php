<?php

/**
 * Contest Participant Complete payment status N > Y
 */

namespace App\Livewire\Contest\Participants;

use App\Models\ContestParticipant;
use Livewire\Component;

class Complete extends Component
{
    public string $contestId;

    public string $participantId;

    public string $feePaymentCompleted;

    public ContestParticipant $participant;

    /**
     * 1. before
     */
    public function mount(string $dataJson) // livewire
    {

        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' in:' . $dataJson);
        $data = json_decode($dataJson);
        $this->contestId = $data->contestId;
        $this->participantId = $data->participantId;

        if (isset($data->feePaymentCompleted)) {
            $this->feePaymentCompleted = $data->feePaymentCompleted;
        } else {
            $this->feePaymentCompleted = ContestParticipant::where('user_id', $this->participantId)
                ->where('contest_id', $this->contestId)
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

        return view('livewire.contest.participants.complete');
    }

    /**
     * 3. validate rules
     * FYI : it's only a button, what rules?
     */
    public function rules()
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');

        return [];
    }

    /**
     * 4.
     */
    public function participantPaymentCompleted()
    {

        $participantsUpdated = ContestParticipant::where('user_id', $this->participantId)
            ->where('contest_id', $this->contestId)
            ->update(['fee_payment_completed' => 'Y']);
        //
        return redirect()
            ->route('modify-participant-list', ['cid' => $this->contestId]);

    }
}
