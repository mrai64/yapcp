<?php

/**
 * Open http://yapcp.test/organization/reports/works-participant/{cid}
 * Contest test http://yapcp.test/organization/reports/works-participant/e8ac5674-c3d1-4afa-adaf-a7d5ed82d292
 */

namespace App\Livewire\Organization\Reports;

use App\Models\Contest;
use App\Models\ContestSection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WorksParticipant extends Component
{
    public $contestId;

    public $contest;

    public $sections;

    public $sectionWorks;

    public function mount($cid) // route param
    {
        $this->contestId = $cid;
        $this->contest = Contest::find($this->contestId);

        $this->sections = ContestSection::where('contest_id', $this->contestId)
            ->orderBy('created_at', 'asc')
            ->get();

        $this->sectionWorks = [];
        foreach ($this->sections as $section) {
            $works = DB::table('contest_works')
                // LEFT JOIN user_contacts on (contest_works.user_id = user_contacts.id)
                ->leftJoin('user_contacts', 'contest_works.user_id', '=', 'user_contacts.id')

                // LEFT JOIN works on (contest_works.work_id = works.id)
                ->leftJoin('works', 'contest_works.work_id', '=', 'works.id')

                // LEFT JOIN countries on (user_contacts.country_id = countries.id)
                ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')

                // LEFT JOIN contest_awards on (contest_awards.winner_work_id = contest_works.work_id)
                ->leftJoin('contest_awards', 'contest_awards.winner_work_id', '=', 'contest_works.work_id')

                ->where('contest_works.contest_id', $section->contest_id)
                ->where('contest_works.section_id', $section->id)

                ->select([
                    'contest_works.section_id',
                    'countries.flag_code',
                    'user_contacts.country_id',
                    'user_contacts.last_name',
                    'user_contacts.first_name',
                    'contest_works.portfolio_sequence',
                    'works.work_file',
                    'works.title_en',
                    'contest_works.is_admit',
                    // db raw need prefix
                    DB::raw("COALESCE(`pcp_contest_awards`.award_name, '') AS award_assigned"),
                ])

                ->orderBy('contest_works.section_id')
                ->orderBy('user_contacts.country_id')
                ->orderBy('user_contacts.last_name')
                ->orderBy('user_contacts.first_name')
                ->orderBy('contest_works.portfolio_sequence')

                ->get();

            $this->sectionWorks[$section->id] = $works;
        }
    }

    public function render()
    {
        return view('livewire.organization.reports.works-participant');
    }
}
