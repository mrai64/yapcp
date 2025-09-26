<?php
/**
 * Contest (Section) Award Add (and list)
 */
namespace App\Livewire\Contest\Award;

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use App\Models\Country;
use Livewire\Component;

class Add extends Component
{
    // fields in form and other vars
    public string $contest_id;
    public        $contest;
    public        $contest_section_list;
    public        $contest_award_list;
    public Country $countries;

    /**
     * 1. before the show
     */
    public function mount(string $cid) // named as in route()
    {
        $this->contest_id = $cid;
        $this->contest = Contest::where('id', $this->contest_id)->get()[0];
        $this->contest_section_list = ContestSection::where('contest_id', $this->contest_id)->orderBy('code')->get();
        $this->contest_award_list = ContestAward::where('contest_id', $this->contest_id)->orderBy('section_code')->orderBy('award_code')->get();
    }
    /**
     * 2. Show to go
     */
    public function render()
    {
        return view('livewire.contest.award.add');
    }
    /**
     * 3. Validate rules
     */
    public function rules()
    {

    }
    /**
     * 4. At last validate n insert
     */
    public function add_contest_award()
    {
        $validated = $this->validate();
        //

        // redirect
        return redirect()
          ->route('contest-award-add', ['cid' => $this->contest_id ])
          ->with('success', __('New Award added to list, enjoy!') );
    }
}
