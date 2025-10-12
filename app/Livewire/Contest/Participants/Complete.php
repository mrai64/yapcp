<?php
/**
 * Contest Participant Complete payment status N > Y
 * 
 */
namespace App\Livewire\Contest\Participants;

use App\Models\ContestParticipant;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Complete extends Component
{
    public string $contest_id;
    public string $participant_id;
    public string $fee_payment_completed;

    public ContestParticipant $participant;

    /**
     * 1. before
     */
    public function mount(string $data_json)
    {

        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in:'. $data_json);
        $data                 = json_decode($data_json);
        $this->contest_id     = $data->contest_id;
        $this->participant_id = $data->participant_id;

        if (isset($data->fee_payment_completed)){
            $this->fee_payment_completed = $data->fee_payment_completed;
        } else {
            $this->fee_payment_completed = ContestParticipant::where('user_id', $this->participant_id)->where('contest_id', $this->contest_id)->get('fee_payment_completed')[0]['fee_payment_completed'];
        }
        
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'. json_encode($this));
        
    }
    /**
     * 2. Show
    */
    public function render()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        return view('livewire.contest.participants.complete');
    }
    /**
     * 3. validate rules
     * FYI : it's only a button, what rules?
    */
    public function rules()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        return [];
    }
    /**
     * 4. 
     */
    public function payment_completed() 
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' this:'. json_encode($this));
        $participant = ContestParticipant::where('user_id', $this->participant_id)->where('contest_id', $this->contest_id)->get()[0];
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' this:'. json_encode($participant));
        $participant->fee_payment_completed = 'Y';
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' this:'. json_encode($participant));
        $participant->save();
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' exit:');
        //
        return redirect()
            ->route('modify-participant-list', [ 'cid' => $this->contest_id ] );

    }
}
