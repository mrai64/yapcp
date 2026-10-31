<?php
/**
 * contest live - assign awards
 * navigation header with all section code and counters
 */ 
?>
<div class="header">
    <h2 class="fyk text-2xl">
        {{ $contest->country->flag_code.' | '.$contest->name_en }}
    </h2>
    @foreach($contest_award_assigned as $award_section)
    <div class="p-4 inline-block w-auto">
        {{ $award_section->code }}: {{ $award_section->assigned_awards }} of {{ $award_section->total_awards }}
    </div>
    @endforeach
</div>
