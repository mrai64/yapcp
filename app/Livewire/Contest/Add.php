<?php
/**
 * Contest record
 * 
 * upload contest mark logo
 * rules()
 * 
 * WARNING: That module FIRST SAVE, then modify Contest record
 * and not as usual LAST SAVE record
 * 
 */

namespace App\Livewire\Contest;

use App\Models\Contest;
use App\Models\Country;
use App\Models\LangList;
use App\Models\Organization;
use App\Models\TimezonesList;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
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
    public         $countries; // country[]
    public string $name_en; //
    public string $name_local; //
    public string $lang_local; // LangList[]
    public        $lang_list = [];
    public string $organization_id; // organizations.id 
    public string $contest_mark; // path n fle 
    public        $contest_image; // stored in 'contest' disk
    public string $contact_info; // address, email, cell, and so on
    public string $is_circuit; // Y/N, not bool N when not Y
    public string $circuit_id;
    public string $federation_list; // maybe federations_lis
    public string $url_1_rule;
    public string $url_2_concurrent_list; // maybe url_2_concurrents_list
    public string $url_3_admit_n_award_list;
    public string $url_4_catalogue;
    public        $timezone_list = [];
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
    // created_at assigned
    // updated_at assigned
    // deleted_at assigned

    /**
     * Before the show
     * 
     * 
     */
    public function mount(string $oid) // organization_id as in route()
    {
        $this->contest_id      = Str::uuid();
        $this->organization    = Organization::where('id', $oid)->get()[0];
        $this->organization_id = $this->organization->id; // $oid

        $this->country    = New Country;
        $this->countries  = $this->country->allByCountry();
        $this->country_id = $this->organization->country_id;
        
        $this->timezone_list = TimezonesList::timezones_list;
        $this->timezone   = 'Europe/Rome';
        
        $this->name_en    = 'Contest name';
        $this->name_local = 'Contest name';
        
        $this->lang_list  = LangList::lang_list;
        $this->lang_local = 'en';
        $this->is_circuit = 'N';

        // TODO use day, day+1, day+7 and so on...
        $this->day_1_opening      = date(DATE_ATOM); // 
        $this->day_2_closing      = date(DATE_ATOM); // 
        $this->day_3_jury_opening = date(DATE_ATOM); // 
        $this->day_4_jury_closing = date(DATE_ATOM); // 
        $this->day_5_revelations  = date(DATE_ATOM); // 
        $this->day_6_awards       = date(DATE_ATOM); // 
        $this->day_7_catalogues   = date(DATE_ATOM); // 
        $this->day_8_closing      = date(DATE_ATOM); // 

        $this->url_1_rule               = 'http://example.local/1';
        $this->url_2_concurrent_list    = 'http://example.local/2';
        $this->url_3_admit_n_award_list = 'http://example.local/3';
        $this->url_4_catalogue          = 'http://example.local/4';
        $this->award_ceremony_info      = '';

        $this->contest                  = New Contest();
        $this->contest->id              = $this->contest_id;
        $this->contest->organization_id = $this->organization_id; // $oid
        $this->contest->country_id      = $this->country_id;
        $this->contest->timezone        = 'Europe/Rome';
        $this->contest->name_en         = 'Contest name';
        $this->contest->name_local      = 'Contest name';
        $this->contest->lang_local      = 'en';
        $this->contest->is_circuit      = $this->is_circuit;
        $this->contest->day_1_opening      = $this->day_1_opening     ;
        $this->contest->day_2_closing      = $this->day_2_closing     ;
        $this->contest->day_3_jury_opening = $this->day_3_jury_opening;
        $this->contest->day_4_jury_closing = $this->day_4_jury_closing;
        $this->contest->day_5_revelations  = $this->day_5_revelations ;
        $this->contest->day_6_awards       = $this->day_6_awards      ;
        $this->contest->day_7_catalogues   = $this->day_7_catalogues  ;
        $this->contest->day_8_closing      = $this->day_8_closing     ;
        $this->contest->url_1_rule               = $this->url_1_rule              ;
        $this->contest->url_2_concurrent_list    = $this->url_2_concurrent_list   ;
        $this->contest->url_3_admit_n_award_list = $this->url_3_admit_n_award_list;
        $this->contest->url_4_catalogue          = $this->url_4_catalogue         ;
        $this->contest->contact_info             = $this->organization->name;         ;
        $this->contest->award_ceremony_info      = $this->organization->name;         ;
        // to store uuid and default values
        $this->contest->save();
    }

    /**
     * Show must go
     */
    public function render()
    {
        return view('livewire.contest.add');
    }

    /**
     * Validation 
     */
    public function rules()
    {
        // TODO 
    }

    /**
     * 
     */
    public function save()
    {
        $this->validate(); // apply rules
        // TODO 
    }
}
