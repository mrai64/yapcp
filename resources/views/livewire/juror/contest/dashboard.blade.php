<?php

/**
 * User as Contest Juror - Contest Dashboard
 *
 */

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\ContestWork;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    //
    public Contest       $contest;
    public Organization  $organization;
    public               $contestSections;
    public int           $contestWorkAll;
    public int           $contestVoted;
    public bool          $reviewRequired;

    // first
    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $contest->organization;
        $jurorId = Auth::id();

        $this->contestWorkAll = ContestWork::where('contest_id', $this->contest->id)
            ->count();

        $this->contestVoted = ContestVote::where('contest_id', $this->contest->id)
            ->where('juror_user_id', $jurorId)
            ->count();

        $this->reviewRequired = ContestVote::where('contest_id', $this->contest->id)
            ->where('juror_user_id', $jurorId)
            ->where('review_required', true)
            ->count();

        $this->contestSections = ContestSection::where('contest_id', $this->contest->id)
            ->withCount('contestWorks as participantWorksCount')
            ->withCount(['contestVotes as votedWorksCount' => function ($query) use ($jurorId){
                $query->where('juror_user_id', $jurorId);
            }])
            ->orderBy('code')
            ->get();
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Jury works for Contest :contestName", ['contestName' => $contest->name_en ]) }}
        </h2>
        <hr class="my-2" />
        <h3 class="fyk text-xl font-medium text-gray-900">
            {{ __("From: :opening to :closing (last meet included)", ['opening' => $contest->day_3_jury_opening->format('Y-m-d') , 'closing' => $contest->day_4_jury_closing->format('Y-m-d') ]) }}
            <br />
            {{ __("Organization: " . $contest->organization->country->flag_code . ' ' . $contest->organization->country_id . ' | ' . $contest->organization->name ) }}
        </h3>
        <hr class="mb-4" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
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

                <!-- immagini da votare finché ce ne sono -->
                @if ($contestWorkAll > $contestVoted)
                <table class="data-table-container w-auto">
                    <thead>
                        <tr>
                            <th scope="col" class="data-table-section-counter">{{ __("Voted / Total")}}</th>
                            <th scope="col" class="data-table-section-code fyk text-2xl">{{ __("Contest Section n Theme")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contestSections as $contestSection)
                        <tr class="border my-2">
                            <td valign="top" class="fyk text-xl">
                                @if ($contestSection->votedWorksCount < $contestSection->participantWorksCount)
                                {{ $contestSection->votedWorksCount }}
                                /
                                {{ $contestSection->participantWorksCount }}
                                <br />
                                <x-yapcp.header-link 
                                    txt="Vote Section" 
                                    url="{{ route('juror.contest.section', ['contestSection' => $contestSection]) }}" />
                                @else
                                {{ __("All :num voted ✅", ['num' => $contestSection->participantWorksCount]) }}
                                @endif
                            </td>
                            <td valign="top" class="fyk text-2xl">
                                {{ $contestSection->code }}
                                {{ $contestSection->name_en }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h3 class="fyk text-xl font-medium text-gray-900">
                    {{ __("All voted now") }}
                </h3>
                @endif

                <!-- vote board review -->
                <table class="data-table-container w-auto">
                    <thead>
                        <tr>
                            <th scope="col" class="data-table-section-counter">{{ __("Total")}}</th>
                            <th scope="col" class="data-table-section-code fyk text-2xl">{{ __("Contest Section n Theme")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contestSections as $contestSection)
                        <tr class="border my-2">
                            <td valign="top" class="fyk text-xl">
                                {{ $contestSection->participantWorksCount }}
                                <x-yapcp.header-link 
                                    txt="Vote modify" 
                                    url="{{ route('juror.contest.voted-board', ['contestSection' => $contestSection]) }}" />
                            </td>
                            <td valign="top" class="fyk text-2xl">
                                {{ $contestSection->code }}
                                {{ $contestSection->name_en }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Eventuale ri-voto in/out -->
                @if ($reviewRequired)
                    <!-- livewire -->
                @else
                <hr class="my-4" />
                <h3 class="fyk text-xl font-medium text-gray-900">
                    {{ __("No review in/out requested at now") }}
                </h3>
                @endif

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
