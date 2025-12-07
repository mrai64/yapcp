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
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Termwind\Components\Raw;

class BeforeFinal extends Component
{
    use WithPagination;

    public string $section_id;

    public $contest_section;

    public $section;

    public string $contest_id;

    public $total_work_participants; // too much

    public $jury_votes;

    public $contest_votes;

    public function mount(string $sid) // route
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $this->section_id = $sid;
        $this->section = ContestSection::where('id', $sid)->first();
        $this->contest_id = $this->section->contest_id;

        $this->total_work_participants = ContestWork::where('section_id', $this->section_id)->where('contest_id', $this->contest_id)->count();
    }

    public function render()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        // that's a complex query - assuming that between navigation vote are unmodified
        $bindings = [
            'contest_id' => $this->contest_id,
            'section_id' => $this->section_id,
            'total_participant_works' => $this->total_work_participants,
        ];

        $subquery = DB::table(ContestVote::table_name)
            ->select(
                DB::raw('COUNT(*) AS vote_received'),
                DB::raw('SUM(vote) AS voted_sum'),
                'work_id'
            )
            ->where('contest_id', $this->contest_id)
            ->where('section_id', $this->section_id)
            ->groupBy('work_id');

        // mainQuery
        $SectionResult = DB::table(DB::raw("({$subquery->toSql()}) AS pcp_vote_data")) // in raw() MUST be explicity used db prefix if any and yes, now prefix is 'pcp_'
            ->select(
                'vote_data.vote_received', // no explicit prefix here
                'vote_data.voted_sum',
                'vote_data.work_id',
                DB::raw('RANK() OVER (ORDER BY pcp_vote_data.voted_sum DESC) AS rank_by_votes'),
                DB::raw("(10000 * RANK() OVER (ORDER BY pcp_vote_data.voted_sum DESC) / {$this->total_work_participants}) as admission_percent")
            )
            ->mergeBindings($subquery)
            ->orderBy('vote_data.voted_sum', 'desc')
            ->simplePaginate(12);
        // ->get();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' SectionResult'.json_encode($SectionResult));

        /*

        $SectionResult = DB::table('contest_votes')
            ->selectRaw(' SUM(pcp_contest_votes.vote) AS total_vote,
                            pcp_contest_votes.work_id,
                            pcp_works.user_id,
                            pcp_works.work_file,
                            pcp_works.title_en ')
            ->join('works', 'contest_votes.work_id', '=', 'works.id')
            ->where('contest_votes.section_id', $this->section_id)
            ->where('contest_votes.contest_id', $this->contest_id)
            ->groupBy('contest_votes.work_id', 'works.user_id', 'works.work_file', 'works.title_en')
            ->orderByDesc('total_vote')
            ->orderBy('works.work_file')
            ->simplePaginate(12);
            // ->get();

        */

        return view('livewire.organization.admit.before-final', [
            'sectionResult' => $SectionResult,
        ]);
    }
}
