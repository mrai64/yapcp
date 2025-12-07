<?php
/**
 * Header for contest pages
 * require a section_id to recover contest_id
 * then ...
 * 
 * Incremental Nav header for pages of building
 * contest main, section, jury, etc.
 *
 */

// contest_id

?>

<div class="header mb-4">
    <h2 class="fyk text-xl">{{$section->contest->country->flag_code}} | {{$section->contest->name_en }} </h2>
    <p class="small">
        Begin Jury: {{$section->contest->day_3_jury_opening->format("Y-m-d") }}
        End   Jury: {{$section->contest->day_4_jury_closing->format("Y-m-d") }}
    </p>
    <h3 class="fyk text-2xl"><strong> {{ __("Section list")}}</strong></h3>
    <ul >
        @foreach( $section->contest->sections as $section_item)
        <li class="small border p-1" style="width:48%;">
            {{$section_item->code}} {{$section_item->name_en }} __ #{{ $section_item->works->count() }} {{ __(" works") }}
            __ <a href="{{ route('organization-contest-section-list', ['sid' => $section_item->id])}}"> [ {{ __("Review") }} ] </a>
            __ <a href="{{ route('contest-before-final-jury', ['sid' => $section_item->id ]) }}"> [ {{ __("General Vote Board") }} ] </a>
        </li>
        @endforeach
    </ul>
</div>
