<?php

/**
 * Organization Contest Manage / List of admit and... 
 *
 */

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestWork;
use App\Models\Organization;
use App\Models\UserContact;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    //
    public Contest      $contest;
    public Organization $organization;
    public              $unassignedAwardsSet;
    public              $awardedParticipants;
    // as form fields
    public string $contestWorkId = '';
    public string $contestUserId = '';
    public string $contestName   = '';
    public array  $awardCode     = [];
    // first
    public function mount(Contest $contest)
    {
        $this->contest             = $contest;
        $this->organization        = $this->contest->organization;
    }
    // for every page
    public function with(): array
    {
        $this->unassignedAwardsSet = ContestAward::query()
            ->whereNull('section_id')
            ->whereNull('winner_work_id')
            ->whereNull('winner_user_id')
            ->where('winner_name', '')
            ->orderBy('award_code')
            ->get();

        // all awards 
        $assignedContestAwards = ContestAward::query()
            ->where('is_award', true)
            ->where(function ($query) {
                $query->whereNotNull('winner_work_id')
                    ->orWhereNotNull('winner_user_id')
                    ->orWhere(function ($q) {
                        $q->whereNotNull('winner_name')
                            ->where('winner_name', '!=', '');
                        });
                })
            ->get();

        $assignedWorkIds = collect($assignedContestAwards)
            ->pluck('winner_work_id')
            ->unique()
            ->toArray();
        // candidate to a contest prize should be any of 
        // previous awarded images, if
        $candidateContestWorks = ContestWork::query()
            ->select('contest_works.*') // Evita conflitti se ci sono colonne con lo stesso nome
            ->join('user_works', 'contest_works.user_work_id', '=', 'user_works.id') // Unisci la tabella delle relazioni
            ->with(['userWork','userWork.userContact', 'userWork.userContact.country']) // Mantiene l'eager loading per l'utilizzo nel frontend
            ->whereIn('contest_works.id', $assignedWorkIds)
            ->orderBy('user_works.user_id')
            ->orderBy('user_works.id')
            ->paginate(6);

        return [
            'unassignedAwards'      => $this->unassignedAwardsSet,
            'candidateContestWorks' => $candidateContestWorks,
        ];
    }
    //
    public function rules()
    {
        return [
            'userId'       => 'nullable|uuid',
            'winnerName'   => 'nullable|string|max:250',
        ];
    }
    //
    public function assignName()
    {
        //
        $validated = $this->validate();
        //
        $selectedAwardCode = $this->awardCode['name'] ?? null;
        $contestAward = ContestAward::whereNull('section_id')
            ->where('award_code', $selectedAwardCode)
            ->firstOrFail();

        $contestAward->update([
            'winner_name' => $validated['winnerName'],
        ]);

        return redirect()
            ->route('organization.contest-award.contest', ['contest' => $this->contest])
            ->with('success', __("Update the Award page"));

    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ $contest->name_en }}
        </h2>
        <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
            {{ __("Candidate dashboard by :name" , ['name' => $organization->name] ) }}
        </h3>
        <p class="small">
            {{ __("WARN: Use n combination of Award link, for the SAME section") }}
        </p>
        <hr class="mb-4" />
        <x-yapcp.header-link 
            txt="Award assignment"
            url="{{ route('organization.contest-award.listed', ['contest' => $contest]) }}" />
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

                <!-- award by contest work -->
                @livewire('organization.contest-award.contest-work', ['contest' => $contest])

                <!-- award by contest participant -->
                @livewire('organization.contest-award.contest-user', ['contest' => $contest])

                <!-- award by other / group name -->
                <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
                    {{ __("Assign by Name") }}
                </h3>
                <form wire:submit.prevent="assignName()">
                <table class="data-table-container w-full">
                    <thead>
                        <th>{{ __("Assign")}}</th>
                        <th>{{ __("Work")}}</th>
                    </thead>
                    <tbody>
                        <tr class="border">
                            <td valign="top" class="px-2">
                                <!-- award code -->
                                <select 
                                    class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full'
                                    id="awardCode"
                                    name="awardCode"
                                    wire:model="awardCode.name"
                                    required >
                                    <option value="">{{ __("...") }}</option>
                                    @foreach ($unassignedAwards as $contestAward)
                                        <option value="{{ $contestAward->award_code }}">
                                            {{ $contestAward->award_code }}  {{ $contestAward->name_en}} 
                                        </option>
                                    @endforeach
                                </select>

                                <x-button class="mb-4 mx-4">{{ __("Assign") }}</x-button>
                            </td>
                            <td valign="top" class="px-4 w-full">
                                <div class="mb-4">
                                    <!-- winner is -->
                                    <x-input-label for="winnerName" :value="__('Award by Name')" />
                                    <x-text-input class="block mt-1 w-full" 
                                        type="text" name="winnerName" wire:model="winnerName" id="winnerName" 
                                        />
                                    <x-input-error for="winnerName" class="mt-2" />
                                </div>

                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>