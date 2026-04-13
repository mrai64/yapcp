<?php

/**
 * Contest Definition: first add
 * After click on New contest, an empty rec is made, then
 * the organization member write contest name, and other infos.
 * WARNING: That module FIRST SAVE, then modify Contest record
 * and not as usual LAST SAVE record
 *
 * 2025-09-17 fee_info added
 * 2025-12-04 review to support livewire header component
 * 2025-12-05 refactor Country::countriesSorted()
 * 2026-03-02 default value in CarbonImmutable
 *
 * TODO change is_circuit from Y/N to 1/0
 * TODO change circuit_id from text to select list
 * TODO change form 1 of 1 become 1 of N
 *
 */

namespace App\Livewire\Contest;

use App\Models\Contest;
use App\Models\Country;
use App\Models\LangList;
use App\Models\Organization;
use App\Models\Timezone;
use Carbon\CarbonImmutable;
use DateTimeImmutable;
use Illuminate\Validation\Validator;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Add extends Component
{
    use WithFileUploads;

    /**
     * form fields and tmp var
     */
    public Contest $contest;

    public Contest $circuit;

    public Organization $organization;

    // form fields list
    public string $contestId; // assigned

    public string $countryId; // contest.country_id fk:countries.id

    public Country $country;

    public array $countries; // country[]

    public string $contestNameEn; //

    public string $contestNameLocal; //

    public string $localLang; // LangList[]

    public $langSet = [];

    public string $organizationId; // organizations.id

    public string $contest_mark; // path n fle

    public $contest_image; // stored in 'contest' disk

    public string $contactInfo; // address, email, cell, and so on

    public string $isCircuit; // Y/N, TODO become boolean

    public string $circuitId; // required if...

    public string $federationPatronageList; // maybe federations_lis

    public string $url1Rule;

    public string $url2Concurrent;

    public string $url3Results;

    public string $url4Catalogs;

    public array $timezoneSet = [];
    public string $timezoneId;

    public CarbonImmutable $day1ParticipationOpening;
    public CarbonImmutable $day2ParticipationClosing;
    public CarbonImmutable $day3JuryOpening;
    public CarbonImmutable $day4JuryClosing;
    public CarbonImmutable $day5Revelations;
    public CarbonImmutable $day6Ceremony;
    public CarbonImmutable $day7Catalog;
    public CarbonImmutable $day8Ending;

    public string $awardCeremonyInfo; // location, date, online broadcast platform

    public string $feePaymentInfo;
    // created_at assigned
    // updated_at assigned
    // deleted_at assigned

    /**
     * Before the show
     */
    public function mount(string $oid) // organization_id as in route()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        $this->organization = Organization::where('id', $oid)->firstOrFail();
        $this->organizationId = $this->organization->id;
        $this->countries = Country::countriesSorted();
        $this->countryId = $this->organization->country_id;

        // form fields - default value
        $this->contestNameEn = 'Contest name';
        $this->contestNameLocal = 'Contest name in local lang';
        $timezoneSet = Timezone::orderBy('id')->pluck(['id']);
        $this->timezoneSet = collect($timezoneSet)->sortBy('id')->toArray();
        $this->timezoneId = 'Europe/Rome';
        // $langSet = Country::whereNotNull('lang_code')->pluck('lang_code');
        // $this->langSet = collect($langSet)->sortBy('lang_code')->toArray();
        $this->localLang = 'en';
        $this->contactInfo = 'Organization contact infos';

        $this->isCircuit = 'N'; // false
        $this->circuitId = '';

        /**
         * TODO must be replaced by a separate form
         * FED:code FED:code FED:code
         */
        $this->federationPatronageList = '';
        // web page
        $this->url1Rule = 'https://example.local/1/contest-rule';
        $this->url2Concurrent = 'https://example.local/2/concurrent-status-list';
        $this->url3Results = 'http://example.local/3/result-page';
        $this->url4Catalogs = 'http://example.local/4/download-n-web-catalogues';
        $this->feePaymentInfo = 'info about payment amount and platform ';
        // calendar default - show local time register utc time
        // opening: next month, 9:00
        $this->day1ParticipationOpening = CarbonImmutable::now()->addMonth()
            ->setHour(9)->setMinute(0);
        // closing: 3 weeks after day1, 23:59
        $this->day2ParticipationClosing = $this->day1ParticipationOpening->addWeeks(3)
            ->setHour(23)->setMinute(59); // immutable_datetime
        // jury opening 1 week later day2
        $this->day3JuryOpening = $this->day2ParticipationClosing->addWeek()
            ->setHour(9)->setMinute(0);
        $this->day4JuryClosing = $this->day3JuryOpening->addWeeks(2)
            ->setHour(23)->setMinute(59);
        $this->day5Revelations = $this->day4JuryClosing->addWeek()
            ->setHour(12)->setMinute(0);
        $this->day6Ceremony = $this->day5Revelations->addWeek()
            ->setHour(10)->setMinute(0);
        $this->awardCeremonyInfo = 'How n when Ceremony infos';
        $this->day7Catalog = $this->day6Ceremony->addWeek()
            ->setHour(9)->setMinute(0);
        $this->day8Ending = $this->day7Catalog->addWeeks(3)
            ->setHour(23)->setMinute(59);

        $this->contest = Contest::create([
            // id assigned uuid
            'is_circuit'       => $this->isCircuit,
            'circuit_id'       => $this->circuitId,

            'organization_id'  => $this->organizationId,
            'timezone_id'      => $this->timezoneId,

            'name_en'          => $this->contestNameEn,
            'name_local'       => $this->contestNameLocal,
            'lang_local'       => $this->localLang,

            'federation_list'  => $this->federationPatronageList,

            'contact_info'         => $this->contactInfo,
            'award_ceremony_info'  => $this->awardCeremonyInfo,
            'fee_info'             => $this->feePaymentInfo,

            'url_1_rule'               => $this->url1Rule,
            'url_2_concurrent_list'    => $this->url2Concurrent,
            'url_3_admit_n_award_list' => $this->url3Results,
            'url_4_catalogue'          => $this->url4Catalogs,
            //
            'day_1_opening'      => $this->day1ParticipationOpening,
            'day_2_closing'      => $this->day2ParticipationClosing,
            'day_3_jury_opening' => $this->day3JuryOpening,
            'day_4_jury_closing' => $this->day4JuryClosing,
            'day_5_revelations'  => $this->day5Revelations,
            'day_6_awards'       => $this->day6Ceremony,
            'day_7_catalogues'   => $this->day7Catalog,
            'day_8_closing'      => $this->day8Ending,
        ]);

        $this->contestId = $this->contest->id;
    }

    /**
     * Show must go
     */
    public function render()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ .' called');

        return view('livewire.contest.add');
    }

    /**
     * Validation
     * see also <https://laravel.com/docs/12.x/validation#available-validation-rules>
     * see also <https://laravel.com/docs/12.x/validation#custom-validation-rules>
     *
     * rules() first for auto validation
     * after() after rules()
     */
    public function rules()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return [
            // id           assigned, not in form
            'countryId' => 'required|string|exists:countries,id',
            'contestNameEn' => 'required|string',
            'contestNameLocal' => 'required|string',
            'localLang' => 'required|string|exists:countries,lang_code',
            // organization_id by uri,   not in form
            // contest_mark
            'isCircuit' => 'required|string|uppercase|size:1', // in(['N','Y'])
            'circuitId' => 'nullable|string|exists:contests,id', //
            'federationPatronageList' => 'string|max:255',

            'url1Rule' => 'required|string|max:255',
            'url2Concurrent' => 'required|string|max:255',
            'url3Results' => 'required|string|max:255',
            'url4Catalogs' => 'required|string|max:255',

            'timezoneId' => 'required|string',
            'day1ParticipationOpening' => 'required|date|after_or_equal:today',
            'day2ParticipationClosing' => 'required|date|after_or_equal:day1ParticipationOpening',
            'day3JuryOpening' => 'required|date|after_or_equal:day2ParticipationClosing',
            'day4JuryClosing' => 'required|date|after_or_equal:day3JuryOpening',
            'day5Revelations' => 'required|date|after_or_equal:day4JuryClosing',
            'day6Ceremony' => 'required|date|after_or_equal:day5Revelations',
            'day7Catalog' => 'required|date|after_or_equal:day6Ceremony',
            'day8Ending' => 'required|date|after_or_equal:day7Catalog',

            'contactInfo' => 'required|string',
            'awardCeremonyInfo' => 'required|string',
            'feePaymentInfo' => 'required|string',
            // created_at
            // updated_at
            // deleted_at
        ];
    }

    /**
     * TODO Check if adopt a \Rules
     * after means after rules()
     */
    public function after(): array
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return [
            function (Validator $validator) {
                // like validate but
                if ($this->isCircuit != 'Y') {
                    $this->isCircuit = 'N';
                }

                if (! in_array($this->timezoneId, $this->timezoneSet)) {
                    $validator->errors()->add(
                        'timezoneId',
                        __('Must be one of list')
                    );
                }

                // insert here check for date limits
                $day1ParticipationOpening = new DateTimeImmutable($this->day1ParticipationOpening);
                $day2ParticipationClosing = new DateTimeImmutable($this->day2ParticipationClosing);
                $day8Ending = new DateTimeImmutable($this->day8Ending);
                $duration = date_diff($day2ParticipationClosing, $day8Ending);
                if ($duration->format('%a%') > '65') {
                    // maybe 7 greater than 65?
                    $validator->errors()->add(
                        'day8Ending',
                        __('Must not be more than 65 day from day_2 participation closing')
                    );
                }
            },
        ];
    }

    public function saveNewContest()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $validated = $this->validate();

        $this->contest = Contest::where('id', $this->contestId)->first();
        $this->contest->country_id                = $validated['countryId'];
        $this->contest->name_en                   = $validated['contestNameEn'];
        $this->contest->name_local                = $validated['contestNameLocal'] ?? '';
        // $this->contest->lang_local                = $validated['localLang'];
        $this->contest->is_circuit                = $validated['isCircuit'];
        $this->contest->circuit_id                = $validated['circuitId'];
        $this->contest->federation_list           = $validated['federationPatronageList'];
        $this->contest->organization_id           = $this->organizationId;
        $this->contest->timezone_id               = $validated['timezoneId'];

        $this->contest->url_1_rule                = $validated['url1Rule'];
        $this->contest->url_2_concurrent_list     = $validated['url2Concurrent'];
        $this->contest->url_3_admit_n_award_list  = $validated['url3Results'];
        $this->contest->url_4_catalogue           = $validated['url4Catalogs'];


        $this->contest->day_1_opening         = $validated['day1ParticipationOpening'];
        $this->contest->day_2_closing         = $validated['day2ParticipationClosing'];
        $this->contest->day_3_jury_opening    = $validated['day3JuryOpening'];
        $this->contest->day_4_jury_closing    = $validated['day4JuryClosing'];
        $this->contest->day_5_revelations     = $validated['day5Revelations'];
        $this->contest->day_6_awards          = $validated['day6Ceremony'];
        $this->contest->day_7_catalogues      = $validated['day7Catalog'];
        $this->contest->day_8_closing         = $validated['day8Ending'];
        // vote_rule
        $this->contest->contact_info          = $validated['contactInfo'];
        $this->contest->award_ceremony_info   = $validated['awardCeremonyInfo'];
        $this->contest->fee_info              = $validated['feePaymentInfo'];
        //
        $this->contest->save();

        // redirect
        return redirect()
            ->route('organization.dashboard', ['organization' => $this->organizationId])
            ->with('success', __('New Contest added to list, enjoy!'));
    }
}
