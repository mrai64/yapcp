<?php

/**
 * Organization Contest Manage / List of award assigned and unassigned
 *
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
        $this->contestSectionId   = ($contestSection->id) ?? null;
        $this->organization       = $this->contest->organization;
        if($this->contestSectionId){
            $this->contestSection     = $contestSection;
            $this->contestAwardsSet   = ContestAward::where('contest_id', $this->contest->id)
                ->with(['contestWork'])
                ->where('section_id', $this->contestSectionId)
                ->orderBy('award_code')
                ->get();

        } else {
            $this->contestSection     = new ContestSection();
            $this->contestAwardsSet   = ContestAward::where('contest_id', $this->contest->id)
                ->with(['contestWork'])
                ->whereNull('section_id')
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
        <x-yapcp.inline-link
            txt="Candidate"
            url="{{ route('organization.contest-award.candidate', ['contestSection' => $contestSection]) }}" />
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
            <!-- .. -->
                <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
                    {{ __("Section scoreboards" ) }}
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
            <!-- .. -->
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
