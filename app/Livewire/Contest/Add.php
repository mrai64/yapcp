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
 * 2025-12-05 refactor Country::country_list_by_country()
 *
 * TODO change is_circuit from Y/N to 1/0
 * TODO change circuit_id from text to select list
 */

namespace App\Livewire\Contest;

use App\Models\Contest;
use App\Models\Country;
use App\Models\LangList;
use App\Models\Organization;
use App\Models\TimezonesList;
use DateTimeImmutable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
    public string $contest_id; // assigned

    public string $country_id; // contest.country_id fk:countries.id

    public Country $country;

    public $countries; // country[]

    public string $name_en; //

    public string $name_local; //

    public string $lang_local; // LangList[]

    public $lang_list = [];

    public string $organization_id; // organizations.id

    public string $contest_mark; // path n fle

    public $contest_image; // stored in 'contest' disk

    public string $contact_info; // address, email, cell, and so on

    public string $is_circuit; // Y/N, TODO become boolean

    public string $circuit_id; // required if...

    public string $federation_list; // maybe federations_lis

    public string $url_1_rule;

    public string $url_2_concurrent_list; // maybe url_2_concurrents_list

    public string $url_3_admit_n_award_list;

    public string $url_4_catalogue;

    public $timezone_list = [];

    public string $timezone;

    public string $day_1_opening; // format iso datetime

    public string $day_2_closing;

    public string $day_3_jury_opening;

    public string $day_4_jury_closing;

    public string $day_5_revelations;

    public string $day_6_awards;

    public string $day_7_catalogues;

    public string $day_8_closing;

    public string $award_ceremony_info; // location, date, online broadcast platform

    public string $fee_info;
    // created_at assigned
    // updated_at assigned
    // deleted_at assigned

    /**
     * Before the show
     */
    public function mount(string $oid) // organization_id as in route()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $this->contest_id = Str::uuid();
        $this->organization = Organization::where('id', $oid)->get()[0];
        $this->organization_id = $this->organization->id; // $oid

        $this->countries = Country::country_list_by_country();
        $this->country_id = $this->organization->country_id;

        $this->timezone_list = TimezonesList::timezones_list;
        $this->timezone = 'Europe/Rome';

        $this->name_en = 'Contest name';
        $this->name_local = 'Contest name';

        $this->lang_list = LangList::lang_list;
        $this->lang_local = 'en';
        $this->is_circuit = 'N';

        // TODO use day, day+1, day+7 and so on...
        $this->day_1_opening = date(DATE_ATOM); //
        $this->day_2_closing = date(DATE_ATOM); //
        $this->day_3_jury_opening = date(DATE_ATOM); //
        $this->day_4_jury_closing = date(DATE_ATOM); //
        $this->day_5_revelations = date(DATE_ATOM); //
        $this->day_6_awards = date(DATE_ATOM); //
        $this->day_7_catalogues = date(DATE_ATOM); //
        $this->day_8_closing = date(DATE_ATOM); //

        $this->url_1_rule = 'http://example.local/1';
        $this->url_2_concurrent_list = 'http://example.local/2';
        $this->url_3_admit_n_award_list = 'http://example.local/3';
        $this->url_4_catalogue = 'http://example.local/4';
        $this->award_ceremony_info = '';
        $this->fee_info = '';

        $this->contest = new Contest;
        $this->contest->id = $this->contest_id;
        $this->contest->organization_id = $this->organization_id; // $oid
        $this->contest->country_id = $this->country_id;
        $this->contest->timezone = 'Europe/Rome';
        $this->contest->name_en = 'Contest name';
        $this->contest->name_local = 'Contest name';
        $this->contest->lang_local = 'en';
        $this->contest->is_circuit = $this->is_circuit;
        $this->contest->day_1_opening = $this->day_1_opening;
        $this->contest->day_2_closing = $this->day_2_closing;
        $this->contest->day_3_jury_opening = $this->day_3_jury_opening;
        $this->contest->day_4_jury_closing = $this->day_4_jury_closing;
        $this->contest->day_5_revelations = $this->day_5_revelations;
        $this->contest->day_6_awards = $this->day_6_awards;
        $this->contest->day_7_catalogues = $this->day_7_catalogues;
        $this->contest->day_8_closing = $this->day_8_closing;
        $this->contest->url_1_rule = $this->url_1_rule;
        $this->contest->url_2_concurrent_list = $this->url_2_concurrent_list;
        $this->contest->url_3_admit_n_award_list = $this->url_3_admit_n_award_list;
        $this->contest->url_4_catalogue = $this->url_4_catalogue;
        $this->contest->contact_info = $this->organization->name;
        $this->contest->award_ceremony_info = $this->award_ceremony_info;
        $this->contest->fee_info = $this->fee_info;
        // to store uuid and default values
        $this->contest->save();
    }

    /**
     * Show must go
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

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
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return [
            // id           assigned, not in form
            'country_id' => 'required|string|exists:countries,id',
            'name_en' => 'required|string',
            'name_local' => 'required|string',
            'lang_local' => 'required|string', // in(LangList::lang_list)
            // organization_id by uri,   not in form
            // contest_mark
            'contact_info' => 'required|string',
            'is_circuit' => 'required|string|uppercase|max:1', // in(['N','Y'])
            'circuit_id' => 'nullable|string|exists:contests,id', //
            'federation_list' => 'string|max:255',

            'url_1_rule' => 'required|string|max:255',
            'url_2_concurrent_list' => 'required|string|max:255',
            'url_3_admit_n_award_list' => 'required|string|max:255',
            'url_4_catalogue' => 'required|string|max:255',

            'timezone' => 'required|string',
            'day_1_opening' => 'required|date|after_or_equal:today',
            'day_2_closing' => 'required|date|after_or_equal:day_1_opening',
            'day_3_jury_opening' => 'required|date|after_or_equal:day_2_closing',
            'day_4_jury_closing' => 'required|date|after_or_equal:day_3_jury_opening',
            'day_5_revelations' => 'required|date|after_or_equal:day_4_jury_closing',
            'day_6_awards' => 'required|date|after_or_equal:day_5_revelations',
            'day_7_catalogues' => 'required|date|after_or_equal:day_6_awards',
            'day_8_closing' => 'required|date|after_or_equal:day_7_catalogues',

            'award_ceremony_info' => 'required|string',
            'fee_info' => 'required|string',
            // created_at
            // updated_at
            // deleted_at
        ];

    }

    /**
     * after means after rules()
     */
    public function after(): array
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return [
            function (Validator $validator) {
                // like validate but
                if ($this->is_circuit != 'Y') {
                    $this->is_circuit = 'N';
                }

                if (! in_array($this->timezone, TimezonesList::timezones_list)) {
                    $validator->errors()->add(
                        'timezone',
                        __('Must be one of list')
                    );
                }

                // insert here check for date limits
                $day_1_opening = new DateTimeImmutable($this->day_1_opening);
                $day_2_closing = new DateTimeImmutable($this->day_2_closing);
                $day_8_closing = new DateTimeImmutable($this->day_8_closing);
                $duration = date_diff($day_2_closing, $day_8_closing);
                if ($duration->format('%a%') > '65') {
                    // maybe 7 greater than 65?
                    $validator->errors()->add(
                        'day_8_closing',
                        __('Must not be more than 65 day from day_2 participation closing')
                    );
                }
            },
        ];
    }

    public function saveNewContest()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $validated = $this->validate(); // apply rules

        // TODO pick from form all fields and put in update()
        // TODO because create was in mount()
        $this->contest->id = $this->contest_id;
        $this->contest->country_id = $validated['country_id'];
        $this->contest->name_en = $validated['name_en'];
        $this->contest->name_local = $validated['name_local'];
        $this->contest->lang_local = $validated['lang_local'];
        $this->contest->contact_info = $validated['contact_info'];
        $this->contest->is_circuit = $validated['is_circuit'];
        $this->contest->circuit_id = $validated['circuit_id'];
        $this->contest->federation_list = $validated['federation_list'];
        $this->contest->url_1_rule = $validated['url_1_rule'];
        $this->contest->url_2_concurrent_list = $validated['url_2_concurrent_list'];
        $this->contest->url_3_admit_n_award_list = $validated['url_3_admit_n_award_list'];
        $this->contest->url_4_catalogue = $validated['url_4_catalogue'];
        $this->contest->timezone = $validated['timezone'];
        $this->contest->day_1_opening = $validated['day_1_opening'];
        $this->contest->day_2_closing = $validated['day_2_closing'];
        $this->contest->day_3_jury_opening = $validated['day_3_jury_opening'];
        $this->contest->day_4_jury_closing = $validated['day_4_jury_closing'];
        $this->contest->day_5_revelations = $validated['day_5_revelations'];
        $this->contest->day_6_awards = $validated['day_6_awards'];
        $this->contest->day_7_catalogues = $validated['day_7_catalogues'];
        $this->contest->day_8_closing = $validated['day_8_closing'];
        $this->contest->award_ceremony_info = $validated['award_ceremony_info'];
        $this->contest->fee_info = $validated['fee_info'];
        // ✏️
        $this->contest->save();

        // redirect
        return redirect()
            ->route('organization-dashboard', ['oid' => $this->organization_id])
            ->with('success', __('New Contest added to list, enjoy!'));
    }
}
