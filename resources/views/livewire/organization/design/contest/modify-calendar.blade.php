<?php

/**
 * Organization contest design 2 / calendar
 *
 */

use App\Models\Contest;
use App\Models\Organization;
use App\Models\UserContact;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component {
    public Contest $contest;
    public Organization $organization;
    public UserContact $creator;
    // form fields
    public $day1Opening; // at 00:00
    public $day2Closing; // at 23:59
    public $day3JuryOpening;
    public $day4JuryClosing;
    public $day5Revelations;
    public $day6Awards;
    public $day7Catalogues;
    public $day8Closing;
    public string $voteRule;

    #[Computed]
    public function daysFromToday()
    {
        if (!$this->day1Opening) return 0;
        return CarbonImmutable::today()->diffInDays(CarbonImmutable::parse($this->day1Opening), false);
    }

    #[Computed]
    public function daysBetween($start, $end)
    {
        if (!$start || !$end) return 0;
        return CarbonImmutable::parse($start)->diffInDays(CarbonImmutable::parse($end));
    }


    public function mount(Contest $contest)
    {
        $this->contest      = $contest;
        $this->organization = $contest->organization;
        $this->creator      = Auth::user()->contact;

        $this->day1Opening      = $contest->day_1_opening
            ->setTimezone($contest->timezone_id)->format('Y-m-d');

        $this->day2Closing      = $contest->day_2_closing
            ->setTimezone($contest->timezone_id)->format('Y-m-d');
        
        $this->day3JuryOpening = $contest->day_3_jury_opening
            ->setTimezone($contest->timezone_id)->format('Y-m-d');
        
        $this->day4JuryClosing = $contest->day_4_jury_closing
            ->setTimezone($contest->timezone_id)->format('Y-m-d');
        
        $this->day5Revelations = $contest->day_5_revelations
            ->setTimezone($contest->timezone_id)->format('Y-m-d');
        
        $this->day6Awards = $contest->day_6_awards
            ->setTimezone($contest->timezone_id)->format('Y-m-d');
        
        $this->day7Catalogues = $contest->day_7_catalogues
            ->setTimezone($contest->timezone_id)->format('Y-m-d');
        
        $this->day8Closing = $contest->day_8_closing
            ->setTimezone($contest->timezone_id)->format('Y-m-d');

        $this->voteRule = $contest->vote_rule ?? '';

    }

    public function rules()
    {
        return [
            'day1Opening' => 'required|date',
            'day2Closing' => 'required|date|after:day1Opening',

            'day3JuryOpening' => 'required|date|after:day2Closing',
            'day4JuryClosing' => 'required|date|after:day3JuryOpening',

            'day5Revelations' => 'required|date|after:day4JuryClosing',
            'day6Awards' => 'required|date|after:day5Revelations',
            'day7Catalogues' => 'required|date|after:day6Awards',
            'day8Closing' => 'required|date|after:day7Catalogues',

            'voteRule' => 'required|string||exists:contests_vote_rule_sets,vote_rule'
        ];
    }

    public function messages()
    {
        // sample 
        return [
            'day1Opening.after' => 'La data di apertura deve essere successiva al ' 
                . CarbonImmutable::now()->addMonths(2)->format('Y-m-d'),
        ];
    }

    public function modifyContest()
    {
        $validated = $this->validate();

        // Funzione helper interna o ripetuta per convertire e salvare
        $this->contest->day_1_opening = CarbonImmutable::createFromFormat('Y-m-d', $validated['day1Opening'], $this->contest->timezone_id)->startOfDay();
        $this->contest->day_2_closing = CarbonImmutable::createFromFormat('Y-m-d', $validated['day2Closing'], $this->contest->timezone_id)->endOfDay();

        $this->contest->day_3_jury_opening = CarbonImmutable::createFromFormat('Y-m-d', $validated['day3JuryOpening'], $this->contest->timezone_id)->startOfDay();
        $this->contest->day_4_jury_closing = CarbonImmutable::createFromFormat('Y-m-d', $validated['day4JuryClosing'], $this->contest->timezone_id)->endOfDay();

        $this->contest->day_5_revelations = CarbonImmutable::createFromFormat('Y-m-d', $validated['day5Revelations'], $this->contest->timezone_id)->endOfDay();

        $this->contest->day_6_awards = CarbonImmutable::createFromFormat('Y-m-d', $validated['day6Awards'], $this->contest->timezone_id)->endOfDay();

        $this->contest->day_7_catalogues = CarbonImmutable::createFromFormat('Y-m-d', $validated['day7Catalogues'], $this->contest->timezone_id)->endOfDay();

        $this->contest->day_8_closing = CarbonImmutable::createFromFormat('Y-m-d', $validated['day8Closing'], $this->contest->timezone_id)->endOfDay();


        $this->contest->save();

        // redirect itself
        return redirect()
            ->route('organization.design.contest.modify-calendar', ['contest' => $this->contest])
            ->with('success', __('Contest infos updated.'));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify Contest infos') }}
        </h2>
        <hr class="mb-4" />
        <livewire:organization.design.contest.modify-nav :contest="$contest" />
        <hr class="mb-2" />
        <livewire:organization.design.contest-nav :contest="$contest" />
        <hr class="mb-2" />
        <x-header-link-app 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-header-link-app 
			txt="Organization dashboard" 
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
    </x-slot>

        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    {{ session('success') }}
                </div>
                <hr />
                @endif
                
                <!-- errors list -->
                @if ($errors->any())
                <br />
                <div class="mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                <br />
                @endif

                <div class="mb-4">
                    <h3 class="fyk text-xl font-medium text-gray-900">
                        {{ __('Contest timezone: :timezone', ['timezone' => $contest->timezone_id ]) }}
                    </h3>
                    <h3 class="fyk text-xl font-medium text-gray-900">
                        {{ __('Your timezone: :timezone', ['timezone' => $creator->timezone_id ]) }}
                    </h3>
                    <p class="small">
                        {{ __('Opening days have fixed time 00:00 on contest timezone. Others 23:59 ') }}
                    </p>
                </div>

                <form wire:submit="modifyContest">
                    @csrf

                    <!-- 1. Opening -->
                    <div class="mb-4 w-60">
                        <x-input-label for="day1Opening" :value="__('1 Participants Contest Opening')" />
                        <input wire:model="day1Opening" name="day1Opening" id="date-picker-1" 
                            class="form-control" type="date" required />
                        <p class="small">{{ __(':daysToStart days to start', ['daysToStart' => $this->daysFromToday ]) }}</p>
                        <x-input-error for="day1Opening" class="mt-2" />
                    </div>

                    <!-- 2. Opening -->
                    <div class="mb-4 w-60">
                        <x-input-label for="day2Closing" :value="__('2 Participants Contest Deadline')" />
                        <input wire:model="day2Closing" name="day2Closing" id="date-picker-2" 
                            class="form-control" type="date" required />
                        <p class="small">{{ __(':daysByDay1 days from start', ['daysByDay1' => $this->daysBetween($day1Opening, $day2Closing ) ]) }}</p>
                        <x-input-error for="day2Closing" class="mt-2" />
                    </div>

                    <!-- 3. Jury works Opening -->
                    <div class="mb-4 w-60">
                        <x-input-label for="day3JuryOpening" :value="__('3 Jury working start')" />
                        <input wire:model="day3JuryOpening" name="day3JuryOpening" id="date-picker-3" 
                            class="form-control" type="date" required />
                        <p class="small">{{ __(':daysByDay1 days from start', ['daysByDay1' => $this->daysBetween($day1Opening, $day3JuryOpening ) ]) }}</p>
                        <x-input-error for="day3JuryOpening" class="mt-2" />
                    </div>

                    <!-- 4. Jury works Closing -->
                    <div class="mb-4 w-60">
                        <x-input-label for="day4JuryClosing" :value="__('4 Jury last reunion')" />
                        <input wire:model="day4JuryClosing" name="day4JuryClosing" id="date-picker-4" 
                            class="form-control" type="date" required />
                        <p class="small">{{ __(':daysByDay1 days from start', ['daysByDay1' => $this->daysBetween($day1Opening, $day4JuryClosing ) ]) }}</p>
                        <x-input-error for="day4JuryClosing" class="mt-2" />
                    </div>

                    <!-- 5. Result revelations -->
                    <div class="mb-4 w-60">
                        <x-input-label for="day5Revelations" :value="__('5 Result revelation to participants and public')" />
                        <input wire:model="day5Revelations" name="day5Revelations" id="date-picker-5" 
                            class="form-control" type="date" required />
                        <p class="small">{{ __(':daysByDay1 days from start', ['daysByDay1' => $this->daysBetween($day1Opening, $day5Revelations ) ]) }}</p>
                        <x-input-error for="day5Revelations" class="mt-2" />
                    </div>

                    <!-- 6. Award ceremony -->
                    <div class="mb-4 w-60">
                        <x-input-label for="day6Awards" :value="__('6 Awards ceremony, online or not')" />
                        <input wire:model="day6Awards" name="day6Awards" id="date-picker-6" 
                            class="form-control" type="date" required />
                        <p class="small">{{ __(':daysByDay1 days from start', ['daysByDay1' => $this->daysBetween($day1Opening, $day6Awards ) ]) }}</p>
                        <x-input-error for="day6Awards" class="mt-2" />
                    </div>

                    <!-- 7. Catalogues publication -->
                    <div class="mb-4 w-60">
                        <x-input-label for="day7Catalogues" :value="__('7 Catalogues publication, online or not')" />
                        <input wire:model="day7Catalogues" name="day7Catalogues" id="date-picker-7" 
                            class="form-control" type="date" required />
                        <p class="small">{{ __(':daysByDay1 days from start', ['daysByDay1' => $this->daysBetween($day1Opening, $day7Catalogues ) ]) }}</p>
                        <x-input-error for="day7Catalogues" class="mt-2" />
                    </div>

                    <!-- 8. Contest closing works -->
                    <div class="mb-4 w-60">
                        <x-input-label for="day8Closing" :value="__('8 Finish all contest activities')" />
                        <input wire:model="day8Closing" name="day8Closing" id="date-picker-8" 
                            class="form-control" type="date" required />
                        <p class="small">{{ __(':daysByDay1 total days from start', ['daysByDay1' => $this->daysBetween($day1Opening, $day8Closing ) ]) }}</p>

                        <x-input-error for="day8Closing" class="mt-2" />
                    </div>

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Check all, then Modify') }}
                    </x-button>

                </form>
                
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
