<?php

/**
 * User can register her/him membership
 *
 */

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestWork;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    //
    public User     $user;
    public Contest  $contest;
    public $groupAlreadyPresent;
    public $memberOfGroup = '';
    public $groupNames = [];
    //
    public function mount(Contest $contest) // contest from route
    {
        // can / cannot ? class ContestWork, but input contest
        $this->authorize('create', [ContestWork::class, $contest]);
        //

        $this->contest = $contest;
        $this->user = Auth::user();
        $alreadyParticipant = ContestParticipant::whereContestId($this->contest->id)
            ->where('user_contact_id', $this->user->id)
            ->first() ?? null;
        $this->memberOfGroup = $alreadyParticipant?->group_name ?? '';

        $groupNames = ContestParticipant::whereContestId($this->contest->id)
            ->whereNotNull('group_name')
            ->where('group_name', '!=', '')
            ->distinct()
            ->pluck('group_name');

        $organizations = Organization::whereNot('id', $this->contest->organization_id)
            ->where('name', '>', '.z')
            ->pluck('name'); // Estrae direttamente una collection con i soli nomi

        $this->groupNames = $groupNames->merge($organizations)
            ->unique()      // Rimuove i duplicati
            ->sort()        // Ordina alfabeticamente
            ->values()      // Resetta gli indici numerici dell'array
            ->toArray();    // Converte il risultato in array per Livewire

    }
    //
    public function rules()
    {
        return [
            'groupAlreadyPresent' => [
                'nullable',
                Rule::in($this->groupNames)
            ],
            'memberOfGroup' => [
                'nullable', 
                'string',
                'max:250'
            ],
        ];
    }
    //
    public function addContestParticipantGroup()
    {
        $validated = $this->validate();

        if (empty($validated['groupAlreadyPresent']) && empty($validated['memberOfGroup'])) {
            $this->addError('memberOfGroup', __("Almost one of both"));
            return;
        }

        $groupName = !empty($validated['groupAlreadyPresent']) ? $validated['groupAlreadyPresent'] : $validated['memberOfGroup'];
        ContestParticipant::updateOrCreate(
            [
                'contest_id' => $this->contest->id,
                'user_contact_id' => $this->user->id,
            ],
            [
                'group_name' => $groupName,
            ]
        );

        session()->flash('success', __("Group name added to participation record"));

    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __(':name, Your participation to :contestName ', ['name' => $user->userContact->first_name, 'contestName' => $contest->name_en] ) }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.header-link
            txt="Back to dashboard"
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.inline-link 
            txt="Contest Participate" 
            url="{{ route('user.contest.participate', ['contest' => $contest->id]) }}" />
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

                <h3 class="fyk text-2xl font-medium text-gray-900">
                    {{ __("As member of") }}
                </h3>

                <form wire:submit="addContestParticipantGroup">
                    @csrf

                    @if (count($groupNames))
                    <div class="mb-4">
                        <x-input-label for="groupAlreadyPresent" :value="__('A group already present')" />
                        <select id="groupAlreadyPresent"
                            name="groupAlreadyPresent"
                            wire:model.live="groupAlreadyPresent"
                            class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full'>
                            <option value="">{{ __("...") }}</option>
                            @foreach ($this->groupNames as $index => $groupName)
                            <option value="{{$groupName}}" >
                                {{ $groupName }}
                            </option>
                            @endforeach
                        </select>
                        <x-input-error for="groupAlreadyPresent" class="text-red-600 mt-2" />
                    </div>
                    @endif

                    <div class="mb-4">
                        <x-input-label for="memberOfGroup" :value="__('Or new Group/Photo Club')" />
                        <x-text-input wire:model="memberOfGroup" id="memberOfGroup" name="memberOfGroup" 
                            class="block mt-1 w-full" type="text" required />
                        <x-input-error for="memberOfGroup" class="mt-2" />
                    </div>
                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Add me as member of') }}
                    </x-button>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
