<?php
/**
 * Contest Section Work List for Organization
 *
 * CLASS: app/Livewire/Section.php
 * VIEW:  resources/views/livewire/section.blade.php
 *
 */

namespace App\Livewire\Organization\Contest;

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestWork;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Section extends Component
{
    public $section;
    public $contest;
    public $section_set;
    public $work_participants_set;

    /**
     * 1. Before the show
     */
    public function mount(string $sid) // route()
    {
        Log::info('Component '.__CLASS__.' f/'. __FUNCTION__.':'.__LINE__. ' called');

        $this->section = ContestSection::where('id', $sid)->first();
        Log::info('Component '.__CLASS__.' f/'. __FUNCTION__.':'.__LINE__. ' section:' . json_encode($this->section) );

        $this->contest = Contest::where('id', $this->section->contest_id)->first();
        Log::info('Component '.__CLASS__.' f/'. __FUNCTION__.':'.__LINE__. ' contest:' . json_encode($this->contest));
        
        $this->section_set = ContestSection::where('contest_id', $this->section->contest_id)->get();
        Log::info('Component '.__CLASS__.' f/'. __FUNCTION__.':'.__LINE__. ' section_set:' . json_encode($this->section_set));
        
        $this->work_participants_set = ContestWork::where('section_id', $sid)->paginate(15);
        Log::info('Component '.__CLASS__.' f/'. __FUNCTION__.':'.__LINE__. ' work_participants_set: ' . ($this->work_participants_set->count() ) );

    }

    /**
     * 2. before the show
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' f/'. __FUNCTION__.':'.__LINE__. ' called');
        return view('livewire.organization.contest.section');
    }
}
