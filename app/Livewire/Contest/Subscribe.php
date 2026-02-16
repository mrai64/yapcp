<?php

/**
 * Contest Work Participation Add / 1
 * special name: Contest Subscribe
 * With that part user-participant after choice contest
 * add in contest for any section her/him user_works.
 *
 * TODO 1. check user_works instead works
 * TODO 2. as is every works should participate only in one section (but it's only a rule, maybe other contest rule that admit a work in more than unique section-theme)
 *
 * 2025-10-18 First part of subscribe: show contest
 *            section list and works list
 *            read only because next step is
 *            is another blade and another controller
 * 2026-02-13 PSR-12 *work in progress*
 */

namespace App\Livewire\Contest;

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\UserWork;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Subscribe extends Component
{
    //
    public $userId;

    public $contestId;

    public DateTimeImmutable $today;

    public $userWorkSet;

    public $contest_participant;

    public $contest_participant_list;

    public $contestSectionSet;

    public $contestWorkSet;

    public $contest;

    public $countryId;

    public $sectionId; // to leave

    public $workId; //    to leave

    /**
     * 1. Before the show
     */
    public function mount(string $cid) // cid from route()
    {
        $this->userId = Auth::id();
        $this->contestId = $cid;

        $this->userWorkSet = UserWork::where('user_id', $this->userId)->get();
        if (count($this->userWorkSet) < 1) {
            // no work to participate
            Log::info('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__
                . ' work_list:' . json_encode($this->userWorkSet));
            abort(404);
        }
        Log::info('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__
            . ' work_list:' . json_encode($this->userWorkSet));

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

        $this->contestSectionSet = ContestSection::where('contest_id', $cid)->get();
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' contest:'.json_encode($this->contestSectionSet));

        $this->sectionId = '';
        $this->workId = '';

        $this->contestWorkSet = ContestWork::where('user_id', $this->userId)
            ->where('contest_id', $cid)
            ->orderBy('section_id')
            ->orderBy('portfolio_sequence')
            ->orderBy('work_id')
            ->get();
        // Log::info('Component ' . __CLASS__.' '.__FUNCTION__.':'.__LINE__.' contestWorkSet:'.json_encode($this->contestWorkSet));
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
