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
        <div class="fyk text-2xl">{{ $contest->country->flag_code }} | {{$contest->name_en}}</div>
        <p class="small">
            Begin Jury: {{$contest->day_3_jury_opening->format("Y-m-d") }} 
            End   Jury: {{$contest->day_4_jury_closing->format("Y-m-d") }} 
        </p>
        <hr />
        <div class="p-4 border rounded-md">
            [ 
                <a href="{{route('contest-live-dashboard', ['cid' => $contest->id ])}}">
                    {{__("Back to contest live panel")}} 
                </a>
            ]
        </div>
    </div>
    <div>
        <h3 class="fyk text-2xl mb-4">{{ __("Pre-Jury Review & During-Jury Vote")}}</h3>
        <ul>
            @foreach( $contest->sections as $section)
            <li class="small border rounded-md mb-4 px-4 py-2">
                <span class="fyk text-2xl">{{$section->code}}|{{$section->name_en }} </span><br />
                #{{ $section->works->count() }} {{ __(" works participants") }} <br />
                {{ __("Before Jury works: ")}}
                <a href="{{ route('organization-contest-section-list', ['sid' => $section->id]) }}">
                    [ {{ __("Works Review") }} ]
                </a> 
                <br />
                {{ __("During and after Jury Works: ")}}
                <a href="{{ route('contest-before-final-jury', ['sid' => $section->id]) }}" target="_blank">
                    [ {{ __("Jury Votes Board")}} ]
                </a>
                <br />
                <br />
            </li>
            @endforeach
        </ul>
    </div>
</div>
