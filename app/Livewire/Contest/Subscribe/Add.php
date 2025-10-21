<?php
/**
 * Contest Work Participate / Add
 * 
 * 2025-10-14 ContestSectionRule don't work
 * 2025-10-18 image filename must be coherent with contest_works.id 
 * 
 */
namespace App\Livewire\Contest\Subscribe;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestWork;
use App\Models\ContestSection;
use App\Models\User;
use App\Models\UserContact;
use App\Models\Work;
use App\Rules\ContestSectionRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Add extends Component
{
    public $work;
    public $contest_section_list; 
    public $section;
    public $contest_id;
    public $section_id;
    public $user_id;
    public $work_id;

    public $work_in_contest;

    /**
     * 1. Before the show
     */
    public function mount(string $data_json) //
    {
        Log::info('Component Contest/Subscribe/' . __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' in:'. $data_json);
        $data = json_decode($data_json);

        $this->work_id = $data->work_id;
        $this->contest_id = $data->contest_id;
        // section_id - form field
        $this->user_id = Auth::id(); // even $work->user_id

        $this->contest_section_list = $data->contest_section_list;
        Log::info('Component Contest/Subscribe/' . __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' out:'.json_encode($this));
    }
    /**
     * 2. Show
     */
    public function render()
    {
        Log::info('Component Contest/Subscribe/' . __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' in:'.json_encode($this));
        return view('livewire.contest.subscribe.add');
    }
    /**
     * 3. Validation rules
    */
    public function rules()
    {
        Log::info('Component Contest/Subscribe/' . __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' in:'.json_encode($this));
        return [
            // first section_id, then work_id according w/ContesSectionRule
            'section_id' => [
                'string',
                'exists:contest_sections,id',
                new ContestSectionRule(),
            ],
            'work_id' => [
                'string',
                'exists:works,id',
                new ContestSectionRule(),
            ],
            'user_id' => 'string|exists:users,id',
            'contest_id' => 'string|exists:contests,id',
        ];
    }
    /**
     * 4. Add
    */
    public function add_work_to_contest()
    {
        Log::info('Component Contest/Subscribe/' . __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' in:'.json_encode($this));
        $validated = $this->validate();
        Log::info('Component Contest/Subscribe/' . __CLASS__ .' '.__FUNCTION__.':'.__LINE__. ' validated' . json_encode($validated));

        // integration from mount()
        $validated['contest_id'] = $this->contest_id;
        $validated['user_id']    = $this->user_id;
        $validated['country_id'] = UserContact::get_country_id($this->user_id);        
        Log::info('Component Contest/Subscribe/' . __CLASS__ .' '.__FUNCTION__.':'.__LINE__. ' validated' . json_encode($validated));

        $this->work_in_contest = ContestWork::create($validated);
        Log::info('Component Contest/Subscribe/' . __CLASS__ .' '.__FUNCTION__.':'.__LINE__. ' out:' . json_encode($this->work_in_contest));
        
        // check user_participant then add if missing
        $user_participant = ContestParticipant::where('contest_id', $validated['contest_id'])->where('user_id', $validated['user_id'])->count();
        if ($user_participant == 0){
            //
            Log::info('Component Contest/Subscribe/' . __CLASS__ .' '.__FUNCTION__.':'.__LINE__. ' add user');
            ContestParticipant::create($validated);
        }

        return redirect()
            ->route('participate-contest', [ 'cid' => $this->contest_id ] )
            ->with('success', __('Work added, Great!') );

    }
}
