<?php
/**
 * Contest Section Work List for Organization
 * CLASS: app/Livewire/Organization/Contest/Section.php
 * VIEW:  resources/views/livewire/organization/contest/section.blade.php
 * 
 * 
 */
?>

<div>
    <div class="header">
        <h2 class="fyk text-2xl">{{$section->contest->country->flag_code}} | {{$section->contest->name_en }} </h2>
        <p class="small">
            Begin Jury: {{$section->contest->day_3_jury_opening->format("Y-m-d") }} 
            End   Jury: {{$section->contest->day_4_jury_closing->format("Y-m-d") }} 
        </p>
        <h3 class="fyk text-xl">{{ __("Section list")}}</h3>
        <ul>
            @foreach( $section->contest->sections as $section_item)
            <li class="small">
                #{{ $section_item->works->count() }} {{ __(" works participants") }} | {{$section_item->code}} | {{$section_item->name_en }} <br />
                <a href="{{ route('organization-contest-section-list', ['sid' => $section_item->id]) }}">
                [ {{ __("Review") }} ]</a> <br /> <br />
            </li>
            @endforeach
        </ul>
    </div>
    <!-- work list -->
    @foreach($section->works as $work)
    @livewire('organization.contest.work', ['wid' => $work->id])
    @endforeach
</div>
