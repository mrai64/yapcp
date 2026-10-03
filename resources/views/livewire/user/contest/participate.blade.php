<?php

/**
 * User have selected a Contest and can add her/him
 *   UserWork in a ContestSection
 *
 * input: contest id (+ user by Auth)
 *
 */

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\User;
use App\Models\UserWork;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    //
    public User     $user;
    public Contest  $contest;
    public          $userWorks;
    public          $contestWorks;
    public          $contestSections;
    // first
    public function mount(Contest $contest) // contest from route
    {
        // can / cannot ? class contestwork, but input contest
        $this->authorize('create', [ContestWork::class, $contest]);
        //
        $this->contest = $contest;
        $this->contestSections = $contest->sections;
        $this->user = Auth::user();
    }
    // every update
    public function with()
    {
        // the participant in contest (if )
        $contestWorks = ContestWork::where('user_id', $this->user->id)
            ->where('contest_id', $this->contest->id)
            ->with(['userWork', 'section'])
            ->get();
        // group then count
        $worksCountBySectionCode = $contestWorks
            ->groupBy(fn ($work) => $work->section->code)
            ->map(fn ($group) => $group->count())
            ->toArray();
        // the participant contestWork id list
        $assignedUserWorkIds = $contestWorks->pluck('user_work_id')->filter();

        // 2. UserWork dell'utente che NON sono presenti nei contestWork di questo concorso
        $availableUserWorks = $this->user->userWorks()
            ->with('userWorkMores')
            ->whereNotIn('id', $assignedUserWorkIds)
            ->get();

        return [
            'contestWorks' => $contestWorks,
            'worksCountBySectionCode' => $worksCountBySectionCode,
            'userWorks' => $availableUserWorks,
            'contestSections' => $this->contestSections,
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __(':name, Your participation to :contestName ', ['name' => $user->userContact->first_name, 'contestName' => $contest->name_en] ) }}
        </h2>
        <hr class="my-2" />
        <p class="fyk text-xl">{{__("Closing date")}}: {{$contest->day_2_closing->format("Y-m-d") }}</p>
        <hr class="my-2" />
        <h3 class="fyk text-xl font-medium text-gray-900">
            {{ __("Contest section plate") }}
        </h3>
        <!-- Contest section list w/counter -->
        @foreach($contestSections as $cSec)
        <p class="inline-flex small">[  {{$cSec->code}} {{($cSec->min_works > 0) ? "Portfolio min:".$cSec->min_works : "" }} max:{{$cSec->max_works}} short_size:{{$cSec->short_size_max}}  long_size:{{$cSec->long_size_max}}  mono:{{($cSec->monochromatic_required === 'Y') ? 'Y' : 'N' }}  raw:{{($cSec->rule_raw === 'Y') ? 'Y' : 'N' }}  ]</p>
        @endforeach
        <hr class="my-2" />
        <h3 class="fyk text-xl font-medium text-gray-900">
            {{ __("Your participation plate") }}
        </h3>
        <!-- Contest section list w/counter -->
        @foreach($contestSections as $cSec)
        @php
            $cntWork = $worksCountBySectionCode[$cSec->code] ?? 0;
        @endphp
        <p class="inline-flex small">[ {{ __(":code, your: :cntWork / :maxWork", [ 'code' => $cSec->code, 'cntWork' => $cntWork , 'maxWork' => $cSec->max_works ]) }} ]</p>
        @endforeach
        <hr class="mb-4" />
        <x-yapcp.header-link
            txt="Back to dashboard"
            url="{{ route('user.dashboard') }}" />
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    {{ session('success') }}
                </div>
                @endif

                <!-- errors list -->
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <h2 class="fyk text-2xl font-medium text-gray-900">
                    {{ __("Your Submitted Works")}}
                </h2>
                <table class="data-table-container w-full">
                    <thead>
                        <tr>
                            <th scope="col" class="data-table-code w-1/4">Section Assign<br>Portfolio sequence</td>
                            <th scope="col" class="data-table-name w-1/4">Work miniature</td>
                            <th scope="col" class="data-table-actions w-1/2">Work infos</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contestWorks as $contestWork)
                        <tr class="border my-4">
                            <td scope="row" class="text-center" align="center">
                                @livewire('user.contest-work.remove', ['contestWork' => $contestWork->id ])
                            </td>
                            <td>
                                <!-- td work miniature TODO shadow img -->
                                <img src="{{ asset('storage/photos') .'/'. $contestWork->userWork->file_path }}"
                                    style="float: left;" class="block w-48 me-3" />
                            </td>
                            <td class="small">
                            <!-- td work info  -->
                            <em>{{ __("Intl Title")}}:</em>
                                {{$contestWork->userWork->title_en}}<br />
                            <em>{{ __("Local Title")}}:</em>
                                {{$contestWork->userWork->title_local}}<br />
                            <em>{{ __("Reference Year")}}:</em>
                                {{$contestWork->userWork->reference_year}}
                            <em>{{ __("Short size")}}:</em>
                                {{$contestWork->userWork->short_size}}
                            <em>{{ __("Long size")}}:</em>
                                {{$contestWork->userWork->long_size}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr class="my-2" />
                <h2 class="fyk text-2xl font-medium text-gray-900">
                    {{ __("Your Selectable Works")}}
                </h2>
                <p class="small">{{ __("Chhose section code, when sequence/portfolio number remain 0 is automatic assigned") }}</p>
                <table class="data-table-container w-full">
                    <thead>
                        <tr>
                            <th scope="col" class="data-table-code w-1/4">Section<br />Assign</td>
                            <th scope="col" class="data-table-name w-1/4">Work miniature</td>
                            <th scope="col" class="data-table-actions w-1/2">Work infos</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($userWorks as $work)
                        <tr class="border my-4">
                            <td scope="row" class="text-center" align="center">
                                @livewire('user.contest-work.add', ['dataJson' => json_encode(['contestId' => $contest->id, 'workId' => $work->id, 'contestSectionSet' => $contestSections ]) ])
                            </td>
                            <td>
                                <!-- td work miniature TODO shadow img -->
                                <img src="{{ asset('storage/photos') .'/'. $work->file_path }}"
                                    style="float: left;" class="block w-48 me-3" />
                            </td>
                            <td valign="top" align="left">
                                <!-- td work info  -->
                                <em>{{ __("Intl Title")}}:</em>
                                    {{$work->title_en}}<br />
                                <em>{{ __("Local Title")}}:</em>
                                    {{$work->title_local}}<br />
                                <em>{{ __("Short size")}}:</em>
                                    {{$work->short_size}}
                                <em>{{ __("Long size")}}:</em>
                                    {{$work->long_size}}<br />
                                <em>{{ __("Monochromatic vs Color")}}:</em>
                                    {{ ($work->is_monochromatic) ? __("monochromatic") : __("color") }}<br />
                                <em>{{ __("Have RAW")}}:</em>
                                    {{ ($work->has_raw_file) ? __("Yes, i have") : __("No Raw") }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
