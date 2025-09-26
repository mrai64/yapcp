<?php
/**
 * Contest (Section) Award Add (and list)
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
        // other
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
        Log::info(__FUNCTION__ . ' ' . __LINE__ . '');
    }
    /**
     * 2. Show to go
    */
    public function render()
    {
        Log::info(__FUNCTION__ . ' ' . __LINE__ . '');
        return view('livewire.contest.award.add');
    }
    /**
     * 3. Validate rules
     * instead of a Validate comment 
     * we use a validation array of array to manage "complex"
     * validation for is_award field
    */
    public function rules()
    {
        Log::info(__FUNCTION__ . ' ' . __LINE__ . '');
        return [
            // 'contest_id' => [ 'required', 'string', 'exists:contests,id', ],
            // 'section_id' => [ 'string', 'exists:contest_sections,id', ],
            'section_code' => [ 'string', 'uppercase', 'max:10', 'exists:contest_sections,code'],
            'award_code' => [ 'required', 'string', 'uppercase', 'max:10', ],
            'award_name' => [ 'required', 'string', 'max:255', ],
            // 'is_award' => [ 'required', 'in:Y,N'],
            'is_award' => [ 'required', 'string', 'uppercase', 'max:1', new setYNRule],
            // 'winner_work_id' => [ 'string', 'exists:works,id', ],
            // 'winner_user_id' => [ 'string', 'exists:works,user_id', ],
            // 'winner_user_name' => [ 'string', 'max:255', ],
        ];
    }
    /**
     * 4. At last validate n insert
    */
    public function addContestAward()
    {
        Log::info(__FUNCTION__ . ' ' . __LINE__ . '');
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
