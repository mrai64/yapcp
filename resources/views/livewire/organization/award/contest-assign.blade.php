<?php
/**
 * work in progress
 * 
 * Page after All-Section-Prizes-Assigned, that page
 * must show the contest prizes already assigned to help
 * the choice of best author, if needed.
 * Note: should be used also for circuit prizes.
 * 
 */

use App\Models\ContestSection;

?>

<div>
    <div class="header h2 fyk text-2xl">
        {{ __("Contest Award Assignment Page") }}
    </div>
    <livewire:organization.award.section-nav :cid="$contest_id" lazy />
    <hr />
    contest: 
    {{ json_encode($contest) }}
    <hr />
    all assigned: {{ $all_assigned }}
    <hr />
    award_assigned: 
    {{ json_encode($award_assigned) }}
    <hr />
    incomplete_sections: 
    {{ json_encode($incomplete_sections) }}
    <hr />
    sections: 
    {{ json_encode($sections) }}
    <hr />
    @if (count($incomplete_sections))
    <h3 class="fyk text-2xl">Complete Awards Assignment for:</h3>
        @foreach($sections as $section)
        <a href="{{ route('organization-award-section-assign', [ 'sid' => $section->id ] ) }}">
            [ {{ $section->code}} | {{ $section->name_en }} ]
        </a>
        <br />
        @endforeach
    @else
    @endif
</div>
