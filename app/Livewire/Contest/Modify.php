<?php
/**
 * 2025-09-18 input is contest_id 
 */
namespace App\Livewire\Contest;

use App\Models\Contest;
use App\Models\Country;
use App\Models\LangList;
use App\Models\TimezonesList;
use Livewire\Component;
// use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

class Modify extends Component
{
    use WithFileUploads; // TODO for contest mark logo 

    public Contest $contest; 

    public $id; // uuid readonly 
    public $country_id;
    public $name_en;
    public $name_local;
    public $lang_local;
    public $organization_id; // uuid readonly
    // public $contest_mark; // path n file for image file
    public $contact_info;
    public $is_circuit; // Y/N flag - circuit / contest
    public $circuit_id; // record uuid w/is_circuit Y
    public $federation_list; // a list of fed, fed, federation codes
    public $url_1_rule;
    public $url_2_concurrent_list;
    public $url_3_admit_n_award_list;
    public $url_4_catalogue;
    public $timezone;
    public $day_1_opening;
    public $day_2_closing;
    public $day_3_jury_opening;
    public $day_4_jury_closing;
    public $day_5_revelations;
    public $day_6_awards;
    public $day_7_catalogues;
    public $day_8_closing;
    public $award_ceremony_info;
    public $fee_info;
    // created_at
    // updated_at
    // deleted_at

    public $countries = [];
    public $timezone_list = [];
    public $lang_list = [];
    public array $valid_is_circuit = ['Y', 'N']; // default 'N'

