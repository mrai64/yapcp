<?php

/**
 * User Contest participation - Add UserWork to ContestSection
 *
 * note: input is a dataJson for 3 record input
 * - contestId         string contests.id
 * - workId            string user_works.id
 * - contestSectionSet array of contest section codes
 *
 * Not a full page but a form
 *
 */

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestWork;
use App\Models\UserContact;
use App\Models\UserWork;
use App\Rules\ContestSectionRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Volt\Component;

new class extends Component {
    //
    public string $userWorkId;
    public string $contestId;
    public string $userId;
    public $contestSectionSet;
    public string $sectionId;
    public int $portfolioSequence = 0;
    //
    // first mount()
    public function mount(string $dataJson) // from livewire
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:'
            . __LINE__ . ' in:' . $dataJson);
        $data             = json_decode($dataJson);
        $this->userWorkId = $data->workId;
        $this->contestId  = $data->contestId;
        $this->portfolioSequence = 0;
        // sectionId - form field
        $this->userId     = Auth::id(); // even $work->user_id
        $this->contestSectionSet = $data->contestSectionSet;
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:'
            . __LINE__ . ' out:' . json_encode($this));
    }
    // for validate()
    // sequence secctionId, userWorkid under ContestSectionRule
    public function rules()
    {
        return [
            // first sectionId, then userWorkId according w/ContesSectionRule
            'sectionId' => [
                'string',
                'exists:contest_sections,id',
                new ContestSectionRule(),
            ],
            'userWorkId' => [
                'string',
                'exists:user_works,id',
                new ContestSectionRule(),
            ],
            'userId' => 'string|exists:user_contacts,id',
            'contestId' => 'string|exists:contests,id',
            'portfolioSequence' => 'integer|min:0|max:255',
        ];
    }
    //
    // Add new ContestWork
    public function addContestWork()
    {
        //
        $validated = $this->validate();

        // integration
        $validated['contestId']    = $this->contestId;
        $validated['userContact']  = UserContact::where('id', $this->userId)->first();
        $validated['userWork']     = UserWork::where('id', $this->userWorkId)->first();
        $validated['extension']    = $validated['userWork']->file_format;
        // incremental if unassigned
        if ($validated['portfolioSequence'] == 0){
            // max+1
            $max = ContestWork::where('section_id', $validated['sectionId'])
                ->where('user_id', $this->userId)
                ->count();
            $validated['portfolioSequence'] = $max + 1; // real world no contest with more than 255 per portfolio
        }
        // all or nothing
        DB::transaction(function () use ($validated) {
            ContestParticipant::firstOrCreate([
                'contest_id'      => $validated['contestId'],
                'user_contact_id' => $validated['userWork']->user_id, 
            ]);
            ContestWork::create([
                'contest_id'         => $validated['contestId'],
                'section_id'         => $validated['sectionId'],
                'country_id'         => $validated['userContact']->country_id,
                'user_id'            => $validated['userContact']->id,
                'user_work_id'       => $validated['userWorkId'],
                'extension'          => $validated['extension'],
                'portfolio_sequence' => $validated['portfolioSequence'],
                'is_admit'           => false, // explicit default
            ]);
        });
        // redirect - reload
        $contest = Contest::find($this->contestId);
        return redirect()
            ->route('user.contest.participate', ['contest' => $contest])
            ->with('success', __('Work added, Great!'));
    }
}; ?>

<div>
    <!-- errors list -->
    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li class="text-red-600">❌ {{ $error }} 👈</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form wire:submit.prevent="addContestWork">
        @csrf

        <input name="userWorkId" wire:model="userWorkId" type="hidden"
            value="{{$userWorkId}}" readonly />
        <div>
            <select 
                name="sectionId" 
                wire:model.defer="sectionId"
                required="required"
                class="inline-flex items-center border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block px-4 py-2 mt-4 w-48"
                >
                <option value="">--</option>
                @foreach($contestSectionSet as $section)
                <option value="{{$section->id}}">{{$section->code}}</option>
                @endforeach
            </select>
            <!-- portfolio sequence -->
            <input type="number" 
                name="portfolioSequence" 
                wire:model.defer="portfolioSequence" 
                min="0" max="250"
                class="inline-flex items-center border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2 mt-4 w-24"
                />
        </div>

        <x-button class="mt-2 ms-4">
            {{ __('Add to Contest') }}
        </x-button>
    </form>

</div>
