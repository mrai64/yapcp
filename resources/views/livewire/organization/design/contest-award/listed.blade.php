<?php

/**
 * Organization Contest Design / list of Contest and ContestSection awards
 *
 */

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    //
    public Contest $contest;
    public Organization $organization;
    public $contestAwardsSet;
    //
    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $contest->organization;

        $contestAwardsSet = ContestAward::where('contest_id', $this->contest->id)
            ->orderBy('section_id', 'asc')
            ->orderBy('is_award', 'desc')
            ->orderBy('section_code', 'asc')
            ->get();

            $this->contestAwardsSet = $contestAwardsSet->groupBy(function ($item){
                return $item->section_code ?? '..';
            })
            ->toArray();
        ds($this->contestAwardsSet);
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify Contest infos') }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.organization.design.contest-nav :contest="$contest" active="awards" />
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

                @if ( count($contestAwardsSet) === 0)
                <h3>
                    {{ __('Add first Award to your Contest') }}
                </h3>
                <x-yapcp.inline-link 
                    txt="Add Award"
                    url="{{ route('organization.design.contest-award.add', ['contest' => $contest]) }}" />
                @else
                <x-yapcp.inline-link 
                    txt="Add Another Award"
                    url="{{ route('organization.design.contest-award.add', ['contest' => $contest]) }}" />
                    @foreach ($contestAwardsSet as $section => $prizeSet)
                    <div class="my-4 border ">
                        <div class="fyk text-2xl mb-4">
                            {{ ($section == '..') ? __("Contest Awards") : __("Section Code: :code", ['code' => $section])}}
                        </div>
                        <ul>
                        @foreach ($prizeSet as $contestAward)
                        <li class="font-mono">
                            {{ $contestAward['is_award'] ? '🏆' : '📜' }}
                            {{ $contestAward['award_code'] }} 
                            {{ $contestAward['award_name'] }}
                        </li>
                        @endforeach
                        </ul>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
