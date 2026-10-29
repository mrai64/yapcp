<?php

/**
 * Organization Contest Manage - The last Jury task: Minute sign
 * 
 * 
 */

use App\Models\Contest;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    //
    public Contest $contest;
    public Organization $organization;
    public $sectionJuries;
    public $sectionStats;
    public $sectionAwards;
    public $contestAwards;

    //
    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization  = $this->contest->organization;
        $this->sectionJuries = $this->contest->getSectionWithSortedJuries();
        $this->sectionStats  = $this->contest->getSectionsStats();
        $this->sectionAwards = $this->contest->getSectionAwards();
        $this->contestAwards = $this->contest->globalAwards()
            ->get();
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ __("Minute draft for contest:")}}
            <br />
            {{ $contest->name_en }}
        </h2>
        <hr class="my-2" />
        <ul>
            <li class="small">
                {{__("This page contains all the information you need to draw up the jury’s report for the photography competition.")}}
            </li>
            <li class="small">
                {{ __("Organisations usually provide a template on letterhead on which to write the report; you simply need to copy and paste the text, then produce a final, neat copy of the report for printing and for the jurors to sign.")}}
            </li>
            <li class="small">
                {{__("Please consider the option of sending the file containing the minutes to the jurors so that they can return it to you with a digital signature. A section of the competition is set aside for storing documents such as the minutes and the copies initialled by the jurors.")}}
            </li>
        </ul>
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
                <p  class="text-red-600 small">{{ __("CUT -- Minute start here -- CUT")}}</p>
                <hr class="text-red-600 my-4" />
                <!-- intro and contest info -->
                Today [day] [month] [year],
                <br>
                for the contest {{ $contest->name_en }}
                <br>
                organized by {{ $organization->name }}
                <br>
                the following are reunited as jury
                <br>
                @foreach ($sectionJuries as $section)
                    for section-theme {{$section->code}} {{$section->name_en}}
                    <br />
                    @foreach ($section->contestJuries as $jury)
                        {{ ($jury->is_president) ? 'P' : 'J'}}
                        |
                        {{$jury->userContact->country->flag_code}} {{$jury->userContact->country->id}}
                        {{$jury->userContact->last_name }}, {{$jury->userContact->first_name }}
                        <br />
                    @endforeach
                    <br />
                @endforeach
                to complete the jury works, started at [day] [month] [year]
                to examine 
                [modus operandi]
                <br />
                <!-- contest section-themes list -->
                @foreach ($sectionStats as $section)
                    for section-theme {{$section->code}} {{$section->name_en}}
                    <br />
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    n. {{$section->total_works_count}} by n. {{$section->total_authors_count}} from n. {{$section->total_countries_count}} countries
                    <br>
                @endforeach

                <!-- loop for every section -->
                [how jury had work]
                <br />
                The jury has decided to admit the following to the competition
                <br />
                <!-- contest section-themes list -->
                @foreach ($sectionStats as $section)
                    for section-theme {{$section->code}} {{$section->name_en}}
                    <br />
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    n. {{$section->admitted_works_count}} by n. {{$section->admitted_authors_count}} from n. {{$section->admitted_countries_count}} countries
                    <br>
                @endforeach

                <!-- contest awards -->
                After to award the prizes as follows
                <br >
                @foreach ($sectionAwards as $section)
                    for {{$section->code}} {{$section->name_en}}
                    <br />
                    @foreach ($section->awards as $award)
                        {{$award->award_code}} | {{$award->award_name}}
                        <br/>
                        @if ($award->winner_work_id)
                            {{$award->contestWork->userWork->title_en}}
                            <br />
                            {{__("by")}}
                            {{$award->contestWork->author->last_name}},
                            {{$award->contestWork->author->first_name}}
                            <br />
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            {{$award->contestWork->author->country->flag_code}}
                            {{$award->contestWork->author->country->id}}, 
                            {{$award->contestWork->author->city}} 
                        @endif
                        @if ($award->winner_user_id)
                            {{$award->userContact->last_name}},
                            {{$award->userContact->first_name}}
                            <br />
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            {{$award->userContact->country->flag_code}}
                            {{$award->userContact->country->id}}, 
                            {{$award->userContact->city}} 
                        @endif
                        @if ($award->winner_name)
                            {{$award->winner_name}}
                        @endif
                        <br />
                        @if ($award->citation)
                            {{__("Citation")}}
                            <br />
                            {{$award->citation}}
                            <br />
                        @endif
                        <br />
                    @endforeach
                @endforeach

                and, for the contest
                for the contest {{ $contest->name_en }}
                <br>
                organized by {{ $organization->name }}
                <br>
                @foreach ($contestAwards as $award)
                    {{$award->award_code}} | {{$award->award_name}}
                    <br/>
                    @if ($award->winner_work_id)
                        {{$award->contestWork->userWork->title_en}}
                        <br />
                        {{__("by")}}
                        {{$award->contestWork->author->last_name}},
                        {{$award->contestWork->author->first_name}}
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        {{$award->contestWork->author->country->flag_code}}
                        {{$award->contestWork->author->country->id}}, 
                        {{$award->contestWork->author->city}} 
                    @endif
                    @if ($award->winner_user_id)
                        {{$award->userContact->last_name}},
                        {{$award->userContact->first_name}}
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        {{$award->userContact->country->flag_code}}
                        {{$award->userContact->country->id}}, 
                        {{$award->userContact->city}} 
                    @endif
                    @if ($award->winner_name)
                        {{$award->winner_name}}
                    @endif
                    <br />
                    @if ($award->citation)
                        {{__("Citation")}}
                        <br />
                        {{$award->citation}}
                        <br />
                    @endif
                    <br />
                @endforeach

                <!-- jurors signage space -->
                Signed, read, approved

                [city, date]

                - loop jurors signage space -

                <hr class="text-red-600 my-4" />
                <p  class="text-red-600 small">{{ __("CUT -- Minute stop here -- CUT")}}</p>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>