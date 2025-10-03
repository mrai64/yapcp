<?php
/**
 * Contest Participation Subscribe Remove 
 * 
 */
namespace App\Livewire\Contest\Subscribe;

use App\Models\ContestParticipant;
use App\Models\ContestSection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Remove extends Component
{
    public $participant_id;
    public $participant;
    public $res;
    public $section;
    public $section_code;
    public $contest_id; 

    /**
     * 1. Before show from @livewire
     */
    public function mount($pid) // as in route()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in:'. $pid);
        $this->participant_id = $pid;
        $this->participant = ContestParticipant::where('id', $pid)->get()[0];
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' found:'. json_encode($this->participant));

        $this->contest_id = $this->participant->contest_id; 

        $this->section = ContestSection::where('id', $this->participant->section_id )->get()[0];
        $this->section_code = $this->section->code;

        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' exit:' );

    }
    /**
     * 2. show
     */
    public function render()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        return view('livewire.contest.subscribe.remove');
    }
    /**
     * 3. validation rule: none
    */
    public function rules()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        return [];
    }
    /**
     * 4. delete
    */
    public function delete()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        //
        $this->participant = ContestParticipant::where('id', $this->participant_id)->get()[0];
        $this->res = $this->participant->delete();
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' deleted:'. json_encode($this->participant));
        return redirect()
            ->route('participate-contest', [ 'cid' => $this->contest_id ] )
            ->with('success', __('Work removed. Now U have a slot free.') );
    }


}
