<?php

/**
 * Contest Participant Complete payment status Y > N
 */

namespace App\Livewire\Contest\Participants;

use App\Models\ContestParticipant;
use Livewire\Component;

class Remove extends Component
{
    public string $contestId;

    public string $participantId;

    public string $feePaymentCompleted;

    public $participant;

    /**
     * 1. Before the Show
     */
    public function mount(string $dataJson) // @livewire
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' in:' . $dataJson);
        $data = json_decode($dataJson);
        $this->contestId = $data->contestId;
        $this->participantId = $data->participantId;

        if (isset($data->feePaymentCompleted)) {
            $this->feePaymentCompleted = $data->feePaymentCompleted;
        } else {
            $data->feePaymentCompleted =
            ContestParticipant::where('user_id', $this->participantId)
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
    public function paymentWaiting()
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' this:' . json_encode($this));
        $participantUpdated = ContestParticipant::where('user_id', $this->participantId)
            ->where('contest_id', $this->contestId)
            ->update(['fee_payment_completed' => 'N']);
        //
        return redirect()
            ->route('modify-participant-list', ['cid' => $this->contestId]);
    }
}
