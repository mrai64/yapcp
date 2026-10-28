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
    public              $unassignedAwardsSet;
    public              $awardedParticipants;
    public array  $awardCode     = [];
    public string $contestWorkId = '';
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

        $this->unassignedAwardsSet = ContestAward::query()
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
            'winnerUser' => 'required|uuid|exists:user_contacts,id',
        ];
    }
}; ?>

<div>
    <!-- no page -->
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
            <form wire:submit.prevent="assignWorkId('{{$contestWork->id}}')">
            <tr class="border">
                <td valign="top" class="px-2">
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
                    </td>
                    <td valign="top" class="px-4 w-full">
                        <!-- select user id -->

                    </td>
                </tr>
            </form>
        </tbody>
    </table>


</div>
