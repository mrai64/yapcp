<?php

/**
 * Organization Contest Manage / list of admit...
 * 
 * used in organization.contest-award-contest 
 * as @livewire
 */

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestWork;
use App\Models\Organization;
use App\Models\UserContact;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    //
    use WithPagination;
    public Contest      $contest;
    public Organization $organization;
    public              $unassignedAwardsSet;
    public array  $awardCode     = [];
    public string $contestWorkId = '';
    //
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
        // TODO Build a check for uuid in contest and with is_admit true
        return [
            'contestWorkId' => 'required|uuid',
        ];
    }
    //
    public function assignWorkId($contestWorkId)
    {
        $this->contestWorkId = $contestWorkId;
        $validated = $this->validate();
        $selectedAwardCode = $this->awardCode[$contestWorkId] ?? null;

        $contestAward = ContestAward::whereNull('section_id')
            ->where('award_code', $selectedAwardCode)
            ->firstOrFail();

        $contestAward->update([
            'winner_work_id' => $validated['contestWorkId'],
        ]);

        return redirect()
            ->route('organization.contest-award.contest', ['contest' => $this->contest])
            ->with('success', __("Update the Award page"));
    }
}; ?>

<div>
    <!-- no page -->
    <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
        {{ __("Assign by Awarded Image") }}
    </h3>

    <div class="paginationDiv">
        {{ $candidateContestWorks->links() }}
    </div>

    <table class="data-table-container w-full">
        <thead>
            <th>{{ __("Assign")}}</th>
            <th>{{ __("Work")}}</th>
        </thead>
        <tbody>
            @forelse ($candidateContestWorks as $contestWork)
            <tr class="border">
                <td valign="top" class="px-2">
                    <form wire:submit.prevent="assignWorkId('{{$contestWork->id}}')">
                        <select 
                            class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full'
                            id="awardCode"
                            name="awardCode"
                            wire:model="awardCode.{{$contestWork->id}}"
                            required >
                            <option value="">{{ __("...") }}</option>
                            @foreach ($unassignedAwards as $contestAward)
                                <option value="{{ $contestAward->award_code }}">
                                    {{ $contestAward->award_code }}  {{ $contestAward->name_en}} 
                                </option>
                            @endforeach

                        </select>
                        <x-button class="mb-4 mx-4">{{ __("Assign") }}</x-button>
                    </form>
                </td>
                <td valign="top" class="px-2">
                    <img src="{{ asset('storage/contests') .'/'. $contestWork->contest->id .'/'. $contestWork->contestSection->id .'/'. $contestWork->id .'.'. $contestWork->userWork->file_format }}"
                        class="max-h-[150] max-w-[150] object-contain rounded-lg shadow-md"
                        @contextmenu.prevent
                        alt="All rights reserved"
                        lazy />
                </td>
                <td valign="top" class="px-4 w-full">
                    {{ $contestWork->userWork->userContact->last_name}}
                    {{ $contestWork->userWork->userContact->first_name}}
                    <br />
                    {{ $contestWork->userWork->userContact->city}}
                    <br />
                    {{ $contestWork->userWork->userContact->country->flag_code}}
                    {{ $contestWork->userWork->userContact->country->country}}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="">
                    {{ __("No images") }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
