<?php

/**
 * Contest Work Participation Subscribe Remove
 *
 * 2025-10-14 renamed last function
 *            Count works remained in contest and if was the last
 *            remove also user from contest_participants
 */

namespace App\Livewire\Contest\Subscribe;

use App\Models\ContestParticipant;
use App\Models\ContestSection;
use App\Models\ContestWork;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Remove extends Component
{
    public $participant_work_id;

    public $work_in_contest;

    public $res;

    public $section;

    public $section_code;

    public $contest_id;

    public $portfolio_sequence;

    /**
     * 1. Before show from @livewire
     */
    public function mount($pid) // as in route()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in:'.$pid);
        $this->participant_work_id = $pid;
        $this->work_in_contest = ContestWork::where('id', $pid)->first();
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' found:'.json_encode($this->work_in_contest));

        $this->contest_id = $this->work_in_contest->contest_id;

        $this->section = ContestSection::where('id', $this->work_in_contest->section_id)->first();
        $this->section_code = $this->section->code;
        $this->portfolio_sequence = $this->work_in_contest->portfolio_sequence;

        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' exit:');

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
    public function remove_work_from_contest()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        // validate not necessary

        // check if was the last
        $is_the_last = ContestWork::where('user_id', $this->work_in_contest->user_id)->where('contest_id', $this->work_in_contest->contest_id)->count();
        if ($is_the_last == 1) {
            // yes, is the last
            $user_participant = ContestParticipant::where('user_id', $this->work_in_contest->user_id)->where('contest_id', $this->work_in_contest->contest_id)->first();
            $user_participant->delete();
        }
        $this->work_in_contest = ContestWork::where('id', $this->participant_work_id)->get()[0];
        $this->res = $this->work_in_contest->delete();
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' deleted:'.json_encode($this->work_in_contest));

        return redirect()
            ->route('participate-contest', ['cid' => $this->contest_id])
            ->with('success', __('Work removed. Now U have a slot free.'));
    }
}
