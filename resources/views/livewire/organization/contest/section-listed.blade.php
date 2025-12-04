<?php
/**
 * Contest participant works, Organization view 
 * 
 * That component will help organization to check works
 * participants before jury works begin. There are some
 * check automatically due, other are demanded to human
 * eyes and knowledge. 
 * 
 * For every work should be launched to participant an email
 * warning that one of the works seems don't compliant all 
 * contest requirement. Maybe coloured picture against monochromatic
 * requirement; or the presence of a signature / mark that explain author.
 * 
 * First task: give contest info, section list, then the blade for 
 * resource views livewire organization contest listed
 * 
 * Second task: page for contest sections
 * resource views livewire organization contest section
 * 
 * Third task: page for work in contest section
 * resource views livewire organization contest work
 * 
 * 
 */
?>

<div>
    <div class="header">
        <h2 class="fyk text-2xl">{{$contest->country->flag_code }} | {{ $contest->name_en}}</h2>
        <p class="small">
            Begin Jury: {{$contest->day_3_jury_opening->format("Y-m-d") }} 
            End   Jury: {{$contest->day_4_jury_closing->format("Y-m-d") }} 
            <br />
            <br />
        </p>        
    </div>
    <div>
        <h3 class="fyk text-2xl mb-4">{{ __("Contest Live Sections list")}}</h3>
        <ul>
            @foreach( $contest->sections as $section)
            <li class="small border rounded-md mb-4 px-4 py-2">
                <span class="fyk text-2xl">{{$section->code}}|{{$section->name_en }} </span><br />
                #{{ $section->works->count() }} {{ __(" works participants") }} <br />
                {{ __("Before Jury works: ")}}
                <a href="{{ route('organization-contest-section-list', ['sid' => $section->id]) }}">
                    [ {{ __("Section works Review: OK | Warn") }} ]
                </a> 
                <br />
                {{ __("During and after Jury Works: ")}}
                <a href="{{ route('contest-section-board', ['sid' => $section->id]) }}" target="_blank">
                    [ {{ __("Contest Section Jury Vote Board")}} ]
                </a>
                <br />
                <br />
                <br />
            </li>
            @endforeach
        </ul>
    </div>
</div>
