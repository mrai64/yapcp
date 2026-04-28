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
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Participant works review for') }}
        </h2>
        <h3 class="fyk text-2xl">
            {{ $contest->country->flag_code }} | {{ $contest->name_en }}
        </h3>
        <p class="small monospace">
            {{ __("From contest opening ") }} {{ $contest->day_1_contest_opening->format("Y-m-d") }}
            {{ __("to contest jury opening ") }} {{ $contest->day_3_jury_opening->format("Y-m-d") }}
            {{ __("organization contest member must review all the works submitted before") }}
            {{ __("for contest section compliance conforming it or asking author some question.") }}
            {{ __("Except when a previous contest had done the same check in the same section.") }}
        </p>
        <p class="small">
            {{ __("During jury works between") }}
            {{ $contest->day_3_jury_opening->format("Y-m-d") }}
            ---
            {{ $contest->day_4_jury_closing->format("Y-m-d") }}
            {{ __("organization members can monitor the jury works.") }}
        </p>
        <hr />
        <br />
        <p class="fyk text-xl font-medium mb-4">
            <a href="{{route('contest.dashboard', ['contest' => $contest ])}}">
                [ {{ __("Back to Contest dashboard") }} ]
            </a>
        </p>
    </header>
    <div>
        <ul>
            @foreach($contest->sections as $section)
            <li class="small border rounded-md mb-4 px-4 py-2">
                <span class="fyk text-2xl">{{$section->code}}|{{$section->name_en }} </span>
                <br />
                #{{ $section->works->count() }} {{ __(" works participants") }} 
                <br />
                {{ __("Before Jury works: ") }}
                <a href="{{ route('organization-contest.review.section-list', ['contest-section' => $section]) }}">
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
