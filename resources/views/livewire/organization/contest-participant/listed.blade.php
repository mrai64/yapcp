<?php

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
    public $contestParticipantsSet;
    //
    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $this->contest->organization;
    }
    //
    public function with()
    {
        return [
            'contestParticipantsSet' => ContestParticipant::query()
                ->select('contest_participants.*') // Evita conflitti di colonne o id duplicati
                ->join('user_contacts', 'contest_participants.user_contact_id', '=', 'user_contacts.id') // Esegui la join con la tabella correlata
                ->join('countries', 'user_contacts.country_id', '=', 'countries.id') // Esegui la join con la tabella correlata
                ->where('contest_participants.contest_id', $this->contest->id)
                ->with(['userContact']) // Mantiene l'eager load per la visualizzazione
                ->orderBy('countries.country', 'asc') // Ordina per il campo della tabella correlata
                ->orderBy('user_contacts.last_name', 'asc') // Ordina per il campo della tabella correlata
                ->orderBy('user_contacts.first_name', 'asc') // Ordina per il campo della tabella correlata
                ->orderBy('user_contacts.updated_at', 'desc') // Ordina per il campo della tabella correlata
                ->paginate(10)
        ];
    }
    // act
    public function switchPaymentCompleted(string $contestId, string $userId)
    {
        $contestParticipant = ContestParticipant::where('contest_id', $contestId)
            ->where('user_contact_id', $userId)
            ->firstOrFail();
        $contestParticipant->update([
            'fee_payment_completed' => ! $contestParticipant->fee_payment_completed,
        ]);

    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ __("Contest participant works review for contest:") }}
            <br />
            {{ $contest->name_en }}
        </h2>
        <hr class="my-2" />
        <p class="fyk text-xl">
            {{ __("Your org: :organization", ['organization' => $organization->name]) }}
        </p>
        <hr class="my-2" />
        <div class="fyk text-xl">
            {{ __("These are the troubled title of image that be solved.")}}<br>
            {{ __("Look at the right line then click the Solved button.")}}
        </div>
        <hr class="my-4" />
        <x-yapcp.header-link 
            txt="User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link
            txt="Org Dashboards"
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
        <x-yapcp.header-link
            txt="Contest Review Dashboards"
            url="{{ route('organization.contest-work.listed', ['contest' => $contest]) }}" />
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

                <!-- -->
                @if ($contestParticipantsSet->isEmpty())
                 <h3 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
                     {{ __("No participants at now") }}
                 </h3>
                @else
                 <div class="paginationDiv">
                     {{ $contestParticipantsSet->links() }}
                 </div>

                 <table class="data-table-container w-auto">
                    <!-- thead missing-->
                    <tbody>
                    @foreach ($contestParticipantsSet as $deltaItem => $contestParticipant)
                        <tr class="border my-2" wire:key="waiting-{{ $contestParticipant->user_contact_id }}">
                            <td valign="top" class="pe-4">{{ $contestParticipantsSet->firstItem() + $deltaItem }}</td>
                            <td valign="top" class="pe-4 text-2xl">
                                <form wire:submit.prevent="switchPaymentCompleted('{{$contestParticipant->contest_id}}', '{{$contestParticipant->user_contact_id}}')">
                                    <x-button class="mb-4 mx-4">
                                        {{$contestParticipant->fee_payment_completed ? __("✅ COMPLETED") :  __("⏲️ Waiting") }}
                                    </x-button>
                                </form>
                            </td>
                            <td valign="top" class="fyk text-xl pe-4 ">
                                {{$contestParticipant->userContact->country->flag_code }}
                                {{$contestParticipant->userContact->country->country }}
                            </td>
                            <td valign="top" class="">
                                <p class="fyk text-2xl">
                                    {{$contestParticipant->userContact->last_name }},
                                    {{$contestParticipant->userContact->first_name }}
                                </p>
                                <p class="fyk text-xl">
                                    {{$contestParticipant->userContact->email}}<br>
                                    {{($contestParticipant->userContact->city) ? $contestParticipant->userContact->city : __("N\A") }}<br >
                                    {{($contestParticipant->userContact->address) ? $contestParticipant->userContact->address : __("N\A") }}
                                    {{($contestParticipant->userContact->address_line2) ? "<br />" . $contestParticipant->userContact->address_line2 : ""}} 
                                </p>
                            </td>
                            <td valign="top" class="">
                                <x-yapcp.inline-link
                                    txt="📥 Email her/him"
                                    url="mailto:{{$contestParticipant->userContact->email}}" />
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
