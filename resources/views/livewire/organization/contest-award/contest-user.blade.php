<?php

/**
 * Organization Contest Manage / list of admit...
 *
 * used in organization.contest-award-contest
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
    //
    use WithPagination;
    public Contest      $contest;
    public Organization $organization;
    public              $unassignedAwards;
    public              $awardedParticipants;
    public array  $awardCode          = [];
    public string $userContactId      = '';
    public string $awardedUserContact = ''; // fake form field
    //
    // first
    public function mount(Contest $contest)
    {
        $this->contest             = $contest;
        $this->organization        = $this->contest->organization;
        //
        $userIdsDirect = ContestAward::where('contest_id', $contest->id)
            ->whereNotNull('winner_user_id')
            ->pluck('winner_user_id');
        //
        $userIdsViaWork = ContestAward::where('contest_id', $contest->id)
            ->whereNotNull('winner_work_id')
            ->with('contestWork')
            ->get()
            ->pluck('contestWork.user_id')
            ->filter();

        $allUserIds = $userIdsDirect->merge($userIdsViaWork)->unique();

        $userContacts = UserContact::whereIn('id', $allUserIds)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $this->awardedParticipants = $userContacts;

        $this->unassignedAwards = ContestAward::query()
            ->where('contest_id', $this->contest->id)
            ->whereNull('section_id')
            ->whereNull('winner_work_id')
            ->whereNull('winner_user_id')
            ->where('winner_name', '')
            ->orderBy('award_code')
            ->get();

    }
    // for validation
    public function rules()
    {
        // ! check is a user_id in userIdsDirect
        return [
            'awardedUserContact' => 'required|uuid|exists:user_contacts,id',
        ];
    }
    //
    public function assignUserId(string $userContactId)
    {
        $this->userContactId = $userContactId;
        $validated = $this->validate();
        $selectedAwardCode = $this->awardCode[$userContactId] ?? null;
        $contestAward = ContestAward::whereNull('section_id')
            ->where('award_code', $selectedAwardCode)
            ->firstOrFail();

        $contestAward->update([
            'winner_user_id' => $validated['awardedUserContact'],
        ]);

        return redirect()
            ->route('organization.contest-award.contest', ['contest' => $this->contest])
            ->with('success', __("Update the Award page"));
    }
}; ?>

<div>
    <!-- no page -->
    <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
        {{ __("Assign by User Awarded") }}
    </h3>
    <table class="data-table-container w-full">
        <thead>
            <th>{{ __("Assign")}}</th>
            <th>{{ __("Work")}}</th>
        </thead>
        <tbody>
            @forelse ($awardedParticipants as $awardedUserContact)
            <form wire:submit.prevent="assignUserId('{{$awardedUserContact->id}}')">
            <tr class="border">
                <td valign="top" class="px-2">
                    <select
                        class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full'
                        id="awardCode"
                        name="awardCode"
                        wire:model="awardCode.{{$awardedUserContact->id}}"
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
                    {{$awardedUserContact->country->flag_code}}
                    {{$awardedUserContact->country->country}}
                    <br />
                    {{$awardedUserContact->last_name}},
                    {{$awardedUserContact->first_name}}
                    {{__("from")}}
                    {{$awardedUserContact->city}}
                </td>
            </tr>
            </form>
                    @empty
                
            @endforelse
        </tbody>
    </table>


</div>
