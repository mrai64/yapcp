<?php

/**
 * Organization contest list, design, running, closed
 * 
 */

use App\Models\Contest;
use App\Models\Organization;
use App\Models\UserContact;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;


new class extends Component {

    public Organization $organization;
    public UserContact $userContact;
    public $contestSet;
    // designSet
    public function getDesignSetProperty()
    {
        return $this->contestSet->filter(fn ($contest) => now()->lt($contest->day_1_opening) );
    }
    // beforeJurySet
    public function getBeforeJurySetProperty()
    {
        return $this->contestSet
            ->filter(fn ($contest) => now()->gt($contest->day_1_opening) && now()->lt($contest->day_3_jury_opening) );
    }
    // duringJuryWindowSet
    public function getDuringJuryWindowSetProperty()
    {
        return $this->contestSet
            ->filter(fn ($contest) => now()->gt($contest->day_3_jury_opening) && now()->lt($contest->day_4_jury_closing) );
    }
    // beforeRevelationsSet
    public function getBeforeRevelationsSetProperty()
    {
        return $this->contestSet
            ->filter(fn ($contest) => now()->gt($contest->day_4_jury_closing) && now()->lt($contest->day_5_revelations) );
    }
    // beforeCataloguesSet
    public function getBeforeCataloguesSetProperty()
    {
        return $this->contestSet
            ->filter(fn ($contest) => now()->gt($contest->day_4_jury_closing) && now()->lt($contest->day_7_catalogues) );
    }
    //
    public function mount(Organization $organization)
    {
        //
        $this->authorize('update', [Organization::class, 'organization' => $organization]);
        //
        $this->organization = $organization;
        $this->userContact = Auth::user()->contact;
        //
        // contest all - then filtered
        $this->contestSet = Contest::where('organization_id', $this->organization->id)
            ->orderBy('day_2_closing', 'desc')
            ->get();
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ __(':name Contest List' , ['name' => $organization->name] ) }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link 
            txt="Back to Org Dashboard" 
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if($this->designSet->isEmpty())
                <p class="fyk">
                    {{ __("No contest in project") }}
                </p>
                @else
                <h3 class="fyk text-xl">
                    {{ __("Contest Design") }}
                </h3>
                <ol>
                @foreach ($this->designSet as $contest)
                <li class="fyk text-xl border py-2 my-2">
                    <x-yapcp.inline-link
                        txt="Design Contest"
                        url="{{ route('organization.design.contest.modify-name', ['contest' => $contest]) }}" />
                    {{ $contest-> name_en}} <br />
                    {{ __("Contest start at: " . \Carbon\Carbon::parse($contest->day_1_opening)->format('D j F Y') ) }}
                </li>
                @endforeach
                </ol>
                @endif

                @if($this->beforeJurySet->isEmpty())
                <p class="fyk">
                    {{ __("No contest manage before jury works") }}
                </p>
                @else
                <h3 class="fyk text-xl">
                    {{ __("Before Jury window works") }}
                </h3>
                <ol>
                @foreach ($this->beforeJurySet as $contest)
                <li class="fyk text-xl border py-2 my-2">
                    <x-yapcp.header-link
                        txt="Contest Review Dashboards"
                        url="{{ route('organization.contest-work.listed', ['contest' => $contest]) }}" />
                    {{ $contest->name_en}} <br />
                    {{ __("Jury works start: " . \Carbon\Carbon::parse($contest->day_3_jury_opening)->format('D j F Y') ) }}
                </li>
                @endforeach
                </ol>
                @endif

                @if($this->duringJuryWindowSet->isEmpty())
                <p class="fyk">
                    {{ __("No contest in jury window works") }}
                </p>
                @else
                <h3 class="fyk text-xl">
                    {{ __("During Jury window works") }}
                </h3>
                <ol>
                @foreach ($this->duringJuryWindowSet as $contest)
                <li class="fyk text-xl border py-2 my-2">
                    <x-yapcp.inline-link 
                        txt="Jury Dashboard" 
                        url="{{ route('organization.contest-jury.juror-board', ['contest' => $contest] ) }}" />
                    {{ $contest-> name_en}} <br />
                    {{ __("Jury works end at: " . \Carbon\Carbon::parse($contest->day_4_jury_closing)->format('D j F Y') ) }}
                </li>
                @endforeach
                </ol>
                @endif

                @if($this->beforeRevelationsSet->isEmpty())
                <p class="fyk">
                    {{ __("No Revelation in progress") }}
                </p>
                @else
                <h3 class="fyk text-xl">
                    {{ __("During Revelation ") }}
                </h3>
                <ol>
                @foreach ($this->beforeRevelationsSet as $contest)
                <li class="fyk text-xl border py-2 my-2">
                    <x-yapcp.inline-link 
                        txt="Contest dashboard" 
                        url="{{ route('user.dashboard') }}" />
                    {{ $contest-> name_en}} <br />
                    {{ __("Results revelations at: " . \Carbon\Carbon::parse($contest->day_5_revelations)->format('D j F Y') ) }}
                </li>
                @endforeach
                </ol>
                @endif

                @if($this->beforeCataloguesSet->isEmpty())
                <p class="fyk">
                    {{ __("No contest with Catalogues in progress") }}
                </p>
                @else
                <h3 class="fyk text-xl">
                    {{ __("During Jury window works") }}
                </h3>
                <ol>
                @foreach ($this->beforeCataloguesSet as $contest)
                <li class="fyk text-xl border py-2 my-2">
                    <x-yapcp.inline-link 
                        txt="Contest dashboard" 
                        url="{{ route('user.dashboard') }}" />
                    {{ $contest-> name_en}} <br />
                    {{ __("Contest Catalogue in progress at: " . \Carbon\Carbon::parse($contest->day_7_catalogues)->format('D j F Y') ) }}
                </li>
                @endforeach
                </ol>
                @endif

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
