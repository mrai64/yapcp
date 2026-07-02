<?php

/**
 * Organization Contest Design / Contest Awards
 */

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestAwards;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    public Contest         $contest;
    public Organization    $organization;
    public $contestAwardsSet;
    //
    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $contest->organization;

        $contestAwardsSet = ContestAward::where('contest_id', $this->contest->id)
            ->orderBy('section_id', 'asc')
            ->orderBy('is_award', 'desc')
            ->orderBy('section_code', 'asc')
            ->get();

            $this->contestAwardsSet = $contestAwardsSet->groupBy(function ($item){
                return $item->section_code ?? '..';
            })
            ->toArray();
    }

}; ?>

<div>
    <h3 class="fyk text-2xl font-medium text-gray-900">
        {{ __("Awards") }}
    </h3>
    @foreach ($contestAwardsSet as $section => $prizeSet)
    <div class="my-4 border ">
        <h4 class="fyk text-2xl mb-4">
            {{ ($section == '..') ? __("Contest Awards") : __("Section Code: :code", ['code' => $section])}}
        </h4>
        <ul>
        @foreach ($prizeSet as $contestAward)
        <li class="font-mono">
            {{ $contestAward['is_award'] ? '🏆' : '📜' }}
            {{ $contestAward['award_code'] }} 
            {{ $contestAward['award_name'] }}
        </li>
        @endforeach
        </ul>
    </div>
    <div class="text-xl">&nbsp;</div>
    @endforeach
</div>
