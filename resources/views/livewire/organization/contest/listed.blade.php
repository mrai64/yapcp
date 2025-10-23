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
 * First task: give contest info, section list, then the blade
 * for 
 */
?>

<div>
    <div class="header">
        <h2 class="fyk text-2xl">{{$contest->country->flag_code }} | {{ $contest->name_en}}</h2>
        <p class="small">
            Begin Jury: {{$contest->day_3_jury_opening->format("Y-m-d") }} 
            End   Jury: {{$contest->day_4_jury_closing->format("Y-m-d") }} 
        </p>
        <h3 class="fyk text-xl">{{ __("Section list")}}</h3>
        <ul>
            @foreach( $contest->sections as $section)
            <li class="small">
                #{{ $section->works->count() }} {{ __(" works participants") }} | {{$section->code}} | {{$section->name_en }} <br />
                <a href="{{ route('organization-contest-section-list', ['sid' => $section->id]) }}">
                [ {{ __("Review") }} ]</a> <br /> <br />
            </li>
            @endforeach
        </ul>
    </div>
</div>
