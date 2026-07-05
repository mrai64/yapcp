<?php

/**
 * Organization Contest Design / Remove Award to Contest or ContestSection
 *
 */

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    public Contest $contest;
    public Organization $organization;
    public ContestAward $contestAward;
    //
    public string $contestAwardAwardCode; //   award_code     sortable
    public string $contestAwardAwardName; //   award_name
    public bool   $contestAwardIsAward; //     is_award       bool

    public function mount(ContestAward $contest_award)
    {
        $this->contestAward = $contest_award;
        $this->contest = $contest_award->contest;
        $this->organization = $this->contest->organization;

        $this->contestAwardAwardCode = $this->contestAward->award_code;
        $this->contestAwardAwardName = $this->contestAward->award_name;
        $this->contestAwardIsAward   = (bool) $this->contestAward->is_award;
    }

    public function removeContestAward()
    {
        $this->contestAward->delete();

        return redirect()
            ->route('organization.design.contest-award.listed', ['contest' => $this->contest ])
            ->with('success', __('Award Removed'));
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

                <h3 class="fyk text-2xl font-medium text-red-500">
                    {{ __('‼️ Remove an Award') }}
                </h3>
                <!--  -->
                <form wire:submit="removeContestAward">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="contestAwardAwardCode" :value="__('Award / HM Code')" />
                        <x-text-input wire:model="contestAwardAwardCode" id="contestAwardAwardCode" name="contestAwardAwardCode" 
                            class="block mt-1 w-48" type="text" readonly />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="contestAwardAwardName" :value="__('Award / HM Name')" />
                        <x-text-input wire:model="contestAwardAwardName" id="contestAwardAwardName" name="contestAwardAwardName" 
                            class="block mt-1 w-full" type="text" readonly />
                    </div>

                    <!-- Real Prize, or less -->
                    <div class="mb-4">
                        <x-yapcp.checkbox 
                            fld="contestAwardIsAward" 
                            :head="__('Real Prize, or less than')" 
                            :value="__('Yes, it´s a real prize.')" disabled />
                    </div>

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Are You Sure? Remove?') }}
                    </x-button>
                </form>
                <!--/ -->
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
