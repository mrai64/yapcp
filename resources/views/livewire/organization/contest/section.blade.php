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
        <h2 class="fyk text-2xl">{{$contest->country->flag_code}} | {{$contest->name_en }} </h2>
        <p class="small">
            Begin Jury: {{$contest->day_3_jury_opening->format("Y-m-d") }} 
            End   Jury: {{$contest->day_4_jury_closing->format("Y-m-d") }} 
        </p>
        <h3 class="fyk text-xl">{{ __("Section list")}}</h3>
        <ul>
            @foreach($section_set as $section_item)
            <li class="small">
                #{{ $section_item->works->count() }} {{ __(" works participants") }} | {{$section_item->code}} | {{$section_item->name_en }} 
                <br />
                <a href="{{ route('organization-contest-section-list', ['sid' => $section_item->id]) }}">
                [ {{ __("Review") }} ]
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <!-- success -->
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div> 
    @endif
    <!-- work list -->
    @foreach($work_participants_set as $work)
    @livewire('organization.contest.work', ['wid' => $work->id])
    @endforeach
</div>
