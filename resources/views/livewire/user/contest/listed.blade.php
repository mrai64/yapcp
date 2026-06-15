<?php

/**
 * User Contest List
 * 
 * That blade must show, if present, the contest that are
 * in the window between contests.day1_opening ( >= ) and
 * contests.day2_closing ( <= ).
 * 
 * ! Must be checked also the timezone contest vs timezone user
 *
 */

use App\Models\Contest;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public function with(): array
    {
        // 1. Recuperiamo la timezone dell'utente (fallback su quella del server)
        $userTz = Auth::user()->contact->timezone_id ?? config('app.timezone');

        // 2. Creiamo il riferimento "Ora" nel fuso orario dell'utente
        // Carbon gestirà la conversione in UTC automaticamente durante la query SQL
        $now = CarbonImmutable::now($userTz);

        return [
            'userTz' => $userTz,
            'openContestSet' => Contest::query()
                ->with(['country', 'organization', 'timezone']) 
                // Usiamo il confronto tra timestamp completi, non solo date
                ->where('day_1_opening', '<=', $now)
                ->where('day_2_closing', '>=', $now)
                ->orderBy('day_2_closing', 'asc') // Scadenza più vicina per prima
                ->orderBy('country_id', 'asc')
                ->orderBy('name_en', 'asc')
                ->paginate(10),
        ];
    }
    //
}; 

?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Contest Open to participate today") }}
        </h2>
        <p class="small">
            {{ __("Ordered by deadline, then country id, then contest name") }}
        </p>
        <hr class="mb-4 mt-4" />
        <p class="fyk text-xl mb-4">
            [ 
            <a href="{{ route('user.dashboard') }}">
                &larr; 
                {{ __('Back to user Dashboard') }} 
            </a>
            ]
            . .
        </p>
    </x-slot>
    <!-- -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
            <div class="float-end font-medium rounded-md px-4 py-2">
                {{ session('success') }}
            </div> 
            <hr />
            @endif

            @if ($openContestSet->isEmpty() )
            <div class="fyk border text-2xl rounded-md px-4 py-6 text-center text-gray-500">
                {{ __('There are currently no open competitions to enter.') }}
                <br />
                {{ __('If you are a Contest Organizer, you can start now a fresh contest on our platform.')}}
            </div>
            @else
                <dl class="space-y-6">
                    @foreach ($openContestSet as $contest)
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:border-indigo-300 transition-colors relative">
                            <dt class="fyk text-2xl font-bold text-indigo-700">
                                {{ $contest->country?->flag_code }} {{ $contest->name_en }}
                            </dt>
                            
                            <dd class="mt-2 text-gray-600 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="font-semibold mr-1">{{ __('Closing date') }}:</span> 
                                {{-- Mostriamo la data convertita nella Timezone dell'utente per chiarezza --}}
                                <span title="Local: {{ $contest->day_2_closing->setTimezone($contest->timezone_id ?? 'UTC')->format('Y-m-d H:i') }} ({{ $contest->timezone_id }})">
                                    {{ $contest->day_2_closing->setTimezone($userTz)->format('Y-m-d H:i') }}
                                </span>
                            </dd>
                            
                            <dd class="mt-1 text-sm text-gray-500 italic flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                {{ __('Organized by') }}: {{ $contest->organization?->name }}
                            </dd>

                            <dd class="mt-4">
                                <a href="{{ route('user.contest.participate', ['contest' => $contest->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Participate') }}
                                </a>
                            </dd>
                        </div>
                    @endforeach
                </dl>

                <div class="mt-8">
                    {{ $openContestSet->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- -->
</div>
