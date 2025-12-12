<?php

namespace App\Livewire\Organization\Section;

use App\Models\Contest;
use App\Models\ContestSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Header extends Component
{
    public string $contest_id;

    public string $section_id;

    public $contest;

    public $section_set;

    public $main_query;

    public $bindings;

    public $counters_set;

    public function mount(string $cxsid) // livewire
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        // check contest_id xor section_id
        $count_contest = Contest::where('id', $cxsid)->count();
        $count_section = ContestSection::where('id', $cxsid)->count();
        if ($count_section) {
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' section found');
            $this->section_id = $cxsid;
            $contestId = ContestSection::where('id', $cxsid)->first();
            $this->contest_id = $contestId->contest_id;
        } elseif ($count_contest) {
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' contest found');
            $this->section_id = '';
            $this->contest_id = $cxsid;
        } else {
            Log::alert('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' '.$cxsid.' not found');
            abort(404);
        }

        //
        $this->contest = Contest::where('id', $this->contest_id)->first();
        $this->section_set = ContestSection::where('contest_id', $this->contest_id)->get();

        // counters
        /*
        WITH SectionWorks AS (
            SELECT
                section_id,
                COUNT(id) AS participants_count
            FROM
                pcp_contest_works
            WHERE
                contest_id = 'e8ac5674-c3d1-4afa-adaf-a7d5ed82d292'
                and deleted_at is NULL
            GROUP BY
                section_id
        ),
        SectionAwards AS (
            SELECT
                section_id,
                COUNT(id) AS prizes_count
            FROM
                pcp_contest_awards
            WHERE
                contest_id = 'e8ac5674-c3d1-4afa-adaf-a7d5ed82d292'
                and deleted_at is NULL
            GROUP BY
                section_id
        ),
        AssignedAwards AS (
            SELECT
                section_id,
                COUNT(id) AS assigned_prizes_count
            FROM
                pcp_contest_awards
            WHERE
                contest_id = 'e8ac5674-c3d1-4afa-adaf-a7d5ed82d292'
                and winner_work_id is NOT NULL
                and deleted_at is NULL
            GROUP BY
                section_id
        )
        SELECT
            s.code,
            s.name_en,
            COALESCE(w.participants_count, 0) AS participants,
            COALESCE(a.prizes_count, 0) AS prizes,
            COALESCE(aa.assigned_prizes_count, 0) AS assigned
        FROM
            pcp_contest_sections s
        LEFT JOIN
            SectionWorks w ON w.section_id = s.id
        LEFT JOIN
            SectionAwards a ON a.section_id = s.id
        LEFT JOIN
            AssignedAwards aa ON aa.section_id = s.id
        WHERE
            s.contest_id = 'e8ac5674-c3d1-4afa-adaf-a7d5ed82d292'
            and s.deleted_at is NULL
        ORDER BY
            s.code;
        */

        // 1. subquery - works in section
        $section_works_subquery = '
            SELECT  section_id, COUNT(id) as participants_count
            FROM pcp_contest_works
            WHERE contest_id = :contestId1
              AND deleted_at IS NULL
            GROUP BY section_id
        ';
        // 2. subquery - awards in section
        $section_awards_subquery = '
            SELECT section_id, COUNT(id) as section_awards_count
            FROM pcp_contest_awards
            WHERE contest_id = :contestId2
              AND deleted_at IS NULL
            GROUP BY section_id
        ';
        // 3. subquery - assigned awards in section
        $section_assigned_subquery = '
            SELECT section_id, COUNT(id) as assigned_prizes_count
            FROM pcp_contest_awards
            WHERE contest_id = :contestId3
              AND winner_work_id IS NOT NULL
              AND deleted_at IS NULL
            GROUP BY section_id
        ';
        // main query
        $main_query = "
            WITH SectionWorks AS ({$section_works_subquery}),
                SectionAwards AS ({$section_awards_subquery}),
                AssignedAwards AS ({$section_assigned_subquery})
                SELECT
                    s.code,
                    s.name_en,
                    COALESCE(w.participants_count, 0) AS participants,
                    COALESCE(a.section_awards_count, 0) AS prizes,
                    COALESCE(aa.assigned_prizes_count, 0) AS assigned
                FROM
                    pcp_contest_sections s
                LEFT JOIN
                    SectionWorks w ON w.section_id = s.id
                LEFT JOIN
                    SectionAwards a ON a.section_id = s.id
                LEFT JOIN
                    AssignedAwards aa ON aa.section_id = s.id
                WHERE
                    s.contest_id = :contestId4
                    AND s.deleted_at IS NULL
                ORDER BY
                    s.code
        ";
        // bindings
        $bindings = [
            'contestId1' => $this->contest_id,
            'contestId2' => $this->contest_id,
            'contestId3' => $this->contest_id,
            'contestId4' => $this->contest_id,
        ];

        $this->main_query = $main_query;
        $this->bindings = $bindings;
        // $this->counters_set = DB::select($main_query, $bindings);
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

    }

    public function render()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $this->counters_set = DB::select($this->main_query, $this->bindings);

        return view('livewire.organization.section.header');
    }
}
