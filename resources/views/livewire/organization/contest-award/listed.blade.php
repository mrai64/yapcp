<?php

/**
 * Organization Contest Manage / List of award assigned and unassigned
 *
 * For section, and without section
 */

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    //
    public ContestSection  $contestSection;
    public Contest         $contest;
    public Organization    $organization;
    public                 $contestSectionId;
    public                 $contestAwardsSet;
    // first
    public function mount(Contest $contest, ?ContestSection $contestSection = null)
    {
        //
        $this->contest            = $contest;
        $this->organization       = $this->contest->organization;
        if($contestSection){
            // section
            $this->contestSection     = $contestSection;
            $this->contestSectionId   = $contestSection->id;
            $this->contestAwardsSet   = ContestAward::where('contest_id', $this->contest->id)
                ->with(['contestWork.userWork', 'userContact.country'])
                ->where('section_id', $this->contestSectionId)
                ->orderByDesc('is_award') // false 0 < true 1
                ->orderBy('award_code')
                ->get();

        } else {
            // contest
            $this->contestSectionId   = 0;
            $this->contestAwardsSet   = ContestAward::where('contest_id', $this->contest->id)
                ->with(['contestWork.userWork', 'userContact.country'])
                ->where(function ($query) {
                    $query->whereNull('section_id')
                          ->orWhere('section_id', '');
                })
                ->orderByDesc('is_award') // false < true
                ->orderBy('award_code')
                ->get();
        }
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ $contest->name_en }}
        </h2>
        <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
            {{ __("Awards dashboard by :name" , ['name' => $organization->name] ) }}
        </h3>
        <p class="small">
            {{ __("WARN: Use n combination of Candidate link, for the SAME section") }}
        </p>
        <hr class="mb-4" />
        @if ($contestSectionId)
        <x-yapcp.header-link
            txt="Candidate"
            url="{{ route('organization.contest-award.candidate', ['contestSection' => $contestSection]) }}" />
        @else
        <x-yapcp.header-link
            txt="Contest"
            url="{{ route('organization.contest-award.contest', ['contest' => $contest]) }}" />
        @endif
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
            @if ($contestSectionId)
                <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
                    {{ __("Section Awards Board" ) }}
                </h3>
                <table class="data-table-container w-auto">
                    <tbody>
                        @forelse ($contestAwardsSet as $contestAward)
                        <tr class="border">
                            <td valign="top" class="fyk text-xl px-4">
                                {{ $contestAward->award_code}}
                                <br />
                                {{ $contestAward->award_name}}
                            </td>
                            <td valign="top" class="px-4">
                                @if ($contestAward->winner_work_id)
                                <img src="{{ asset('storage/contests') .'/'. $contestAward->contest_id .'/'. $contestAward->section_id .'/'. $contestAward->winner_work_id .'.'. $contestAward->contestWork->userWork->file_format }}"
                                    class="max-h-[150] max-w-[150] object-contain rounded-lg shadow-md"
                                    @contextmenu.prevent
                                    alt="All rights reserved"
                                    lazy />
                                @else
                                    {{ __("Unassigned") }}
                                @endif
                            </td>
                            <td valign="top" class="px-4">
                                <x-yapcp.header-link
                                    txt="Citation"
                                    url="{{ route('organization.contest-award.citation', ['contestAward' => $contestAward]) }}" />
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    {{ __("No award here?") }}
                                </td>

                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @else
                <!-- contest prize list -->
                <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
                    {{ __("Contest Awards Board" ) }}
                </h3>
                <p class="small">
                    {{ __("Usually Contest awards aren't only for works, but authors or group")}}
                </p>
                <table class="data-table-container w-auto">
                    <tbody>
                        @forelse ($contestAwardsSet as $contestAward)
                        <tr class="border">
                            <td valign="top" class="fyk text-xl px-4">
                                {{ $contestAward->award_code}}
                                <br />
                                {{ $contestAward->award_name}}
                            </td>
                            <td valign="top" class="fyk test-2xl px-4">
                                @if ($contestAward->winner_work_id)
                                <!-- winner_work_id -->
                                <img src="{{ asset('storage/contests') .'/'. $contestAward->contest_id .'/'. $contestAward->contestWork->section_id .'/'. $contestAward->winner_work_id .'.'. $contestAward->contestWork->userWork->file_format }}"
                                    class="max-h-[150] max-w-[150] object-contain rounded-lg shadow-md"
                                    @contextmenu.prevent
                                    alt="All rights reserved"
                                    lazy />
                                @endif
                                @if ($contestAward->winner_user_id)
                                <!-- winner_user_id -->
                                    {{ $contestAward->userContact->country->flag_code }}
                                    {{ $contestAward->userContact->country->country }}
                                    <br>
                                    {{ $contestAward->userContact->last_name }}
                                    {{ $contestAward->userContact->first_name }}
                                    <br>
                                    {{ $contestAward->userContact->city }}
                                @endif
                                @if ($contestAward->winner_name)
                                <!-- winner_name -->
                                    {{ $contestAward->winner_name }}
                                @endif
                                @if (!$contestAward->winner_work_id && !$contestAward->winner_user_id && $contestAward->winner_name === '')
                                {{ __("Temporary Unassigned")}}
                                @endif                                
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    {{ __("No award here?") }}
                                </td>

                            </tr>
                        @endforelse
                    </tbody>
                </table>

            @endif
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
