<?php

namespace App\Livewire\Organization\Award;

use App\Models\ContestWork;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SectionAssignedDia extends Component
{
    public $wid;

    public $contest_id;

    public $section_id;

    public $work_id;

    public $user_id;

    public $unassigned_award_codes;

    public function mount(string $wid) // livewire
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called w/wid: '.$wid);
        // wid is composed by contest_id / section_id / ('300px_'|'') wid . extension
        $this->wid = $wid;
        [$this->contest_id, $this->section_id, $namefile] = explode('/', $wid);
        $namefile = str_ireplace('300px_', '', $namefile);
        [$this->work_id, $extension] = explode('.', $namefile);

        // user owner of work_id
        $this->user_id = ContestWork::select('user_id')->where('id', $this->work_id)->first();

        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' contest_id:'.($this->contest_id));
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' section_id:'.($this->section_id));

    }

    public function render()
    {
        return view('livewire.organization.award.section-assigned-dia');
    }
}
