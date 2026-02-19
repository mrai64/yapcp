<?php

/**
 * State f the Art for contest section
 * - infos of contest
 * - infos of section
 * - for every juror how many voted
 * - sum of votes (no compensations)
 *
 * Page used by the competition organization to review
 * the jury's scoreboard, and to request a review of the
 * score on a limited group of works to reduce the number
 * and percentage of admitted works. When required.
 */

namespace App\Livewire\Organization\Admit;

use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\ContestWork;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Termwind\Components\Raw;

class BeforeFinal extends Component
{
    use WithPagination;

    public string $sectionId;

    // public $contest_section;
    public $section;

    public string $contestId;

    public $workParticipantsCounter; // too much

    // public $jury_votes;
    // public $contest_votes;

    public function mount(string $sid) // route
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $this->section = ContestSection::where('id', $sid)->first();
        $this->sectionId = $sid;
        $this->contestId = $this->section->contest_id;

        $this->workParticipantsCounter = ContestWork::where('section_id', $this->sectionId)
            ->where('contest_id', $this->contestId)
            ->count();
    }

    public function render()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        // that's a complex query - assuming that between navigation vote are unmodified
        $bindings = [
            'contest_id' => $this->contestId,
            'section_id' => $this->sectionId,
            'total_participant_works' => $this->workParticipantsCounter,
        ];

        $subquery = DB::table(ContestVote::TABLENAME)
            ->select(
                DB::raw('COUNT(*) AS vote_received'),
                DB::raw('SUM(vote) AS voted_sum'),
                'work_id'
            )
            ->where('contest_id', $this->contestId)
            ->where('section_id', $this->sectionId)
            ->groupBy('work_id');

        // mainQuery
        // in raw() MUST be explicity used db prefix if any and yes, now prefix is 'pcp_'
        $sectionResult = DB::table(DB::raw("({$subquery->toSql()}) AS pcp_vote_data"))
            ->select(
                'vote_data.vote_received', // no explicit prefix here
                'vote_data.voted_sum',
                'vote_data.work_id',
                DB::raw('RANK() OVER (ORDER BY pcp_vote_data.voted_sum DESC) AS rank_by_votes'),
                DB::raw("(10000 * RANK() OVER (ORDER BY pcp_vote_data.voted_sum DESC) / {$this->workParticipantsCounter}) as admission_percent")
            )
            ->mergeBindings($subquery)
            ->orderBy('vote_data.voted_sum', 'desc')
            ->simplePaginate(12);
        // ->get();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' sectionResult' . json_encode($sectionResult));

        /*

        $sectionResult = DB::table('contest_votes')
            ->selectRaw(' SUM(pcp_contest_votes.vote) AS total_vote,
                            pcp_contest_votes.work_id,
                            pcp_works.user_id,
                            pcp_works.work_file,
                            pcp_works.title_en ')
            ->join('works', 'contest_votes.work_id', '=', 'works.id')
            ->where('contest_votes.section_id', $this->sectionId)
            ->where('contest_votes.contest_id', $this->contestId)
            ->groupBy('contest_votes.work_id', 'works.user_id', 'works.work_file', 'works.title_en')
            ->orderByDesc('total_vote')
            ->orderBy('works.work_file')
            ->simplePaginate(12);
            // ->get();

        */

        return view('livewire.organization.admit.before-final', [
            'sectionResult' => $sectionResult,
        ]);
    }
}