    /**
     * 1. Before the show
     * 
     * TODO learn use of date w/timezone, even for server TZ
     */
    public function mount( string $cid) // named cid as in Route
    {
        Log::info(__FUNCTION__.':'.__LINE__.' cid:'.$cid);
        // form fields
        $this->contest                  = Contest::findOrFail($cid);
        
        $this->id                       = $this->contest->id;
        $this->country_id               = $this->contest->country_id;
        $this->name_en                  = $this->contest->name_en;
        $this->name_local               = $this->contest->name_local;
        $this->lang_local               = $this->contest->lang_local;
        $this->organization_id          = $this->contest->organization_id;
        // $this->contest_mark          = $this->contest->contest_mark;
        $this->contact_info             = $this->contest->contact_info;
        $this->is_circuit               = $this->contest->is_circuit;
        $this->circuit_id               = $this->contest->circuit_id;
        $this->federation_list          = $this->contest->federation_list;
        $this->url_1_rule               = $this->contest->url_1_rule;
        $this->url_2_concurrent_list    = $this->contest->url_2_concurrent_list;
        $this->url_3_admit_n_award_list = $this->contest->url_3_admit_n_award_list;
        $this->url_4_catalogue          = $this->contest->url_4_catalogue;
        
        $this->timezone                 = $this->contest->timezone;
        $this->day_1_opening            = $this->contest->day_1_opening->format('Y-m-d\TH:i:s');
        $this->day_2_closing            = $this->contest->day_2_closing->format('Y-m-d\TH:i:s');
        $this->day_3_jury_opening       = $this->contest->day_3_jury_opening->format('Y-m-d\TH:i:s');
        $this->day_4_jury_closing       = $this->contest->day_4_jury_closing->format('Y-m-d\TH:i:s');
        $this->day_5_revelations        = $this->contest->day_5_revelations->format('Y-m-d\TH:i:s');
        $this->day_6_awards             = $this->contest->day_6_awards->format('Y-m-d\TH:i:s');
        $this->day_7_catalogues         = $this->contest->day_7_catalogues->format('Y-m-d\TH:i:s');
        $this->day_8_closing            = $this->contest->day_8_closing->format('Y-m-d\TH:i:s');

        $this->award_ceremony_info      = $this->contest->award_ceremony_info;
        $this->fee_info                 = $this->contest->fee_info;
        // $this->created_at 
        // $this->updated_at 
        // $this->deleted_at 

        $countries = new Country();

        $this->countries = $countries->allByCountry();

        $this->timezone_list = TimezonesList::timezones_list;

        $this->lang_list = LangList::lang_list;

    }
    /**
     * 2. The show
     */
    public function render()
    {
        return view('livewire.contest.modify');
    }
    /**
     * 3. validate rules 1st round
     * Must be the same of Add.php
     */
    public function rules()
    {
        Log::info(__FUNCTION__.':'.__LINE__);
        return [
            // id           readonly
            'country_id'               => 'required|string|exists:countries,id',
            'name_en'                  => 'required|string',
            'name_local'               => 'required|string',
            'lang_local'               => 'required|string', // in(LangList::lang_list)
            // organization_id readonly
            // contest_mark TODO 
            'contact_info'             => 'required|string',
            'is_circuit'               => 'required|string|uppercase|max:1', // in(['N','Y'])
            'circuit_id'               => 'nullable|string|exists:contests,id', //
            'federation_list'          => 'string|max:255',
            'url_1_rule'               => 'required|active_url|string|max:255',
            'url_2_concurrent_list'    => 'required|active_url|string|max:255',
            'url_3_admit_n_award_list' => 'required|active_url|string|max:255',
            'url_4_catalogue'          => 'required|active_url|string|max:255',
            'timezone'                 => 'required|string',
            'day_1_opening'            => 'required|date|after_or_equal:today',
            'day_2_closing'            => 'required|date|after_or_equal:day_1_opening',
            'day_3_jury_opening'       => 'required|date|after_or_equal:day_2_closing',
            'day_4_jury_closing'       => 'required|date|after_or_equal:day_3_jury_opening',
            'day_5_revelations'        => 'required|date|after_or_equal:day_4_jury_closing',
            'day_6_awards'             => 'required|date|after_or_equal:day_5_revelations',
            'day_7_catalogues'         => 'required|date|after_or_equal:day_6_awards',
            'day_8_closing'            => 'required|date|after_or_equal:day_7_catalogues',
            'award_ceremony_info'      => 'required|string',
            'fee_info'                 => 'required|string',
            // created_at
            // updated_at
            // deleted_at
        ];
    }
    /**
     * 4. validate 2nd round
     * 
     * It's not clear if i need an array of fn()
     * to validate each one piece, or i can as that
     * serialize an entire checklist.
     */
    public function after() : array
    {
        Log::info(__FUNCTION__.':'.__LINE__);
        return [
            function (Validator $validator) {
                // like validate but
                // contest in circuit Y
                // otherwise (circuit | single contest ) N 
                if( $this->is_circuit != 'Y'){
                    $this->is_circuit = 'N';
                }

                if ($this->circuit_id){
                    try {
                        $check_circuit = Contest::where('id', $this->circuit_id)
                            ->where('is_circuit', 'Y')
                            ->whereNull('deleted_at')
                            ->pluck('id');
                        if ($check_circuit < 'a'){
                            $validator->errors()->add(
                                'circuit_id',
                                __("Must be already a registered circuit id, flagged as Circuit.")
                            );
                        }

                    } catch (\Throwable $th) {
                        $validator->errors()->add(
                            'circuit_id',
                            __("Must be already a registered circuit id, flagged as Circuit;")
                        );
                    }
                }

                if (!in_array( $this->timezone, TimezonesList::timezones_list )) {
                    $validator->errors()->add(
                        'timezone',
                        __('Must be one of list')
                    );
                }

                // insert here check for date limits
                $day_1_opening = new DateTimeImmutable( $this->day_1_opening);
                $day_2_closing = new DateTimeImmutable( $this->day_2_closing);
                $day_8_closing = new DateTimeImmutable( $this->day_8_closing);
                $duration      = date_diff($day_2_closing, $day_8_closing);
                if ($duration->format("%a%") > "65"){
                    // maybe 7 greater than 65?
                    $validator->errors()->add(
                        'day_8_closing',
                        __('Must not be more than 65 day from day_2 participation closing')
                    );
                }
            }
        ];
    }
    /**
     * 5 n last
     * previously update(), now a more clear name
     */
    public function update_contest_main()
    {

        Log::info(__FUNCTION__.':'.__LINE__.' day_1'.$this->day_1_opening);
    
        // apply rules() and after()
        $validated = $this->validate();
        //Log::info(__FUNCTION__.':'.__LINE__.' out:' . json_encode($validated));
        Log::info(__FUNCTION__.':'.__LINE__.' day_1'.$validated['day_1_opening']);
        
        // update 
        // $this->contest->id;
        $this->contest->country_id               = $validated['country_id'];
        $this->contest->name_en                  = $validated['name_en'];
        $this->contest->name_local               = $validated['name_local'];
        $this->contest->lang_local               = $validated['lang_local'];
        $this->contest->contact_info             = $validated['contact_info'];
        // $this->contest->organization_id;
        // $this->contest->contest_mark;
        $this->contest->is_circuit               = $validated['is_circuit'];
        $this->contest->circuit_id               = $validated['circuit_id'];
        $this->contest->federation_list          = $validated['federation_list'];
        $this->contest->url_1_rule               = $validated['url_1_rule'];
        $this->contest->url_2_concurrent_list    = $validated['url_2_concurrent_list'];
        $this->contest->url_3_admit_n_award_list = $validated['url_3_admit_n_award_list'];
        $this->contest->url_4_catalogue          = $validated['url_4_catalogue'];
        $this->contest->timezone                 = $validated['timezone'];
        $this->contest->day_1_opening            = $validated['day_1_opening'];
        $this->contest->day_2_closing            = $validated['day_2_closing'];
        $this->contest->day_3_jury_opening       = $validated['day_3_jury_opening'];
        $this->contest->day_4_jury_closing       = $validated['day_4_jury_closing'];
        $this->contest->day_5_revelations        = $validated['day_5_revelations'];
        $this->contest->day_6_awards             = $validated['day_6_awards'];
        $this->contest->day_7_catalogues         = $validated['day_7_catalogues'];
        $this->contest->day_8_closing            = $validated['day_8_closing'];
        $this->contest->award_ceremony_info      = $validated['award_ceremony_info'];
        $this->contest->fee_info                 = $validated['fee_info'];
        // $this->contest->created_at;
        // $this->contest->updated_at;
        // $this->contest->deleted_at;
        
        $this->contest->save();

        // $this->contest = Contest::save($validated);

        // redirect 
        return redirect()
          ->route('contest-section-add', ['cid' => $this->contest->id])
          ->with('success', __('Contest Main data updated, enjoy!') );
        //
    }
}
