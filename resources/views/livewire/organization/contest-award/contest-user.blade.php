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
    public              $awardedParticipants;
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
    public function with():array
    {
        $this->unassignedAwardsSet = ContestAward::query()
            ->whereNull('section_id')
            ->whereNull('winner_work_id')
            ->whereNull('winner_user_id')
            ->where('winner_name', '')
            ->orderBy('award_code')
            ->get();
        $awardedParticipants = UserContact::whereHas('contestWorks.award')
            ->paginate(6);

        return [
            'unassignedAwards'    => $this->unassignedAwardsSet,
            'awardedParticipants' => $awardedParticipants,
        ];
    }
    // for validation
    public function rules()
    {
        return [
            'winnerUser' => 'required|uuid|exists:user_contacts,id',
        ];
    }
}; ?>

<div>
    <!-- no page -->

</div>
