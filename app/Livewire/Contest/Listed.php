<?php
/**
 * Open Contest List
 * 
 */
namespace App\Livewire\Contest;

use App\Models\Contest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Listed extends Component
{
    public $contest_get;
    public $contest_list = [];
    public $today;

    /**
     * 1. Before the show
     * 
     */
    public function mount() // no parm
    {
        Log::info(__FUNCTION__.':'.__LINE__ );
        $today = Carbon::now()->toDateString() . ' 23:59:59.000000Z';
        // where AND where
        $this->contest_get = Contest::where('day_2_closing', '>=', $today)
        ->where('day_1_opening', '<=', $today)->get();
        Log::info(__FUNCTION__.':'.__LINE__ . ' found:' . count($this->contest_get));
        if (count($this->contest_get) > 0) {
            foreach ($this->contest_get as $contest) {
                Log::info(__FUNCTION__.':'.__LINE__ . ' contest:' . $this->contest_get );
            }
        }
    }
    /**
     * 2. show and stop
     * 
    */
    public function render()
    {
        Log::info(__FUNCTION__.':'.__LINE__ );
        return view('livewire.contest.listed');
    }
}
