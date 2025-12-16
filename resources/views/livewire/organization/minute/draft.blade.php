<div class="fmono">
    <h2 class="fyk text-2xl"><strong>Minute draft</strong></h2>
    <p class="small">Cut n paste on word-like app</p>
    <hr />
    <!-- header: contest data -->
    {{ __("Today, ")}}
    {{ $today_extended }} ,<br>
    {{ __("for the contest named:")}}<br />
    <div class="fyk text-2xl font-medium">
        {{$contest->name_en}},
    </div>
    <!-- header: organizer infos -->
    organized by ..., 

    these ladies an gentleman are     gathered as a jury to examine:
    <hr />
    <br />
    <!-- section list w/ numbers -->
    @foreach($sections as $section)
        <div class="small">for: <strong>{{$section->name_en}} {{$section->code}}</strong></div>
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
                {{$award->award_code}} 
                {{$award->award_name}} <br />
                {{$award->flag_code}} 
                {{$award->last_name}} 
                {{$award->first_name}} with work named: <br />
                {{$award->title_en}} <br /><br />
            </li>
            @endforeach
        </ul>

        <hr />
        <br />
    @endforeach
    ...
    ...

    <hr /><br />
    {{ json_encode($jury_members)}}
    <hr />
    {{ json_encode($sections)}}
    <hr />
    {{ json_encode($contest)}}
    <hr />
</div>
