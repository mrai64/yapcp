<?php

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
use Spatie\LaravelPdf\Facades\Pdf;

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

    public $works_admitted;

    public $authors_admitted;

    // section awards
    public $awards;

    public $contest_awards;

    public function mount(string $cid) // route
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $this->contest_id = $cid;
        $this->contest = Contest::where('id', $this->contest_id)->firstOrFail();
        // ds($this->contest);

        $this->today_iso = CarbonImmutable::now()->toDateString();
        $this->today_extended = strtolower(CarbonImmutable::now()->format('l d F Y'));

        $this->sections = ContestSection::where('contest_id', $this->contest_id)->get();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' sections: '.json_encode($this->sections));

        $this->organization = Organization::where('id', $this->contest->organization_id)->firstOrFail();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' organization: '.json_encode($this->organization));

        $this->jury_members = [];
        $this->juror_signs = [];
        $this->works_participants_all = [];
        $this->authors_participant_all = [];
        foreach ($this->sections as $section) {
            // jury members
            $this->jury_members[$section->code] = ContestJury::select(['user_contacts.country_id', 'user_contacts.last_name', 'user_contacts.first_name', 'countries.flag_code'])
                ->leftJoin('user_contacts', 'user_contacts.user_id', '=', 'contest_juries.user_contact_id')
                ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
                ->where('section_id', $section->id)
                ->get();

            // juror signs
            foreach ($this->jury_members[$section->code] as $juror) {
                $jn = $juror->last_name.', '.$juror->first_name;
                $this->juror_signs[$jn] = true;
            }
            ksort($this->juror_signs, SORT_STRING);
            reset($this->juror_signs);

            // works_participants_all
            $this->works_participants_all[$section->code] = ContestWork::where('contest_id', $this->contest_id)
                ->where('section_id', $section->id)->count();

            // authors participant all
            $this->authors_participant_all[$section->code] = DB::table('contest_works')
                ->where('contest_id', $this->contest_id)
                ->where('section_id', $section->id)
                ->distinct('user_id')
                ->count('user_id');

            // works_admitted
            $this->works_admitted[$section->code] = ContestWork::where('contest_id', $this->contest_id)
                ->where('section_id', $section->id)
                ->where('is_admit', 1)
                ->count();

            // authors participant
            $this->authors_admitted[$section->code] = DB::table('contest_works')
                ->where('contest_id', $this->contest_id)
                ->where('section_id', $section->id)
                ->where('is_admit', 1)
                ->distinct('user_id')
                ->count('user_id');

            // awards
            $this->awards[$section->code] = DB::table('contest_awards')
                ->select([
                    'contest_awards.award_code',
                    'contest_awards.award_name',
                    'countries.flag_code',
                    'user_contacts.last_name',
                    'user_contacts.first_name',
                    'works.title_en',
                    'works.work_file',
                ])
                ->leftJoin('user_contacts', 'contest_awards.winner_user_id', '=', 'user_contacts.user_id')
                ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
                ->leftJoin('works', 'contest_awards.winner_work_id', '=', 'works.id')
                ->where('contest_awards.contest_id', $this->contest_id)
                ->where('contest_awards.section_id', $section->id)
                ->orderBy('contest_awards.award_code')
                ->get();

        }
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' jury_mem: '.json_encode($this->jury_members));

        // should be only winner_name without winner_user_id
        $this->contest_awards = ContestAward::select(
            'contest_awards.*',
            'countries.flag_code',
            DB::raw("COALESCE(pcp_user_contacts.country_id, '') AS country_id"),
            DB::raw("COALESCE(pcp_user_contacts.last_name, '') AS last_name"),
            DB::raw("COALESCE(pcp_user_contacts.first_name, '') AS first_name")
        )
            ->leftJoin('user_contacts', 'user_contacts.user_id', '=', 'contest_awards.winner_user_id')
            ->leftJoin('countries', 'user_contacts.country_id', '=', 'countries.id')
            ->whereNull('contest_awards.section_id')
            ->where('contest_awards.contest_id', $this->contest_id)
            ->orderBy('contest_awards.award_code')
            ->get();

    }

    public function render()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        $pdf_save = 'minute-'.$this->today_iso.'.pdf';
        $pdf_data = [
            'contest_id' => $this->contest_id,
            'today_iso' => $this->today_iso,
            'today_extended' => $this->today_extended,
            'contest' => collect($this->contest)->toArray(),
            'sections' => collect($this->sections)->toArray(),
            'jury_members' => $this->jury_members,
            'juror_signs' => $this->juror_signs,
            'organization' => collect($this->organization)->toArray(),
            'works_participants_all' => $this->works_participants_all,
            'authors_participant_all' => $this->authors_participant_all,
            'works_admitted' => $this->works_admitted,
            'authors_admitted' => $this->authors_admitted,
            'awards' => $this->awards,
            'contest_awards' => collect($this->contest_awards)->toArray(),
        ];
        ds('pdf_data');
        ds($pdf_data);

        //return view('livewire.organization.minute.draft', $pdf_data);
        return Pdf::view('livewire.organization.minute.draft', $pdf_data)
            ->name($pdf_save);
    }
}
