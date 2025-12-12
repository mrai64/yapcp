<?php
/**
 * Organization' Contest Panel
 * 
 * organization members only 
 */
namespace App\Livewire\Organization;

use App\Models\Contest;
use App\Models\ContestSection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ContestPanel extends Component
{
    public string $contest_id; 
    public $contest;
    public $section_set;

    public function mount(string $cid) // route 
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $this->contest_id = $cid;
        $this->contest = Contest::where('id', $this->contest_id)->first();

        // TODO check membership here

        $this->section_set = ContestSection::where('contest_id', $this->contest_id)->orderBy('code')->get();

    }

    public function render()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        return view('livewire.organization.contest-panel');
    }
}
