<?php
/**
 * Contest (Section) Award Add
 */

use App\Models\Country;
use App\Models\ContestSection;

?>

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('AWARDs LIST f/CONTEST ') }} {{ $contest->name_en }} 
        </h2>
        <h3>
            <a href="{{ route('modify-contest', ['cid' => $contest->id ]) }}">
                <span class="fyk text-xl">Main</span>
            </a>
            . .
            <a href="{{ route('contest-section-add', ['cid' => $contest->id]) }}">
                <span class="fyk text-xl">Sections</span>
            </a>
            . .
            <a href="{{ route('contest-jury-add', ['sid' => ContestSection::first_section_id( $contest->id )] ); }}">
                <span class="fyk text-xl">Jury</span>
            </a>
            . .
            <a href="{{ route('contest-award-add', ['cid' => $contest->id ]); }}">
                <span class="fyk text-2xl">Awards</span>
            </a>
            . .
            <span class="fyk text-xl">Participants</span>
            . .
            <span class="fyk text-xl">Works</span>
        </h3>
    </header>
    <!-- contest info -->
    <div class="mb-4">
        @if($contest->is_circuit === 'Y')
        <p class="fyk text-2xl">
            {{ __("It's a Circuit ans also circuit should have its Awards.") }}
        </p>
        @else
        <p class="fyk text-2xl">
            {{ ($contest->is_circuit === 'Y') ? __('Circuit: ') : __('Contest: ') }} {{ $contest->name_en }}
        </p>
        <p class="fyk text-xl">Country: {{ Country::country_name( $contest->country_id ) }} </p>
        <p class="small">Closing date: {{ $contest->day_2_closing->format('Y-m-d') }} </p>
        @endif
        <p class="small py-6">
            <a href="{{ route('modify-contest', ['cid' => $contest->id ]) }}">
                [ {{ __("Back to Main Contest Card")}} ]
            </a>
        </p>
    </div>

    <hr />
    <!-- award contest list -->
    <div class="small">
        {{ __("When the award is contest/circuit related leave the section code empty.")}}
    </div>
    <div class="my-4">
        <table class="data-table-container w-full">
            <thead>
                <tr>
                    <th scope="col" class="data-table-section-code">Section<br />Code</td>
                    <th scope="col" class="data-table-award-name">Award<br />Code</td>
                    <th scope="col" class="data-table-name">Award name</td>
                    <th scope="col" class="data-table-actions"></td>
                </tr>
            </thead>
            <tbody>
                <tr class="border">
                </tr>
            @foreach($contest_award_list as $contest_award)
                <tr class="border">
                    <td scope="row">
                        {{$contest_award->section_code}}
                    </td>
                    <td>
                        {{$contest_award->award_code}}
                    </td>
                    <td>
                        {{$contest_award->award_name}}
                    </td>
                    <td>
                        <a href="#">
                            [ {{ __("Modify") }} ]
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
