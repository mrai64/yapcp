<?php

namespace App\Livewire\Organization\Award;

use App\Models\ContestAward;
use App\Models\ContestWork;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SectionAssignDia extends Component
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
        $userId = ContestWork::select('user_id')->where('contest_id', $this->contest_id)
            ->where('section_id', $this->section_id)
            ->where('work_id', $this->work_id)->first();
        $this->user_id = $userId->user_id;

        // here we need the section_code list of unassigned awards code
        $this->unassigned_award_codes = ContestAward::select('award_code')
            ->where('contest_id', $this->contest_id)
            ->where('section_id', $this->section_id)
            ->whereNull('winner_work_id')
            ->get();

        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out:'.json_encode($this));

    }

    public function render()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out:'.json_encode($this));

        return view('livewire.organization.award.section-assign-dia');
    }

    public function assign_award(string $award_code) // blade wire:click
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called w/in: '.$award_code);

        $this->unassigned_award_codes = ContestAward::select('award_code')
            ->where('contest_id', $this->contest_id)
            ->where('section_id', $this->section_id)
            ->whereNull('winner_work_id')
            ->get();

        // first remove previous assigned, if any
        $clean = ContestAward::where('contest_id', $this->contest_id)
            ->where('section_id', $this->section_id)
            ->where('award_code', $award_code)
            ->update(['winner_work_id' => null, 'winner_user_id' => null, 'winner_name' => '']);
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' clean: '.$clean);

        // second find and update assigned work_id
        $assign = ContestAward::where('contest_id', $this->contest_id)
            ->where('section_id', $this->section_id)
            ->where('award_code', $award_code)
            ->update(['winner_work_id' => $this->work_id, 'winner_user_id' => $this->user_id]);
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' assign: '.json_encode($assign));

        // refresh award and admit list
        if ($this->unassigned_award_codes->count() > 1) {
            // redirect
            return redirect()
                ->route('organization-award-section-assign', ['sid' => $this->section_id])
                ->with('success', __('Award assigned, next?'));
        } else {
            // last, back to contest page
            return redirect()
                ->route('organization-award-contest-assign', ['cid' => $this->contest_id])
                ->with('success', __('Section Award all assigned, next?'));
        }
    }
}
