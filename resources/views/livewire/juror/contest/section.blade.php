<?php

/**
 * Contest Manage - Juror Single vote - first vote
 *
 * For contest section pick a single work then propose it
 * with
 *
 */

use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\ContestWork;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    //
    public ContestSection $contestSection;
    public $jurorUserId;
    public $contestWork;
    public $voteMethod;
    public $vote;
    //
    public function mount(ContestSection $contestSection)
    {
        // can - cannot
        $this->authorize('vote-in-section', $contestSection );
        //
        $this->contestSection = $contestSection;
        $this->jurorUserId    = Auth::id();
        $contestWork = ContestWork::where('section_id', $this->contestSection->id)
            ->whereNotIn('id', function($query){
                $query->select('contest_work_id')
                    ->from(ContestVote::TABLENAME)
                    ->where('juror_user_id', $this->jurorUserId)
                    ->where('section_id', $this->contestSection->id);
            })
            ->inRandomOrder()
            ->first();
        // exit strategy - no more work to vote
        if (!$contestWork){
            redirect()
                ->route('juror.contest.dashboard', ['contest' => $this->contestSection->contest])
                ->with('success', __('Hurrah! Completed. Next?'));
        }
        $this->contestWork = $contestWork;
        $this->voteMethod = $this->contestSection->contest->vote_rule;
        // actually contest_vote_rule_sets have only 3 items
    }
    //
    public function rules()
    {
        switch ($this->voteMethod) {
            case 'num:1..10':
                $validVotes = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
                break;
            case 'num:1..30':
                $validVotes = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'];
                break;
            case 'star:1..5':
                $validVotes = ['⭐️', '⭐️⭐️', '⭐️⭐️⭐️', '⭐️⭐️⭐️⭐️', '⭐️⭐️⭐️⭐️⭐️'];
                break;
        }
        return [
            'vote' => ['required', Rule::in($validVotes)],
        ];
    }
    // every button 
    public function addContestVote(string $vote)
    {
        $this->vote = $vote; // simulated form field
        // no vote - exit
        if ($this->vote == 'exit'){
            return redirect()
                ->route('juror.contest.dashboard', ['contest' => $this->contestWork->contest])
                ->with('success', __('Stopped. Next?'));
        }
        $validated = $this->validate();
        ContestVote::create([
            // id
            'contest_id' => $this->contestSection->contest_id,
            'section_id' => $this->contestSection->id,
            'contest_work_id' => $this->contestWork->id,
            'juror_user_id' => Auth::id(),
            'vote' => $validated['vote'],
        ]);
        // 
        return redirect()
            ->route('juror.contest.section', ['contestSection' => $this->contestSection]);
    }
}; ?>

<div>
    <!-- image here -->
    <div class="flex justify-center items-center my-4 min-h-0" style="height: 75vh;">
        @if (($contestWork->userWork->short_size < $contestWork->userWork->long_size) && $contestWork->userWork->is_landscape)
        <!-- quadrata o landscape -->
        <img src="{{ asset('storage/contests') .'/'. $contestWork->contest_id .'/'. $contestWork->section_id .'/'. $contestWork->id .'.'. $contestWork->userWork->file_format }}"
            class="max-h-full max-w-full object-contain rounded-lg shadow-md"
            @contextmenu.prevent
            alt="All rights reserved"
        />
        @else
        <!-- non quadrata e non landscape -->
        <img src="{{ asset('storage/contests') .'/'. $contestWork->contest_id .'/'. $contestWork->section_id .'/'. $contestWork->id .'.'. $contestWork->userWork->file_format }}"
            class="h-full max-h-full max-w-full object-contain rounded-lg shadow-md"
            @contextmenu.prevent
            alt="All rights reserved"
        />
        @endif
    </div>
    <hr class="my-2"/>
    <!-- vote method here -->
    @if ($voteMethod === 'num:1..10')
    <div class="w-full text-center">
        <x-button class="m-2 p-4" wire:click="addContestVote('exit')">{{'exit'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('1')">{{'1'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('2')">{{'2'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('3')">{{'3'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('4')">{{'4'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('5')">{{'5'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('6')">{{'6'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('7')">{{'7'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('8')">{{'8'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('9')">{{'9'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('10')">{{'10'}}</x-button>
    </div>
    @endif

    @if ($voteMethod === 'num:1..30')
    <div class="w-full text-center">
        <x-button class="m-2 p-4" wire:click="addContestVote('exit')">{{'exit'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('1')">{{'1'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('2')">{{'2'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('3')">{{'3'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('4')">{{'4'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('5')">{{'5'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('6')">{{'6'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('7')">{{'7'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('8')">{{'8'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('9')">{{'9'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('10')">{{'10'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('11')">{{'11'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('12')">{{'12'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('13')">{{'13'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('14')">{{'14'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('15')">{{'15'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('16')">{{'16'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('17')">{{'17'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('18')">{{'18'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('19')">{{'19'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('20')">{{'20'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('21')">{{'21'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('22')">{{'22'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('23')">{{'23'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('24')">{{'24'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('25')">{{'25'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('26')">{{'26'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('27')">{{'27'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('28')">{{'28'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('29')">{{'29'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('30')">{{'30'}}</x-button>
    </div>
    @endif

    @if ($voteMethod === 'star:1..5')
    <div class="w-full text-center">
        <x-button class="m-2 p-4" wire:click="addContestVote('exit')">{{'exit'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('⭐️')">{{'⭐️'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('⭐️⭐️')">{{'⭐️⭐️'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('⭐️⭐️⭐️')">{{'⭐️⭐️⭐️'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('⭐️⭐️⭐️⭐️')">{{'⭐️⭐️⭐️⭐️'}}</x-button>
        <x-button class="m-2 p-4" wire:click="addContestVote('⭐️⭐️⭐️⭐️⭐️')">{{'⭐️⭐️⭐️⭐️⭐️'}}</x-button>
    </div>
    @endif

</div>
