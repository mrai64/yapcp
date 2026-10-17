<?php

/**
 * Organization Contest Manage / Section Score board 
 *
 * using a table VIEW based on SUM VOTES 
 * TODO vote expressed by emoji MUST BE converted to integer in/out
 * count how many works have the same vote and
 * the % of works with same or greater vote
 * 
 */

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestVoteScoreboard;
use App\Models\ContestWork;
use App\Models\Organization;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    //
    use WithPagination;
    //
    public ContestSection $contestSection;
    public Contest        $contest;
    public Organization   $organization;
    public                $scoreboard;
    public                $rankings;
    public int            $totalParticipant;
    // first
    public function mount(ContestSection $contestSection) // as in route()
    {
        // can / cannot

        $this->contestSection   = $contestSection;
        $this->contest          = $this->contestSection->contest;
        $this->organization     = $this->contest->organization;
        $this->totalParticipant = ContestWork::where('section_id', $this->contestSection->id)->count();
    }
    // for every page
    public function with(): array
    {
        // 1. Estrae tutte le righe della sezione dalla vista
        $summaries = ContestVoteScoreboard::where('section_id', $this->contestSection->id)
            ->get();

        // 2. Raggruppiamo per total_votes in modo da avere una sola riga per ogni punteggio unico
        // e calcoliamo quanti lavori hanno total_votes >= di quel punteggio
        $rankings = $summaries->groupBy('total_votes')
            ->map(function ($group, $totalVotes) use ($summaries) {
                // Conteggio di quanti lavori hanno ottenuto una somma >= a questo total_votes
                $greaterOrEqualCount = $summaries->where('total_votes', '>=', $totalVotes)->count();

                return [
                    'total_votes' => (int) $totalVotes,
                    'greater_or_equal_count' => $greaterOrEqualCount,
                ];
            })
            // 3. Ordiniamo in modo decrescente per somma voti
            ->sortByDesc('total_votes')
            ->values();

        return [
            'rankings' => $rankings,
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ __("Juror (sum) Vote board for contest:") }}
            <br />
            {{ $contest->name_en }}
            <br />
            {{ __("Section")}}: {{ $this->contestSection->name_en}}
        </h2>
        <hr class="my-2" />
        <p class="small">
            {{ __("Your org: :organization", ['organization' => $organization->name]) }}
        </p>
        <hr class="mb-4" />
        <x-yapcp.header-link 
            txt="User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link
            txt="Org Dashboards"
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    ✅ {{ session('success') }}
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

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right fyk text-2xl font-medium text-gray-500 uppercase tracking-wider">{{ __("Vote Sum") }}</th>
                    <th class="px-6 py-3 text-right text-xs      font-medium text-gray-500 uppercase tracking-wider">{{ __("# of GE") }}</th>
                    <th class="px-6 py-3 text-right fyk text-2xl font-medium text-gray-500 uppercase tracking-wider">{{ __("% of GE") }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($rankings as $row)
                    <tr>
                        <td class="fyk text-2xl px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                            {{ $row['total_votes'] }}
                        </td>
                        <td class="fyk text-xl px-6 py-4 whitespace-nowrap  text-gray-600">
                            {{ $row['greater_or_equal_count'] }} 
                            / 
                            {{ $totalParticipant }}
                        </td>
                        <td class="fyk text-2xl text-right">
                            {{ sprintf("%3.2f", (100 * $row['greater_or_equal_count']) / $totalParticipant )}}%
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                            Nessun voto registrato in questa sezione.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
