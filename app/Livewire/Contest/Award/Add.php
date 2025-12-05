<?php
/**
 * Contest Definition for Section and Contest Award Add (and list)
 * 
 * 2025-12-05 review
 * 
 */
namespace App\Livewire\Contest\Award;

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use App\Models\Country;
use App\Rules\setYNRule;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Add extends Component
{
    // fields in form and other vars
    public string $contest_id;
    public        $contest;
    public        $contest_section_list;
    public        $contest_award_list;
    public Country $countries;
    //
    public string $section_id;
    public string $section_code;
    public string $award_code;
    public string $award_name;
    // public string $award_name_en;
    // public string $award_name_local;
    public string $is_award; // Y / N
    public string $winner_work_id; // uuid
    public string $winner_user_id; // uuid
    public string $winner_name; //    group / organization uuid

    /**
     * 1. before the show
     */
    public function mount(string $cid) // named as in route()
    {
        Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ . ' called');

        $this->contest_id = $cid;
        $this->contest = Contest::where('id', $this->contest_id)->get()[0];
        Log::info(__FUNCTION__ . ' ' . __LINE__ . $this->contest);
   
        $this->contest_section_list = ContestSection::where('contest_id', $this->contest_id)->orderBy('code')->get();
        Log::info(__FUNCTION__ . ' ' . __LINE__ . $this->contest_section_list);

        $this->contest_award_list = ContestAward::where('contest_id', $this->contest_id)->orderBy('section_code')->orderBy('award_code')->get();
        Log::info(__FUNCTION__ . ' ' . __LINE__ . $this->contest_award_list);

        // new rec
        $this->section_code = '';
        $this->award_code = '';
        $this->award_name = '';
        $this->is_award = 'N';
        $this->winner_work_id = '';
        $this->winner_user_id = '';
        $this->winner_name = '';
        Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ . ' out');
    }
    /**
     * 2. Show to go
     */
    public function render()
    {
        Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ . ' called');
        return view('livewire.contest.award.add');
    }
    /**
     * 3. Validate rules
     * 
     * TODO is_award from Y/N must become 1/0 true/false
     * 
     */
    public function rules()
    {
        Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ . ' called');
        return [
            // contest_id not in form
            // section_id if present must be one of section_id in contest_id with sectionIdRule() 
            'section_code' => [ 'string', 'uppercase', 'max:10', 'exists:contest_sections,code'],
            'award_code' => [ 'required', 'string', 'uppercase', 'max:10', ],
            'award_name' => [ 'required', 'string', 'max:255', ],
            'is_award' => [ 'required', 'string', 'uppercase', 'max:1', new setYNRule],
            // winner_work_id   not in form
            // winner_user_id   not in form
            // winner_user_name not in form
        ];
    }
    /**
     * 4. At last validate n insert
     */
    public function add_contest_award()
    {
        Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ . ' called');
        $validated = $this->validate();
        // invariant fk integration
        $validated['contest_id'] = $this->contest_id;
        Log::info(__FUNCTION__ . ' ' . __LINE__ . serialize($validated));

        $award = ContestAward::create($validated);
        Log::info(__FUNCTION__ . ' ' . __LINE__ . $award);

        // redirect
        return redirect()
          ->route('contest-award-add', ['cid' => $this->contest_id ])
          ->with('success', __('New Award added to list, enjoy!') );
    }
}
