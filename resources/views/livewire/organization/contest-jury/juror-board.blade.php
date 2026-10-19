<?php

/**
 * Organization contest manage - During Jury window
 * 1. table of contest section voted per total 
 * 2. table of contest section total_score LINK
 */

use App\Models\Contest;
use App\Models\ContestJury;
use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\ContestWork;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Livewire\Volt\Component;

new class extends Component {

    public Contest $contest;
    public Organization $organization;
    public $contestSections;

    // sectionVoteSummary
    public function getSectionVoteSummaryProperty(string $sectionId)
    {
        // temporary table
        $votesPerWork = ContestVote::where('section_id', $sectionId)
            ->select('contest_work_id', DB::raw('SUM(CAST( vote AS SIGNED)) as total_score')) // not for '***'
            ->groupBy('contest_work_id');
        //
        $summary = DB::query()
            ->fromSub($votesPerWork, 'v') // alias v, like sql 'from user_contacts uc'
            ->select('total_score', DB::raw('COUNT(contest_work_id\) as works_count'))
            ->groupBy('total_score')
            ->orderByDesc('total_score') // no 'total_score', 'desc'
            ->get();
        //
        return $summary;
    }

    public function mount(Contest $contest)
    {
        // can - cannot
        $this->authorize('update', [Contest::class, $contest]);

        $this->contest = $contest;
        $this->organization = $contest->organization;
        $this->contestSections = $contest->contestSections()
            ->orderby('code')
            ->get();
    }

    public function with(): array
    {
        // Recuperiamo i giurati assegnati alle sezioni del contest (gruppo per sezione e giurato)
        $jurorBoards = ContestJury::where('contest_id', $this->contest->id)
            ->with(['contestSection', 'userContact'])
            ->get()
            ->map(function ($jury) {
                // Conteggio voti assegnati dal giurato specifico per questa sezione
                $assignedVotes = ContestVote::where('contest_id', $this->contest->id)
                    ->where('section_id', $jury->section_id)
                    ->where('juror_user_id', $jury->user_id)
                    ->count();

                // Conteggio opere partecipanti per quella sezione nel ContestWork[cite: 4, 6]
                $participatingWorks = ContestWork::where('contest_id', $this->contest->id)
                    ->where('section_id', $jury->section_id)
                    ->count();

                return [
                    'section_code' => $jury->contestSection->code ?? '',
                    'section_name' => $jury->contestSection->name_en ?? '',
                    'juror_name' => $jury->userContact ? ($jury->userContact->first_name . ', ' . $jury->userContact->last_name) : '',
                    'assigned_votes' => $assignedVotes,
                    'participating_works' => $participatingWorks,
                ];
            });

        return [
            'jurorBoards' => $jurorBoards,
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ $contest->name_en }}
        </h2>
        <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
            {{ __("Jurors dashboard by :name" , ['name' => $organization->name] ) }}
        </h3>
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

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Section Code")}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Juror Name")}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Section Name")}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Voted")}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("per Total Works")}}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($jurorBoards as $row)
                                <tr class="p-2 my-2 border">
                                    <td valign="top" class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        {{ $row['section_code'] }}
                                    </td>
                                    <td valign="top" class="fyk px-6 py-4 whitespace-nowrap text-xl text-gray-700">
                                        {{ $row['juror_name'] }}
                                    </td>
                                    <td valign="top" class="fyk px-6 py-4 whitespace-nowrap text-xl text-gray-700">
                                        {{ $row['section_name'] }}
                                    </td>
                                    <td valign="top" class="px-6 py-4 whitespace-nowrap text-mono text-gray-700 text-right">
                                        {{ $row['assigned_votes'] }}
                                    </td>
                                    <td valign="top" class="px-6 py-4 whitespace-nowrap text-mono text-gray-700 text-right">
                                        {{ $row['participating_works'] }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        {{ __("No one vote for that Contest at now") }}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <hr class="my-4" />
                <!-- section scoreboards -->
                <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
                    {{ __("Section scoreboards" ) }}
                </h3>
                <p class="small">
                    {{ __("Check ScoreBoard and assign awards ONLY AFTER all votes was assigned, in all sections")}}
                </p>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("")}}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Code")}}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Name")}}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($contestSections as $contestSection)
                            <tr class="p-2 my-2 border">
                                <td valign="top" class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    <x-yapcp.header-link 
                                        txt="Award assignment" 
                                        url="{{ route('organization.contest-award.listed', ['contest' => $contest, 'contestSection' => $contestSection]) }}" />
                                    <x-yapcp.header-link 
                                        txt="Candidate" 
                                        url="{{ route('organization.contest-award.candidate', ['contestSection' => $contestSection]) }}" />
                                    <x-yapcp.header-link 
                                        txt="Scoreboard" 
                                        url="{{ route('organization.contest-vote.section-scoreboard', ['contestSection' => $contestSection]) }}" />
                                </td>
                                <td valign="top" class="fyk text-xl px-6 py-4 whitespace-nowrap font-semibold text-gray-900">
                                    {{ $contestSection->code }}
                                </td>
                                <td valign="top" class="fyk text-xl px-6 py-4 whitespace-nowrap font-semibold text-gray-900">
                                    {{ $contestSection->name_en }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ __("No one vote for that Contest at now") }}.
                                </td>
                            </tr>
                        @endforelse
                        <tr class="p-2 my-2 border">
                            <td valign="top" class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                <x-yapcp.header-link 
                                    txt="Award assignment" 
                                    url="{{ route('organization.contest-award.listed', ['contest' => $contest]) }}" />
                            </td>
                            <td valign="top" class="fyk text-xl px-6 py-4 whitespace-nowrap font-semibold text-gray-900">
                                --
                            </td>
                            <td valign="top" class="fyk text-xl px-6 py-4 whitespace-nowrap font-semibold text-gray-900">
                                {{ __("Contest") }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- TODO HERE THE AWARD ASSIGN Link -->
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>