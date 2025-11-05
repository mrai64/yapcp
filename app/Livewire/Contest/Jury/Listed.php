<?php
/**
 * User, you are juror in these contest
 * 
 * CLASS: app/Livewire/Contest/Jury/Listed.php
 * VIEW:  resources/views/livewire/contest/jury/listed.blade.php
 *
 * Creare n show the list where user is named as juror
 *
 * 
 */

namespace App\Livewire\Contest\Jury;

use App\Models\ContestJury;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Listed extends Component
{
    // input
    public             $juror_user_id;

    public UserContact $juror;
    public             $juries;
    /**
     * 1. Before the show
     */
    public function mount() // no parm as use Auth::id
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');

        $this->juror_user_id = Auth::id();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' juror_user_id:'. json_encode($this->juror_user_id) );

        $this->juror = UserContact::where('user_id', $this->juror_user_id)->first();
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' juror:'. json_encode($this->juror) );

        $this->juries = $this->juror->juries;
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' juries:'. json_encode($this->juries) );

    }
    /**
     * 2. Show
    */
    public function render()
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        if ($this->juries->count() == 0){
            return view('livewire.contest.jury.listed-none');
        }
        return view('livewire.contest.jury.listed');
    }
}
