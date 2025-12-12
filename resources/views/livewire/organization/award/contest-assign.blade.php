<?php
/**
 * work in progress
 * 
 * Page after All-Section-Prizes-Assigned, that page
 * must show the contest prizes already assigned to help
 * the choice of best author, if needed.
 * Note: should be used also for circuit prizes.
 * 
 */

use App\Models\ContestSection;

?>

<div>
    <div class="header h2 fyk text-2xl">
        {{ __("Contest Award Assignment Page") }}
    </div>
    <livewire:organization.award.section-nav :cid="$contest_id" lazy />
    <hr />
    contest: 
    {{ json_encode($contest) }}
    <hr />
    all assigned: {{ $all_assigned }}
    <hr />
    award_assigned: 
    {{ json_encode($award_assigned) }}
    <hr />
    incomplete_sections: 
    {{ json_encode($incomplete_sections) }}
    <hr />
    sections: 
    {{ json_encode($sections) }}
    <hr />
    @if (count($incomplete_sections))
    <h3 class="fyk text-2xl">Complete Awards Assignment for:</h3>
        @foreach($sections as $section)
        <a href="{{ route('organization-award-section-assign', [ 'sid' => $section->id ] ) }}">
            [ {{ $section->code}} | {{ $section->name_en }} ]
        </a>
        <br />
        @endforeach

    @else
    <h2 class="fyk text-2xl font-medium py-2">
        {{ __("Contest Award assignment")}}
    </h2>
    <div class="my-4">
        <table class="data-table-container w-auto">
            <thead>
                <tr class="">
                    <th scope="col" valign="bottom" class="border md-rounded m-2 data-table-code">Award</td>
                    <th scope="col" valign="bottom" class="border md-rounded m-2 data-table-awarded">Awarded</td>
                </tr>
            </thead>
            <tbody>
            @foreach($contest_awards as $award)
                <tr>
                    <td class="border md-rounded m-2">
                        {{ $award->award_code }}<br />
                        {{ $award->award_name }}
                    </td>
                    <td class="border md-rounded m-2">
                    @if ($award->winner_work_id)
                        <livewire:organization.award.section-assigned-dia :wid="($contest_id.'/'.$section_id.'/300px_'.$award->winner_work_id.'.jpg')" lazy />
                    @elseif ($award->winner_name) 
                        <span class="fyk text-xl font-medium">
                            {{ $award->winner_name }}
                        </span>
                    @else 
                        {{ __("Unassigned, at now") }}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <div class="small">
                            {{ __("Warn: click on = Revoke")}}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Section Prizes Board -->
    <div class="my-4">
        <table class="data-table-container w-auto">
            <thead>
                <tr>
                    @foreach($contest_sections as $section_thead)
                    <th scope="col" class="border md-rounded m-2">
                        {{ $section_thead->code }}
                        {{ $section_thead->name_en }}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($contest_sections as $section_tbody)
                    <td class="border md-rounded m-2">
                        {{ $section_tbody->id }}
                        <!-- livewire lazy -->
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    @endif

</div>
