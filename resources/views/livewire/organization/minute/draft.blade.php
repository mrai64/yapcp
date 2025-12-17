<div class="fmono">
    <h2 class="fyk text-2xl"><strong>Minute draft</strong></h2>
    <p class="small">BELOW Cut n paste on word-like app</p>
    <br /><br />
    <hr />
    <!-- header: contest data -->
    {{ __("Today, ")}}
    {{ $today_extended }} ,<br>
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

    <br />
    and for the contest <br />
    <div class="fyk text-2xl font-medium">
        {{$contest->name_en}},
    </div>
        <ul>
            @foreach ($contest_awards as $award)
            <li>
                {{$award->award_code}} 
                {{$award->award_name}} <br />
                @if (@$award->flag_code > '')
                    {{$award->flag_code}} 
                    {{$award->last_name}} 
                    {{$award->first_name}}
                    {{$award->title_en}}
                @else
                    {{$award->winner_name}} 
                @endif
                <br /><br />
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
