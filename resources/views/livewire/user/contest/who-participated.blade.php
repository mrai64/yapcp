<?php

/**
 * Contest participants list, with report of section and results
 *   paginated
 *
 */

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\Organization;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public Contest       $contest;
    public Organization  $organization;
    public $contestSections;

    protected function getParticipantsQueryProperty()
    {
        $isAfterRevelations = now()->greaterThan($this->contest->day_5_revelations);
        $sections = $this->contest->contestSections()->orderBy('code')->get();

        $query = ContestParticipant::where('contest_id', $this->contest->id)
            ->with(['userContact.country'])
            ->join('user_contacts', 'contest_participants.user_contact_id', '=', 'user_contacts.id')
            ->select('contest_participants.*')
            ->orderBy('user_contacts.country_id')
            ->orderBy('user_contacts.last_name')
            ->orderBy('user_contacts.first_name');

        foreach ($sections as $section) {
            $sectionCode = $section->code;

            // Conteggio lavori presentati per sezione
            $query->withCount([
                'contestWorks as section_' . $sectionCode . '_works_count' => function ($q) use ($section) {
                    $q->where('section_id', $section->id);
                }
            ]);

            // Conteggio lavori ammessi per sezione (subordinato alle rivelazioni o forzato a 0)
            $admitCondition = function ($q) use ($section) {
                $q->where('section_id', $section->id)->where('is_admit', 1);
            };

            if (!$isAfterRevelations) {
                $admitCondition = function ($q) use ($section) {
                    $q->where('section_id', $section->id)->whereRaw('0 = 1');
                };
            }

            $query->withCount([
                'contestWorks as section_' . $sectionCode . '_admit_count' => $admitCondition
            ]);
        }

        return $query;
    }

    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $contest->organization;
        $this->contestSections = $contest->contestSections()->orderBy('code')->get();
    }

    public function with(): array
    {
        return [
            'contestParticipants' => $this->getParticipantsQueryProperty()->paginate(10),
            'isAfterRevelations' => now()->greaterThan($this->contest->day_5_revelations),
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Participant list for contest ") }}<br />
            {{ $contest->country?->flag_code }}
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
        <hr class="my-2" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.inline-link
            txt="Closed Contest Board" 
            url="{{ route('user.contest.listed-closed', ['contestYear' => now()->year ]) }}" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Success message -->
                @if (session('success'))
                    <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2 text-green-600">
                        {{ session('success') }}
                    </div>
                    <hr />
                @endif

                <!-- Errors list -->
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
                    <div class="paginationDiv mb-4">
                        {{ $contestParticipants->links() }}
                    </div>

                    <div class="overflow-x-auto">
                        <table class="data-table-container w-full border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="fyk text-xl border border-gray-300 p-2">{{ __("Participant") }}</th>
                                    @foreach ($contestSections as $section)
                                    <th class="fyk text-xl border border-gray-300 p-2 text-center" colspan="2">
                                        {{ __("Section") }} 
                                        <br />
                                        {{ $section->code }}
                                        {{ $section->name_en }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contestParticipants as $contestParticipant)
                                    @php 
                                        $contact = $contestParticipant->userContact; 
                                    @endphp
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="border border-gray-300 p-2 align-top">
                                            <div class="font-medium">{{ $contact?->last_name }}, {{ $contact?->first_name }}</div>
                                            <div class="text-sm text-gray-600">
                                                {{ $contact?->country?->flag_code }}
                                                {{ $contact?->country_id }}
                                                {{ $contact?->city }}
                                                {{ $contact?->region }}
                                            </div>
                                        </td>
                                        @foreach ($contestSections as $section)
                                            @php
                                                $worksKey = 'section_' . $section->code . '_works_count';
                                                $admitKey = 'section_' . $section->code . '_admit_count';
                                            @endphp
                                            <td class="border border-gray-300 p-2 text-center align-top bg-blue-50/50">
                                                <span class="text-xs text-gray-500 block">{{ __('Works') }}</span>
                                                <span class="font-semibold">{{ $contestParticipant->$worksKey ?? 0 }}</span>
                                            </td>
                                            <td class="border border-gray-300 p-2 text-center align-top bg-green-50/50">
                                                <span class="text-xs text-gray-500 block">{{ __('Admit') }}</span>
                                                <span class="font-semibold text-green-700">{{ $contestParticipant->$admitKey ?? 0 }}</span>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-sm">
                        @if ($isAfterRevelations)
                        {{ __("Admit counter are updated at jury result")}}
                        @else
                        <span class="text-red-600">
                            {{ __("Admit counter are forced to zero, until 'revelation day'")}}
                        </span>
                        @endif
                    </div>

                    <div class="paginationDiv mt-4">
                        {{ $contestParticipants->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>