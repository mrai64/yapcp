<?php
/**
 * Organization Contest Section Work Review
 * 
 * CLASS: app/Livewire/Organization/Contest/Work.php
 * VIEW:  resources/views/livewire/organization/contest/work.blade.php
 * $work = ContestWork::
 * 
 */

namespace App\Livewire\Organization\Contest;

use App\Models\ContestWork;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Work extends Component
{
    public $contest_work;
    public $work;

    /**
     * 1.
     */
    public function mount(string $wid) // route()
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $this->contest_work = ContestWork::where('id', $wid)->first(); 
        $this->work = $this->contest_work->work; 
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' work:' . json_encode($this->work));
        
    }
    /**
     * 2.
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        return view('livewire.organization.contest.work');
    }
}
