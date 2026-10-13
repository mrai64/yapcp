<?php

/**
 * User Closed Contest List - page
 * 
 * That blade must show, if present, the contest that are
 * after contests.day2_closing ( > ).
 * 
 * ! Must be checked also the timezone contest vs timezone user
 *
 * Participants board
 * ContestWork results when available
 *
 * ! WORK IN PROGRESS
 */

use App\Models\Contest;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    //
    public string $contestYear;
    public $userTz; // userTimezone
    //
    public function mount(?string $contestYear = null)
    {
        // Se viene passato un valore, lo validiamo (Integer tra 2000 e 9999)
        if ($contestYear !== null) {
            $validated = Validator::make(['contestYear' => $contestYear], [
                'contestYear' => ['required', 'integer', 'between:2000,9999'],
            ])->validate();

            $this->contestYear = $validated['contestYear'];
        } else {
            $this->contestYear = (string) now()->year;
        }

        // 1. Recuperiamo la timezone dell'utente (fallback su quella del server)
        $this->userTz      = Auth::user()->contact->timezone_id ?? config('app.timezone');
    }

    public function with(): array
    {
        // 1. Recuperiamo la timezone dell'utente (fallback su quella del server)
        $userTz = Auth::user()->contact->timezone_id ?? config('app.timezone');

        // 2. Creiamo il riferimento "Ora" nel fuso orario dell'utente
        // Carbon gestirà la conversione in UTC automaticamente durante la query SQL
        $now = CarbonImmutable::now($userTz);
        if ($this->contestYear == $now->year) {
            return [
                'userTz' => $userTz,
                'closedContestSet' => Contest::query()
                    ->with(['country', 'contestPatronage', 'contestParticipants', 'organization', 'timezone']) 
                    // Usiamo il confronto tra timestamp completi, non solo date
                    ->where('day_2_closing', '<', $now)
                    ->where('day_2_closing', '>=', ($this->contestYear . '-01-01 00:00:00'))
                    ->orderBy('day_2_closing', 'desc') // Scadenza più vicina per prima
                    ->orderBy('country_id', 'asc')
                    ->orderBy('name_en', 'asc')
                    ->paginate(10),
            ];
        } else {
            return [
                'userTz' => $userTz,
                'closedContestSet' => Contest::query()
                    ->with(['country', 'contestPatronage', 'contestParticipants', 'organization', 'timezone']) 
                    // Usiamo il confronto tra timestamp completi, non solo date
                    ->where('day_2_closing', '<=', ($this->contestYear . '-12-31 23:59:59'))
                    ->where('day_2_closing', '>=', ($this->contestYear . '-01-01 00:00:00'))
                    ->orderBy('day_2_closing', 'desc') // Scadenza più vicina per prima
                    ->orderBy('country_id', 'asc')
                    ->orderBy('name_en', 'asc')
                    ->paginate(10),
            ];
        }
    }
    //
}; 

?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Contest 'closed to participate' today") }}
        </h2>
        <p class="small">
            {{ __("Ordered by deadline, then country id, then contest name") }}
            <br />
            {{ __("Note: upto 'revelation day' all admit counter are forced at zero") }}
        </p>
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

                @if ($closedContestSet->isEmpty() )
                <div class="fyk border text-2xl rounded-md px-4 py-6 text-center text-gray-500">
                    {{ __('There are currently no cloesd competitions at now.') }}
                </div>
                @else
                <div class="mt-8">
                    {{ $closedContestSet->links() }}
                </div>

                <dl class="space-y-6">
                    @foreach ($closedContestSet as $contest)
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:border-indigo-300 transition-colors relative">
                        <dt class="fyk text-2xl font-bold text-indigo-700">
                            {{ $contest->country?->flag_code }} {{ $contest->name_en }}
                        </dt>

                        <dd class="my-1 text-gray-600 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="font-semibold mr-1">{{ __('Closing date') }}:</span> 
                            <span title="Local: {{ $contest->day_2_closing->setTimezone($contest->timezone_id ?? 'UTC')->format('Y-m-d H:i') }} ({{ $contest->timezone_id }})">
                                {{ $contest->day_2_closing->setTimezone($userTz)->format('Y-m-d H:i') }}
                            </span>
                        </dd>
                        <dd class="my-1 text-gray-600 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="font-semibold mr-1">{{ __('Revelation date') }}:</span> 
                            <span title="Local: {{ $contest->day_5_revelations->setTimezone($contest->timezone_id ?? 'UTC')->format('Y-m-d H:i') }} ({{ $contest->timezone_id }})">
                                {{ $contest->day_5_revelations->setTimezone($userTz)->format('Y-m-d H:i') }}
                            </span>
                        </dd>
                        <dd class="my-1 text-sm text-gray-500 italic flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            {{ __('Organized by') }}: {{ $contest->organization?->name }}
                        </dd>
                        <dd class="my-1 text-sm text-gray-500 italic flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            {{ __('Patronages') }}: {{ $contest->getContestPatronages() ?? __("none"); }}
                        </dd>
                        <dd class="mt-2">
                            <!-- if participate / not participate -->
                             @if ($contest->myParticipation)
                            <x-yapcp.inline-link 
                                txt="Your Results" 
                                url="#" />
                             @else
                            <x-yapcp.inline-link 
                                txt="not entered" 
                                url="#" />
                             @endif
                            <!-- contest general -->
                            <x-yapcp.inline-link 
                                txt="Result Board" 
                                url="{{ route('user.contest-participant.listed-closed', ['contest' => $contest]) }}" />
                            <x-yapcp.inline-link 
                                txt="Catalogues" 
                                url="#" />
                        </dd>
                    </div>
                    @endforeach
                </dl>
                @endif

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
