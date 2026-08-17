<?php

/**
 * Organization Contest Design / Modify Award to Contest or ContestSection
 *
 */

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\Organization;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public Contest $contest;
    public Organization $organization;
    public ContestAward $contestAward;
    // contest_id
    public string $contestAwardSectionId; //   section_id     nullable
    public string $contestAwardSectionName; // section_code   nullable
    public string $contestAwardAwardCode; //   award_code     sortable
    public string $contestAwardAwardName; //   award_name
    public bool   $contestAwardIsAward; //     is_award       bool
    //

    public function mount(ContestAward $contest_award)
    {
        $this->contestAward = $contest_award;
        $this->contest = $contest_award->contest;
        $this->organization = $this->contest->organization;

        $this->contestAwardAwardCode = $this->contestAward->award_code;
        $this->contestAwardAwardName = $this->contestAward->award_name;
        $this->contestAwardIsAward   = (bool) $this->contestAward->is_award;
    }

    public function rules()
    {
        return [
            'contestAwardAwardCode'   => [
                'required',
                'uppercase',
                'max:10',
                Rule::unique(ContestAward::TABLENAME, 'award_code')
                    ->where('contest_id', $this->contest->id)
                    ->when($this->contestAwardSectionId, function($query) {
                        return $query->Where('section_id', $this->contestAwardSectionId);
                    }, function ($query) {
                        return $query->whereNull('section_id');
                    })
                    ->whereNull('deleted_at')
                    ->ignore($this->contestAward->id ?? null),
            ],
            'contestAwardAwardName'   => 'required|string|max:255',
            'contestAwardIsAward'     => 'nullable|boolean',
        ];
    }

    public function modifyContestAward()
    {
        $validated = $this->validate();

        $contestAward = ContestAward::withTrashed()->updateOrCreate(
            [
                'contest_id' => $this->contest->id,
                'award_code' => strtoupper($validated['contestAwardAwardCode']),
            ],
            [
                'award_name' => $validated['contestAwardAwardName'],
                'is_award'   => (bool) $validated['contestAwardIsAward'],
                'deleted_at' => null, // Fondamentale: ripristina il record se era cancellato
            ]
        );

        return redirect()
            ->route('organization.design.contest-award.listed', ['contest' => $this->contest ])
            ->with('success', __('Award Modified'));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify Contest infos') }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.organization.design.contest-nav :contest="$contest" active="general" />
        <hr class="mb-2" />
        <livewire:organization.design.contest-award.award-nav :contest="$contest" />
        <hr class="mb-2" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-yapcp.header-link 
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

                <!--  -->
                <form wire:submit="modifyContestAward">
                    @csrf
                    
                    <div class="mb-4">
                        <x-input-label for="contestAwardAwardCode" :value="__('Award / HM Code')" />
                        <x-text-input wire:model="contestAwardAwardCode" id="contestAwardAwardCode" name="contestAwardAwardCode" 
                            class="block mt-1 w-48" type="text" required />
                        <p class="small">{{ __("Uppercase code, at same time is the order key to show") }}</p>
                        <x-input-error for="contestAwardAwardCode" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="contestAwardAwardName" :value="__('Award / HM Name')" />
                        <x-text-input wire:model="contestAwardAwardName" id="contestAwardAwardName" name="contestAwardAwardName" 
                            class="block mt-1 w-full" type="text" required />
                        <x-input-error for="contestAwardAwardName" class="mt-2" />
                    </div>

                    <!-- Real Prize, or less -->
                    <div class="mb-4">
                        <x-yapcp.checkbox 
                            fld="contestAwardIsAward" 
                            :head="__('Real Prize, or less than')" 
                            :value="__('Yes, it´s a real prize.')" />
                        <x-input-error for="contestAwardIsAward" class="mt-2" />
                    </div>

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Save Changes') }}
                    </x-button>
                </form>
                <!--/ -->
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
