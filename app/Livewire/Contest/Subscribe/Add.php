<?php

/**
 * Contest Work Participate / Add
 *
 * 2025-10-14 ContestSectionRule don't work
 * 2025-10-18 image filename must be coherent with contest_works.id
 */

namespace App\Livewire\Contest\Subscribe;

use App\Models\ContestParticipant;
use App\Models\ContestWork;
use App\Models\UserContact;
use App\Rules\ContestSectionRule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Add extends Component
{
    public $work;

    public $contestSectionSet;

    public $section;

    public $contestId;

    public $sectionId;

    public $userId;

    public $userWorkId;

    public $portfolioSequence;

    public $userWorkInContest;

    /**
     * 1. Before the show
     */
    public function mount(string $dataJson) // livewire contest.subscribe.add
    {
        ds('Component Contest/Subscribe/' . __CLASS__ . ' ' . __FUNCTION__ . ':'
            . __LINE__ . ' in:' . $dataJson);
        $data = json_decode($dataJson);

        $this->userWorkId = $data->workId;
        $this->contestId = $data->contestId;
        // section_id - form field
        $this->userId = Auth::id(); // even $work->user_id
        $this->contestSectionSet = $data->contestSectionSet;
        ds('Component Contest/Subscribe/' . __CLASS__ . ' ' . __FUNCTION__ . ':'
            . __LINE__ . ' out:' . json_encode($this));
    }

    /**
     * 2. Show
     */
    public function render()
    {
        ds('Component Contest/Subscribe/' . __CLASS__ . ' ' . __FUNCTION__ . ':'
            . __LINE__ . ' in:' . json_encode($this));

        return view('livewire.contest.subscribe.add');
    }

    /**
     * 3. Validation rules
     */
    public function rules()
    {
        ds('Component Contest/Subscribe/' . __CLASS__ . ' ' . __FUNCTION__ . ':'
            . __LINE__ . ' in:' . json_encode($this));

        return [
            // first section_id, then userWorkId according w/ContesSectionRule
            'sectionId' => [
                'string',
                'exists:contest_sections,id',
                new ContestSectionRule(),
            ],
            'userWorkId' => [
                'string',
                'exists:works,id',
                new ContestSectionRule(),
            ],
            'userId' => 'string|exists:users,id',
            'contestId' => 'string|exists:contests,id',
            'portfolioSequence' => 'integer|min:0|max:255',
        ];
    }

    /**
     * 4. Add
     */
    public function addUserWorkToContest()
    {
        ds('Component Contest/Subscribe/' . __CLASS__ . ' ' . __FUNCTION__ . ':'
            . __LINE__ . ' in:' . json_encode($this));
        $validated = $this->validate();
        ds('Component Contest/Subscribe/' . __CLASS__ . ' ' . __FUNCTION__ . ':'
            . __LINE__ . ' validated' . json_encode($validated));

        // integration from mount()
        $validated['contest_id'] = $this->contestId;
        $validated['user_id'] = $this->userId;
        $validated['country_id'] = UserContact::getCountryId($this->userId);
        $userContact = UserContact::where('id', $this->userid)->first();

        if ($validated['portfolioSequence'] == 0) {
            $validated['portfolioSequence'] = ContestWork::where('section_id', $validated['section_id'])->where('user_id', $this->userId)->count();
            $validated['portfolioSequence'] += 1;
        }
        ds('Component Contest/Subscribe/' . __CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' validated' . json_encode($validated));

        $this->userWorkInContest = ContestWork::create([
            // id assigned
            'contest_id' => $this->contestId,
            'section_id' => $validated['sectionId'],
            'country_id' => $userContact->country_id,
            'user_id' => $userContact->id,
            'work_id' => $validated['userWorkId'],
            'is_admit' => false,
            'portfolio_sequence' => $validated['portfolioSequence'],
        ]);
        ds('Component Contest/Subscribe/' . __CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' out:' . json_encode($this->userWorkInContest));

        // check user_participant then add if missing
        if (
            ContestParticipant::where('contest_id', $this->contestId)
                ->where('user_id', $userContact->id)->doesntExist()
        ) {
            ds('Component Contest/Subscribe/' . __CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' add user');
            ContestParticipant::create([
                // id assigned,
                'contest_id' => $this->contestId,
                'user_id' => $userContact->id,
                // fee_payment_completed assigned
            ]);
        }

        return redirect()
            ->route('participate-contest', ['cid' => $this->contestId])
            ->with('success', __('Work added, Great!'));
    }
}
