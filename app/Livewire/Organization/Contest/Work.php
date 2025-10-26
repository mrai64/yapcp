<?php
/**
 * Organization Contest Section Work Review
 *
 * CLASS: app/Livewire/Organization/Contest/Work.php
 * VIEW:  resources/views/livewire/organization/contest/work.blade.php
 *
 *
 */

namespace App\Livewire\Organization\Contest;

use App\Models\ContestWaiting;
use App\Models\ContestWork;
use App\Models\WorkValidation;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Work extends Component
{
    public $contest_work;
    public $contest_section;
    public $work;
    public $reviewed_work;
    public $warning_work;

    /**
     * 1.
     */
    public function mount(string $wid) // route()
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $this->contest_work = ContestWork::where('id', $wid)->first();
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' contest_work:' . json_encode($this->contest_work) );

        $this->contest_section = $this->contest_work->contest_section;
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' contest_work:' . json_encode($this->contest_section) );

        $this->work = $this->contest_work->work;
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' work:' . json_encode($this->work));

        $this->reviewed_work = WorkValidation::where('work_id', $this->work->id)->where('federation_section_id', $this->contest_section->federation_section_id)->first();
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' work_id:' . json_encode($this->work->id));
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' Fed_sec_id:' . json_encode($this->contest_section->federation_section_id));
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' reviewed_work:' . json_encode($this->reviewed_work));

        $this->warning_work = ContestWaiting::where('work_id', $this->work->id)->first();
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' warning_work:' . json_encode($this->warning_work));

    }
    /**
     * 2. Show but not even
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        if (isset($this->reviewed_work->id) ) {
            Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' SKIP');
            return view('livewire.organization.contest.work-2');
        }
        if (isset($this->warning_work->id) ) {
            Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' SKIP');
            return view('livewire.organization.contest.work-2');
        }

        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' SHOW');
        return view('livewire.organization.contest.work');
    }
}
