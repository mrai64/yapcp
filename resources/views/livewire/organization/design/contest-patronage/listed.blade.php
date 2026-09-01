<?php

/**
 * Organization Contest Design / list of Contest Federation Patronage
 *
 */

use App\Models\Contest;
use App\Models\ContestPatronage;
use App\Models\Federation;
use App\Models\Organization;
use Livewire\Volt\Component;

new class () extends Component {
    //
    public Contest $contest;
    public Organization $organization;
    public $contestPatronagesSet;
    //
    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $contest->organization;

        $contestPatronagesSet = ContestPatronage::where('contest_id', $this->contest->id)
            ->orderBy('federation_id')
            ->orderBy('patronage_code')
            ->get();
        $this->contestPatronagesSet = $contestPatronagesSet;// ->toArray();

    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Federation Patronage Code Index') }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.organization.design.contest-nav :contest="$contest" active="patronages" />
        <hr class="mb-2" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-yapcp.header-link 
			txt="Organization dashboard" 
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
        <x-yapcp.header-link 
            txt="Add Federation Patronage" 
            url="{{ route('organization.design.contest-patronage.add', ['contest' => $contest]) }}" />
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

                @if (count($contestPatronagesSet))
                <div class="fyk text-2xl font-medium text-gray-900">
                    {{ __('Federation Patronage assigned to ') }}
                    <br />
                    {{ $contest->name_en }}
                </div>
                <p class="small">{{ __("Not in priority order") }}</p>
                <br />
                <hr />
                <ul>
                @foreach ($contestPatronagesSet as $contestPatronage)
                    <li class="font-mono">
                        {{ $contestPatronage->federation->country->flag_code}}
                        {{ $contestPatronage->federation->id}}
                        {{ $contestPatronage->patronage_code}}
                        |
                        {{ $contestPatronage->federation->name_en}}
                        <br />
                        <x-yapcp.inline-link 
                            txt="Modify" 
                            url="{{ route('organization.design.contest-patronage.modify', ['contest_patronage' => $contestPatronage]) }}" />
                        <hr />
                    </li>
                @endforeach
                </ul>
                <br />
            @else
                <div class="fyk text-2xl font-medium text-gray-900">
                    {{ $contest->name_en }}
                    <br />
                    {{ __("Missing Patronage, but they are facultative... Add one?") }}
                </div>
            @endif
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
