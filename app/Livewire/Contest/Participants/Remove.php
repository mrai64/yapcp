<?php
/**
 * Contest Participant Complete payment status Y > N
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
        $data = json_decode($data_json);
        $this->contest_id = $data->contest_id;
        $this->participant_id = $data->participant_id;
        if (isset($data->fee_payment_completed)){
            $this->fee_payment_completed = $data->fee_payment_completed;
        } else {
            $this->data->fee_payment_completed = 
            ContestParticipant::where('participant_id', $this->participant_id)
            ->where('contest_id', $this->contest_id)
            ->get('fee_payment_completed')[0]['fee_payment_completed'];
        }
        
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'. json_encode($this));
        
    }
    /**
     * 2. Show
    */
    public function render()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        return view('livewire.contest.participants.remove');
    }
    /**
     * 3. validate rules
    */
    public function rules()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        return [];
    }
    /**
     * 4. 
     */
    public function payment_waiting() 
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $this->participant = ContestParticipant::where('participant_id', $this->participant_id)
            ->where('contest_id', $this->contest_id)
            ->get();
        $this->participant->fee_payment_completed = 'N'; 
        $this->participant->save();
        // 

    }
}
