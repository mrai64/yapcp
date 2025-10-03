<?php

namespace App\Livewire\Contest\Subscribe;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestSection;
use App\Models\User;
use App\Models\UserContact;
use App\Models\Work;
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

    public $contest_participant;

    /**
     * 1. Before the show
     */
    public function mount(string $data_json) //
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in:'. $data_json);
        $data = json_decode($data_json);

        $this->work_id = $data->work_id;
        $this->contest_id = $data->contest_id;
        // section_id - form field
        $this->user_id = Auth::id(); // even $work->user_id

        $this->contest_section_list = $data->contest_section_list;
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.json_encode($this));
    }
    /**
     * 2. Show
     */
    public function render()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in:'.json_encode($this));
        return view('livewire.contest.subscribe.add');
    }
    /**
     * 3. Validation rules
    */
    public function rules()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in:'.json_encode($this));
        return [
            'work_id' => 'string|exists:works,id',
            'section_id' => 'string|exists:contest_sections,id',
            'user_id' => 'string|exists:users,id',
            'contest_id' => 'string|exists:contests,id',
        ];
    }
    /**
     * 4. Add
    */
    public function add_participant()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in:'.json_encode($this));
        $validated = $this->validate();
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' validated' . json_encode($validated));

        // integration from mount()
        $validated['contest_id'] = $this->contest_id;
        $validated['user_id']    = $this->user_id;
        $validated['country_id'] = UserContact::get_country_id($this->user_id);        
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' validated' . json_encode($validated));

        $this->contest_participant = ContestParticipant::create($validated);
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' out:' . json_encode($this->contest_participant));

        return redirect()
            ->route('participate-contest', [ 'cid' => $this->contest_id ] )
            ->with('success', __('Work added, Great!') );

    }
}
