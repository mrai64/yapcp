<?php

/**
 * Contest participants list, simple w/fee status exposed
 *
 */

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\Organization;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    //
    public Contest $contest;
    public Organization $organization;
    public $contestParticipants;
    // first
    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $contest->organization;
    }
    // for every page
    public function with(): array
    {
        return [
            // Utilizziamo il metodo del modello che sfrutta l'eager loading ('contact')
            // e ordina in base alla tabella correlata dei contatti utente.
            'contestParticipants' => ContestParticipant::query()
            ->where('contest_id', $this->contest->id)
            ->with(['userContact.country']) // Eager load del contatto e della nazionalità/bandiera
            ->join('user_contacts', 'contest_participants.user_contact_id', '=', 'user_contacts.id')
            ->select('contest_participants.*') // Evita conflitti di colonne o id duplicati
            ->orderBy('user_contacts.country_id')
            ->orderBy('user_contacts.last_name')
            ->orderBy('user_contacts.first_name')
            ->orderBy('user_contacts.id')
            ->paginate(50),
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Participant list for contest ") }}<br />
            {{ $contest->country->flag_code }}
            {{ $contest->country_id }}
            |
            {{ $contest->name_en }}
        </h2>
        <h3 class="fyk text-xl">
            {{ __("Organized by: :organization", ['organization' => $organization->name])}}
        </h3>
        <hr class="my-2" />
        <h3 class="fyk text-xl">
            {{ __("Reference date: :today UTC", ['today' => now()->timezone("UTC")->toIso8601String() ])}}
        </h3>
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

                @if ($contestParticipants->isEmpty())
                    <div class="fyk border text-2xl rounded-md px-4 py-6 text-center text-gray-500">
                        {{ __('There are currently no participant.') }}
                    </div>
                @else
                    <div class="paginationDiv">
                        {{ $contestParticipants->links() }}
                    </div>

                    <table class="data-table-container w-full">
                        <thead>
                            <tr>
                                <th class="w-1/8">{{ __("Status") }}</th>
                                <th class="w-1/8">{{ __("Country") }}</th>
                                <th class="w-6/8">{{ __("Participant, from ") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contestParticipants as $contestParticipant)
                                @php $contact = $contestParticipant->userContact; @endphp
                                <tr class="border my-2">
                                    <td valign="top" class="pe-4" nowrap>
                                        {{ $contestParticipant->fee_payment_completed ? __("✅ COMPLETED") : __("🟨 INCOMPLETE") }}
                                    </td>
                                    <td valign="top">
                                        {{ $contact?->country?->flag_code }}
                                        {{ $contact?->country_id }}
                                    </td>
                                    <td valign="top">
                                        {{ $contact?->last_name }},
                                        {{ $contact?->first_name }} - 
                                        {{ $contact?->city }} 
                                        {{ $contact?->region }} 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif


            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
