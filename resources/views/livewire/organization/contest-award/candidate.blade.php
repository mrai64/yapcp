<?php

/**
 * Organization Contest Manage / List of admit contest works candidate to a prize
 *
 */

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\Organization;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    //
    use WithPagination;
    //
    public ContestSection   $contestSection;
    public Contest          $contest;
    public Organization     $organization;
    public                  $contestSectionId;
    public                  $unassignedAwardsSet;
    // as form fields
    public string $contestWorkId;
    public array  $awardCode = [];
    // first
    public function mount(ContestSection $contestSection)
    {
        $this->contestSection   = $contestSection;
        $this->contest          = $this->contestSection->contest;
        $this->organization     = $this->contest->organization;
        //

    }
    // for every page
    public function with(): array
    {
        $this->unassignedAwardsSet = ContestAward::where('section_id', $this->contestSection->id)
            ->whereNull('winner_work_id')
            ->orderBy('award_code')
            ->get();
        $assignedContestAwards = ContestAward::where('section_id', $this->contestSection->id)
            ->whereNotNull('winner_work_id')
            ->get();

        $assignedWorkIds = collect($assignedContestAwards)
            ->pluck('winner_work_id')
            ->unique()
            ->toArray();
        $candidateContestWorks = ContestWork::query()
            ->select('contest_works.*') // Evita conflitti se ci sono colonne con lo stesso nome
            ->join('user_works', 'contest_works.user_work_id', '=', 'user_works.id') // Unisci la tabella delle relazioni
            ->with(['userWork']) // Mantiene l'eager loading per l'utilizzo nel frontend
            ->where('contest_works.section_id', $this->contestSection->id)
            ->whereNotIn('contest_works.id', $assignedWorkIds)
            ->orderBy('user_works.user_id')
            ->orderBy('user_works.id')
            ->paginate(6);

        return [
            'unassignedAwards'      => $this->unassignedAwardsSet,
            'candidateContestWorks' => $candidateContestWorks,
        ];
    }
    // for validation
    public function rules()
    {
        return [
            'awardCode'     => ['array'],
            'awardCode.*'   => 'required|string|max:10',
            'contestWorkId' => 'required|uuid|exists:contest_works,id',
        ];
    }
    //
    public function assignAward($contestWorkId)
    {
        $this->contestWorkId = $contestWorkId;
        $validated = $this->validate();
        $selectedAwardCode = $this->awardCode[$contestWorkId] ?? null;

        $contestAward = ContestAward::where('section_id', $this->contestSection->id)
            ->where('award_code', $selectedAwardCode)
            ->firstOrFail();
        
        $contestAward->update([
            'winner_work_id' => $validated['contestWorkId']
        ]);
    
        return redirect()
            ->route('organization.contest-award.candidate', ['contestSection' => $this->contestSection])
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
            url="{{ route('organization.contest-award.listed', ['contest' => $contest, 'contestSection' => $contestSection]) }}" />
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
                            <td valign="top" class="">
                                <form wire:submit.prevent="assignAward('{{$contestWork->id}}')">
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
                            <td valign="top" class="w-full">
                                <img src="{{ asset('storage/contests') .'/'. $contestWork->contest->id .'/'. $contestWork->contestSection->id .'/'. $contestWork->id .'.'. $contestWork->userWork->file_format }}"
                                    class="max-h-[150] max-w-[150] object-contain rounded-lg shadow-md"
                                    @contextmenu.prevent
                                    alt="All rights reserved"
                                    lazy />
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="">
                                {{ __("No images") }}
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