<?php

/**
 * Build Jury Miniature at ending of jury works
 *
 * scope: download A4 pdf
 */

namespace App\Http\Controllers\Contest;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestJury;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\Organization;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelPdf\Facades\Pdf;

class JuryMinuteDraft extends Controller
{
    // build the draft of the jury minute
    public function buildMinute(string $cid) // route
    {
        Log::info('Controller '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called w/input: '.$cid);
        $contestId = $cid;
        $contest = Contest::where('id', $contestId)->firstOrFail();

        $organization = Organization::where('id', $contest->organization_id)->first();

        $todayIso = CarbonImmutable::now()->rawFormat('Y-m-d_H-i-s');
        $todayExtended = strtolower(CarbonImmutable::now()->format('l, d F Y'));

        $sections = ContestSection::where('contest_id', $contestId)->get();

        $juryMemberSet = [];
        $jurorSignageBlock = [];
        $allParticipantWorks = [];
        $allParticipantAuthors = [];
        $admittedWorks = [];
        $admittedAuthors = [];
        $awards = [];
        // ds('Controller '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' this: '.json_encode($this));

        foreach ($sections as $section) {
            // jury members
            $juryMemberSet[$section->code] = ContestJury::select(['user_contacts.country_id', 'user_contacts.last_name', 'user_contacts.first_name', 'countries.flag_code'])
                ->leftJoin('user_contacts', 'user_contacts.id', '=', 'contest_juries.user_contact_id') // was: 'user_contacts.user_id', '=', 'contest_juries.user_contact_id')
                ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
                ->where('section_id', $section->id)
                ->get();

            // juror signs
            foreach ($juryMemberSet[$section->code] as $juror) {
                $jn = $juror->last_name.', '.$juror->first_name;
                $jurorSignageBlock[$jn] = true;
            }
            ksort($jurorSignageBlock, SORT_STRING);
            reset($jurorSignageBlock);

            // works_participants_all
            $allParticipantWorks[$section->code] = ContestWork::where('contest_id', $contestId)
                ->where('section_id', $section->id)->count();

            // authors participant all
            $allParticipantAuthors[$section->code] = DB::table('contest_works')
                ->where('contest_id', $contestId)
                ->where('section_id', $section->id)
                ->distinct('user_id')
                ->count('user_id');

            // works_admitted
            $admittedWorks[$section->code] = ContestWork::where('contest_id', $contestId)
                ->where('section_id', $section->id)
                ->where('is_admit', 1)
                ->count();

            // authors participant
            $admittedAuthors[$section->code] = DB::table('contest_works')
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
                ->leftJoin('user_contacts', 'contest_awards.winner_user_id', '=', 'user_contacts.id') // was: 'contest_awards.winner_user_id', '=', 'user_contacts.user_id')
                ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
                ->leftJoin('works', 'contest_awards.winner_work_id', '=', 'works.id')
                ->where('contest_awards.contest_id', $contestId)
                ->where('contest_awards.section_id', $section->id)
                ->orderBy('contest_awards.award_code')
                ->get();

        }
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' jury_mem: ' . json_encode($juryMemberSet));

        // should be only winner_name without winner_user_id
        $contestAwardSet = ContestAward::select(
            'contest_awards.*',
            'countries.flag_code',
            DB::raw("COALESCE(pcp_user_contacts.country_id, '') AS country_id"),
            DB::raw("COALESCE(pcp_user_contacts.last_name, '') AS last_name"),
            DB::raw("COALESCE(pcp_user_contacts.first_name, '') AS first_name")
        )
            ->leftJoin('user_contacts', 'user_contacts.id', '=', 'contest_awards.winner_user_id') // was: 'user_contacts.user_id', '=', 'contest_awards.winner_user_id')
            ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
            ->whereNull('contest_awards.section_id')
            ->where('contest_awards.contest_id', $contestId)
            ->orderBy('contest_awards.award_code')
            ->get();

        // $pdfFilename = 'storage/contests/'.$contestId.'/jury-minute-'.$todayIso.'.pdf';
        $pdfFilename = 'jury-minute-' . $todayIso . '.pdf';

        $pdfContent = [
            'contest_id' => $contestId,
            'today_iso' => $todayIso,
            'today_extended' => $todayExtended,
            'contest' => $contest,
            'sections' => $sections,
            'jury_members' => $juryMemberSet,
            'juror_signs' => $jurorSignageBlock,
            'organization' => $organization,
            'works_participants_all' => $allParticipantWorks,
            'authors_participant_all' => $allParticipantAuthors,
            'works_admitted' => $admittedWorks,
            'authors_admitted' => $admittedAuthors,
            'awards' => $awards,
            'contest_awards' => $contestAwardSet,
        ];
        // ds('Controller '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' pdfContent: '.json_encode($pdfContent));

        $chromePath = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
        // ds('Controller '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' pdfContent: '.json_encode($pdfContent));

        return Pdf::view('livewire.organization.minute.draft', $pdfContent)
            ->withBrowsershot(function ($browsershot) use ($chromePath) {
                $browsershot->setChromePath($chromePath);
                $browsershot->inlineCss();
            })
            ->format('A4')
            ->name($pdfFilename)
            ->download(); // was: ->save($pdfFilename);
    }
}
