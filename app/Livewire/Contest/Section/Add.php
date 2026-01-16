<?php

/**
 * Contest Section Add
 * child table of Contest
 */

namespace App\Livewire\Contest\Section;

use App\Models\Contest;
use App\Models\ContestSection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Add extends Component
{
    public $contest;

    public $contest_section_list;

    public $code_list = [];

    public array $valid_under_patronage = ['N', 'Y']; // default 'N'

    // id pk uuid
    public $contest_id; // fk contest.id uuid

    public $code;

    public string $under_patronage;

    public $name_en;

    public $name_local;
    // created_at
    // updated_at
    // deleted_at

    /**
     * 1. before the show
     */
    public function mount(string $cid) // as 'cid' in route - contests.id
    {
        Log::info(__FUNCTION__);
        $this->contest_id = $cid;
        $this->under_patronage = $this->valid_under_patronage[0]; // 'N'
        $this->name_en = '';
        $this->name_local = '';

        $this->contest = Contest::whereNull('deleted_at')
            ->where('id', $cid)->get()[0];

        $this->contest_section_list = ContestSection::whereNull('deleted_at')
            ->where('contest_id', $cid)->orderBy('code')->get();

        foreach ($this->contest_section_list as $section) {
            $this->code_list[] = $section->code;
        }
    }

    /**
     * 2. show must go
     */
    public function render()
    {
        Log::info(__FUNCTION__);

        return view('livewire.contest.section.add');
    }

    /**
     * 3. validation rules
     */
    public function rules(): array
    {
        Log::info(__FUNCTION__);

        return [
            // id
            // contest_id
            'code' => 'required|string|uppercase|max:10',
            'under_patronage' => 'required|string|uppercase|max:1', // in valid_under_patronage[]
            'name_en' => 'required|string|max:255',
            'name_local' => 'string|max:255',
        ];
    }

    /**
     * 4. validation after means after rules()
     */
    public function after(): array
    {
        Log::info(__FUNCTION__);

        return [
            function (Validator $validator) {
                if (! in_array($this->under_patronage, $this->valid_under_patronage)) {
                    Log::info('under_patronage: ['.$this->under_patronage.'] formatted');
                    $this->under_patronage = $this->valid_under_patronage[0];
                }

                if (in_array($this->code, $this->code_list)) {
                    $validator->errors()->add(
                        'code',
                        __('Already present')
                    );
                }
            },
        ];
    }

    /**
     * 5. add section
     */
    public function addSectionToContest()
    {
        Log::info(__FUNCTION__);
        $validated = $this->validate();
        Log::info(__FUNCTION__.' validated: '.serialize($validated));

        $validated['contest_id'] = $this->contest_id;
        $section = new ContestSection();
        $section->create($validated);

        return redirect()
            ->route('contest-section-add', ['cid' => $this->contest_id])
            ->with('success', __('New section added to section list, another?'));

    }
}
