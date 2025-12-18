<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=yanone-kaffeesatz:400" rel="stylesheet" />

        <link rel="stylesheet" href="https://yapcp.test/build/assets/app-RYhd1Ag3.css" data-navigate-track="reload"/>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            <!-- Page Content -->
            <main>
<div>
    <h2 class="fyk text-2xl"><strong>Minute draft</strong></h2>
    <p class="small">BELOW Cut n paste on word-like app</p>
    <br /><br />
    <hr />
    <!-- header: contest data -->
    {{ __("Today, ")}}{{ $today_extended }} ,<br>
    {{ __("for the contest named:")}}<br />
    <div class="fyk text-2xl font-medium">
        {{$contest->name_en}},
    </div>

    <!-- header: organizer infos -->
    organized by 
    {{$organization->country->flag_code}} 
    {{$organization->name}}, <br />

    these ladies an gentleman are     gathered as a jury to examine:
    <hr />
    <br />
    <!-- section list w/ numbers -->
    @foreach($sections as $section)
        <div class="small">Jury for: <strong>{{$section->name_en}} {{$section->code}}</strong></div>
        <ul>
            @foreach($jury_members[$section->code] as $juror)
            <li>
                {{$juror->flag_code}}
                {{$juror->country_id}} | 
                {{$juror->last_name}}
                {{$juror->first_name}}
            </li>
            @endforeach
        </ul>
        to examine 
        {{$works_participants_all[$section->code]}} 
        works from 
        {{$authors_participant_all[$section->code]}}
        authors <br />
        had admitted 
        <strong>
            {{$works_admitted[$section->code]}} 
            works from 
            {{$authors_admitted[$section->code]}}
            authors <br />
        </strong>
        and assign these prizes:<br />
        <ul>
            @foreach ($awards[$section->code] as $award)
            <li>
                <!-- {{$award->award_code}} -->
                <strong>{{$award->award_name}} <br /></strong>
                {{$award->flag_code}} {{$award->country_id}} | 
                {{$award->last_name}} 
                {{$award->first_name}} with work named: <br />
                {{$award->title_en}} <br /><br />
            </li>
            @endforeach
        </ul>

        <hr />
        <br />
    @endforeach

    <br />
    and for the contest <br />
    <div class="fyk text-2xl font-medium">
        {{$contest->name_en}},
    </div>
        <ul>
            @foreach ($contest_awards as $award)
            <li class="fyk text-2xl font-medium">
                <!-- {{$award->award_code}} -->
                <strong>{{$award->award_name}} <br /></strong>
                
                @if (@$award->flag_code > '')
                    {{$award->flag_code}} 
                    {{$award->last_name}} 
                    {{$award->first_name}}
                    {{$award->title_en}}
                @else
                    {{$award->winner_name}} 
                @endif
                <br />
            </li>
            @endforeach
        </ul>

        <hr />
        <br />
    <div class="fyk text-2xl font-medium">
        {{ __("Juror signs")}},
    </div>
    @foreach ($juror_signs as $juror => $v)
    <div class="fyk text-2xl font-medium w-full border md-rounded m-4 p-2">
        {{$juror}}
    </div>
    <p class="small">&nbsp;</p>
    @endforeach
    <hr /><br />
    <p class="small">ABOVE Cut n paste, on word-like app</p>
    <br /><br />
</div>
            </main>
        </div>
    </body>
</html>
