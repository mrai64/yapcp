<?php
/**
 * Contest Section Work List for Organization
 * CLASS: app/Livewire/Organization/Contest/Section.php
 * VIEW:  resources/views/livewire/organization/contest/section.blade.php
 * 
 */

namespace App\Livewire\Organization\Contest;

use App\Models\ContestSection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Section extends Component
{
    public $section;

    /**
     * 1. Before the show
     */
    public function mount(string $sid) // route()
    {
        Log::info('Component organization/Contest/'.__CLASS__.' f/'. __FUNCTION__.':'.__LINE__. ' called');
        $this->section = ContestSection::where('id', $sid)->first();
        
        
    }
    
    /**
     * 2. before the show
     */
    public function render()
    {
        Log::info('Component organization/Contest/'.__CLASS__.' f/'. __FUNCTION__.':'.__LINE__. ' called');
        return view('livewire.organization.contest.section');
    }
}
