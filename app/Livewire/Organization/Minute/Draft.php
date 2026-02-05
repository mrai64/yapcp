<?php

/**
 * Build the draft of the jury minute
 *
 * WARN: this build a visual view, the real minute-maker is
 * instead into /app/http/controllers/juryminutedraft.php
 *
 * @see </resources/views/livewire/organization/minute/draft.blade.php>
 */

namespace App\Livewire\Organization\Minute;

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestJury;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\Organization;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Draft extends Component
{
    public string $contest_id;

    public $today_iso;

    public $today_extended;

    public $contest;

    public $sections;

    public $jury_members;

    public $juror_signs;

    public $organization;

    // counters
    public $works_participants_all;

    public $authors_participant_all;

    public array $admittedWorksCounter = [];

    public $admittedAuthorsCounters;

    // section awards
    public $awards;

    public $contest_awards;

    public static function buildMinute(string $cid) // route
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called w/input: '.$cid);
        ds('buildMinute: '.$cid);

        $contest_id = $cid;
        $contest = Contest::where('id', $contest_id)->firstOrFail();
        ds($contest);

        $today_iso = CarbonImmutable::now()->toDateString();
        $today_extended = strtolower(CarbonImmutable::now()->format('l d F Y'));

        $sections = ContestSection::where('contest_id', $contest_id)->get();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' sections: '.json_encode($sections));

        $organization = Organization::where('id', $contest->organization_id)->firstOrFail();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' organization: '.json_encode($organization));

        $jury_members = [];
        $juror_signs = [];
        $works_participants_all = [];
        $authors_participant_all = [];
        $admittedWorksCounter = [];
        $admittedAuthorsCounters = [];
        $awards = [];
        foreach ($sections as $section) {
            // jury members
            $jury_members[$section->code] = ContestJury::select(['user_contacts.country_id', 'user_contacts.last_name', 'user_contacts.first_name', 'countries.flag_code'])
                ->leftJoin('user_contacts', 'user_contacts.user_id', '=', 'contest_juries.user_contact_id')
                ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
                ->where('section_id', $section->id)
                ->get();

            // juror signs
            foreach ($jury_members[$section->code] as $juror) {
                $jn = $juror->last_name.', '.$juror->first_name;
                $juror_signs[$jn] = true;
            }
            ksort($juror_signs, SORT_STRING);
            reset($juror_signs);

            // works_participants_all
            $works_participants_all[$section->code] = ContestWork::where('contest_id', $contest_id)
                ->where('section_id', $section->id)->count();

            // authors participant all
            $authors_participant_all[$section->code] = DB::table('contest_works')
                ->where('contest_id', $contest_id)
                ->where('section_id', $section->id)
                ->distinct('user_id')
                ->count('user_id');

            // admittedWorksCounter
            $admittedWorksCounter[$section->code] = ContestWork::where('contest_id', $contest_id)
                ->where('section_id', $section->id)
                ->where('is_admit', 1)
                ->count();

            // authors participant
            $admittedAuthorsCounters[$section->code] = DB::table('contest_works')
                ->where('contest_id', $contest_id)
                ->where('section_id', $section->id)
                ->where('is_admit', 1)
                ->distinct('user_id')
                ->count('user_id');

            // awards
            $awards[$section->code] = DB::table('contest_awards')
                ->select([
                    'contest_awards.award_code',
                    'contest_awards.award_name',
                    'countries.flag_code',
                    'user_contacts.last_name',
                    'user_contacts.first_name',
                    'user_contacts.country_id',
                    'works.title_en',
                    'works.work_file',
                ])
                ->leftJoin('user_contacts', 'contest_awards.winner_user_id', '=', 'user_contacts.user_id')
                ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
                ->leftJoin('works', 'contest_awards.winner_work_id', '=', 'works.id')
                ->where('contest_awards.contest_id', $contest_id)
                ->where('contest_awards.section_id', $section->id)
                ->orderBy('contest_awards.award_code')
                ->get();

        }
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' jury_mem: '.json_encode($jury_members));

        // should be only winner_name without winner_user_id
        $contest_awards = ContestAward::select(
            'contest_awards.*',
            'countries.flag_code',
            DB::raw("COALESCE(pcp_user_contacts.country_id, '') AS country_id"),
            DB::raw("COALESCE(pcp_user_contacts.last_name, '') AS last_name"),
            DB::raw("COALESCE(pcp_user_contacts.first_name, '') AS first_name")
        )
            ->leftJoin('user_contacts', 'user_contacts.user_id', '=', 'contest_awards.winner_user_id')
            ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
            ->whereNull('contest_awards.section_id')
            ->where('contest_awards.contest_id', $contest_id)
            ->orderBy('contest_awards.award_code')
            ->get();

        $pdf_save = 'minute-'.$today_iso.'.pdf';
        $pdf_data = [
            'contest_id' => $contest_id,
            'today_iso' => $today_iso,
            'today_extended' => $today_extended,
            'contest' => $contest,
            'sections' => $sections,
            'jury_members' => $jury_members,
            'juror_signs' => $juror_signs,
            'organization' => $organization,
            'works_participants_all' => $works_participants_all,
            'authors_participant_all' => $authors_participant_all,
            'admittedWorksCounter' => $admittedWorksCounter,
            'admittedAuthorsCounters' => $admittedAuthorsCounters,
            'awards' => $awards,
            'contest_awards' => $contest_awards,
        ];
        // ds('pdf_data');
        ds($pdf_data);

        return view('livewire.organization.minute.draft', $pdf_data);
    }
}
