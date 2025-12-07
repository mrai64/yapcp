<?php

/**
 * Multiple admission panel
 * After jury votes, after eventually revision of votes
 * that time to assign admit Y/N to participant works
 * Use /jury/section-board sql select without work_id
 *
 * reserved organization
 * input: section_id
 *
 * no pagination, 3 juror x 30 vote 1..30 sum() range 3..90
 * no pagination, 5 juror x 30 vote 1..30 sum() range 5..150
 * for a text-list pagination is not required. usually vote are from 16..30 range  80..150 (seventyone)
 * 
 */

namespace App\Livewire\Organization\Admit;

use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\ContestWork;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SectionAdmission extends Component
{
    // vars
    public string $section_id;

    public ContestSection $section;

    public $total_participant_works;

    public $contest_works_board;

    public $vote_assigned_board;

    public $work_list;

    public $admitFrom;

    /**
     * 1. Before the show
     */
    public function mount(string $sid) // named as route()
    {

        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called w/sid: '.$sid);
        // TODO GATE organization only

        $this->section_id = $sid;
        $this->section = ContestSection::where('id', $sid)->first();

        $this->total_participant_works = ContestWork::where('section_id', $this->section_id)->count();

        // build contest_work_board
        // subquery 1 sum(vote) + work_id
        $voteSubquery = ContestVote::query()
            ->selectRaw('
                SUM(vote) AS voted_sum,
                work_id
            ')
            ->where('section_id', $sid)
            ->groupBy('work_id');
        // no get()
        // Log::info('Component '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' voteSubquery: '. json_encode($voteSubquery->get()) );
        // Log::info('Component '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' voteSubquery: '. json_encode($voteSubquery->getQuery()) );

        // subquery 2 sum(vote) + work_id + rank()
        $boardVotesSubquery = DB::table(DB::raw("({$voteSubquery->toSql()}) AS vote_data")) // db prefix not required because it's a ram table
            ->mergeBindings($voteSubquery->getQuery()) // !important for bindings WHERE
            ->selectRaw("
                vote_data.voted_sum as voted_sum,
                vote_data.work_id,
                RANK() OVER (ORDER BY vote_data.voted_sum DESC) AS rank_voted_sum,
                ROUND( 10000 * RANK() OVER (ORDER BY vote_data.voted_sum DESC) / {$this->total_participant_works} ) as admission_percent
            ");
        // no get()
        // Log::info('Component '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' boardVotesSubquery: '. json_encode($boardVotesSubquery) );

        // And last...
        // build vote_assigned_board
        $this->vote_assigned_board = DB::table(DB::raw("({$boardVotesSubquery->toSql()}) AS pcp_board_votes")) // db prefix required
            ->mergeBindings($boardVotesSubquery) // no getQuery() necessary
            ->select('board_votes.voted_sum', 'board_votes.rank_voted_sum', 'board_votes.admission_percent')
            ->distinct()
            ->orderByDesc('board_votes.voted_sum')
            ->get();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' vote_assigned_board: '.json_encode($this->vote_assigned_board));

        $this->work_list = $boardVotesSubquery->get();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' work_list: '.json_encode($this->work_list));

    }

    /**
     * 2. Then Show
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return view('livewire.organization.contest.section-admission');
    }

    /**
     * Act to reset and assign admit
     * 1. for all works in section update admit = no  | false
     * 2. for some works n section update admit = yes | true
     */
    public function setAdminFromValue(string $admitFrom)
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' in: '.$admitFrom);
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' work_list: '.json_encode($this->work_list));

        // 1. reset previous set for all
        if (ContestWork::where('section_id', $this->section_id)->where('is_admit', true)->count()) {
            $resettedWorks = ContestWork::where('section_id', $this->section_id)
                ->where('is_admit', 1)
                ->update(['is_admit' => 0]);
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' resettedWorks: '.$resettedWorks);
        }

        // 2. set for some - old style but
        foreach ($this->work_list as $value) {
            if ($value->voted_sum >= $admitFrom) {
                $admitWork = ContestWork::where('section_id', $this->section_id)
                    ->where('work_id', $value->work_id)
                    ->update(['is_admit' => true]);
                Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' admitWork: '.$admitWork);
            }
        }

    }
}
