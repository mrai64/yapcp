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
    public string $contestId;

    public $todayIsoFormat;

    public $todayExtendedFormat;

    public $contest;

    public $sections;

    public $juryMemberSet;

    public $jurorSignSet;

    public $organization;

    // counters by section_code
    public array $allWorksCounter;

    public array $allParticipantsCounter;

    public array $admittedWorksCounter = [];

    public array $admittedAuthorsCounters;

    // section awards
    public $awards;

    public $contestAwardSet;

    public static function buildMinute(string $cid) // route
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called w/input: '.$cid);
        ds('buildMinute: '.$cid);

        $contestId = $cid;
        $contest = Contest::where('id', $contestId)->firstOrFail();
        ds($contest);

        $todayIsoFormat = CarbonImmutable::now()->toDateString();
        $todayExtendedFormat = strtolower(CarbonImmutable::now()->format('l d F Y'));

        $sections = ContestSection::where('contest_id', $contestId)->get();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' sections: '.json_encode($sections));

        $organization = Organization::where('id', $contest->organization_id)->firstOrFail();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' organization: '.json_encode($organization));

        $juryMemberSet = [];
        $jurorSignSet = [];
        $allWorksCounter = [];
        $allParticipantsCounter = [];
        $admittedWorksCounter = [];
        $admittedAuthorsCounters = [];
        $awards = [];
        foreach ($sections as $section) {
            // jury members
            $juryMemberSet[$section->code] = ContestJury::select(['user_contacts.country_id', 'user_contacts.last_name', 'user_contacts.first_name', 'countries.flag_code'])
                ->leftJoin('user_contacts', 'user_contacts.id', '=', 'contest_juries.user_contact_id')
                ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
                ->where('section_id', $section->id)
                ->get();

            // juror signs
            foreach ($juryMemberSet[$section->code] as $juror) {
                $jn = $juror->last_name.', '.$juror->first_name;
                $jurorSignSet[$jn] = true;
            }
            ksort($jurorSignSet, SORT_STRING);
            reset($jurorSignSet);

            // allWorksCounter
            $allWorksCounter[$section->code] = ContestWork::where('contest_id', $contestId)
                ->where('section_id', $section->id)->count();

            // authors participant all
            $allParticipantsCounter[$section->code] = DB::table('contest_works')
                ->where('contest_id', $contestId)
                ->where('section_id', $section->id)
                ->distinct('user_id')
                ->count('user_id');

            // admittedWorksCounter
            $admittedWorksCounter[$section->code] = ContestWork::where('contest_id', $contestId)
                ->where('section_id', $section->id)
                ->where('is_admit', 1)
                ->count();

            // authors participant
            $admittedAuthorsCounters[$section->code] = DB::table('contest_works')
                ->where('contest_id', $contestId)
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
                ->leftJoin('user_contacts', 'contest_awards.winner_user_id', '=', 'user_contacts.id')
                ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
                ->leftJoin('works', 'contest_awards.winner_work_id', '=', 'works.id')
                ->where('contest_awards.contest_id', $contestId)
                ->where('contest_awards.section_id', $section->id)
                ->orderBy('contest_awards.award_code')
                ->get();

        }
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' jury_mem: '.json_encode($juryMemberSet));

        // should be only winner_name without winner_user_id
        $contestAwardSet = ContestAward::select(
            'contest_awards.*',
            'countries.flag_code',
            DB::raw("COALESCE(pcp_user_contacts.country_id, '') AS country_id"),
            DB::raw("COALESCE(pcp_user_contacts.last_name, '') AS last_name"),
            DB::raw("COALESCE(pcp_user_contacts.first_name, '') AS first_name")
        )
            ->leftJoin('user_contacts', 'user_contacts.id', '=', 'contest_awards.winner_user_id')
            ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
            ->whereNull('contest_awards.section_id')
            ->where('contest_awards.contest_id', $contestId)
            ->orderBy('contest_awards.award_code')
            ->get();

        $pdfFileName = 'minute-'.$todayIsoFormat.'.pdf';
        $pdfDataSet = [
            'contest_id' => $contestId,
            'todayIsoFormat' => $todayIsoFormat,
            'todayExtendedFormat' => $todayExtendedFormat,
            'contest' => $contest,
            'sections' => $sections,
            'juryMemberSet' => $juryMemberSet,
            'jurorSignSet' => $jurorSignSet,
            'organization' => $organization,
            'allWorksCounter' => $allWorksCounter,
            'allParticipantsCounter' => $allParticipantsCounter,
            'admittedWorksCounter' => $admittedWorksCounter,
            'admittedAuthorsCounters' => $admittedAuthorsCounters,
            'awards' => $awards,
            'contestAwardSet' => $contestAwardSet,
        ];
        // ds('pdfDataSet');
        ds($pdfDataSet);

        return view('livewire.organization.minute.draft', $pdfDataSet);
    }
}
