<?php

/**
 * Contest Work Participation Add / 1
 * special name: Contest Subscribe
 *
 * 2025-10-18 First part of subscribe: show contest
 *            section list and works list
 *            read only because next step is
 *            is another blade and another controller
 */

namespace App\Livewire\Contest;

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\Work;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Subscribe extends Component
{
    //
    public $user_id;

    public $contest_id;

    public DateTimeImmutable $today;

    public $work_list;

    public $contest_participant;

    public $contest_participant_list;

    public $contest_section_list;

    public $contest_work_list;

    public $contest;

    public $country_id;

    public $section_id; // to leave

    public $work_id; //    to leave

    /**
     * 1. Before the show
     */
    public function mount(string $cid) // cid from route()
    {
        $this->user_id = Auth::id();
        $this->contest_id = $cid;

        $this->work_list = Work::where('user_id', $this->user_id)->get();
        if (count($this->work_list) < 1) {
            // no work to participate
            Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' work_list:'.json_encode($this->work_list));
            abort(404);
        }
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' work_list:'.json_encode($this->work_list));

        $this->today = new DateTimeImmutable('now');
        $this->contest = Contest::where('id', $cid)
            ->where('day_2_closing', '>=', $this->today->format('Y-m-d H:i:s'))
            ->first(); // get()[0];
        if (! isset($this->contest->id)) {
            // contest is closed
            Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' contest missing:'.$cid);
            abort(404);
        }
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' contest:'.json_encode($this->contest));

        $this->contest_section_list = ContestSection::where('contest_id', $cid)->get();
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' contest:'.json_encode($this->contest_section_list));

        $this->section_id = '';
        $this->work_id = '';

        $this->contest_work_list = ContestWork::where('user_id', $this->user_id)
            ->where('contest_id', $cid)
            ->orderBy('section_id')
            ->orderBy('portfolio_sequence')
            ->orderBy('work_id')
            ->get();
        // Log::info('Component ' . __CLASS__.' '.__FUNCTION__.':'.__LINE__.' contest_work_list:'.json_encode($this->contest_work_list));
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.json_encode($this));

    }

    /**
     * 2. Show
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in:'.json_encode($this));

        return view('livewire.contest.subscribe');
    }
}
