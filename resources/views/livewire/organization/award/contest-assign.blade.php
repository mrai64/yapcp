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
    <br />
    <br />
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
                    <th scope="col" valign="bottom" style="width:40%" class="border md-rounded m-2 data-table-code">Award</td>
                    <th scope="col" valign="bottom" style="width:60%" class="border md-rounded m-2 data-table-awarded">Awarded</td>
                </tr>
            </thead>
            <tbody>
            @foreach($contest_awards as $award)
                <tr>
                    <td class="border md-rounded m-2 text-center">
                        {{ $award->award_code }}<br />
                        {{ $award->award_name }}
                    </td>
                    <td class="border md-rounded m-2">
                    @if ($award->winner_work_id)
                        <livewire:organization.award.section-assigned-dia :wid="($contest_id.'/'.$section_id.'/300px_'.$award->winner_work_id.'.jpg')" lazy />
                    @elseif ($award->winner_user_id) 
                        <span class="fyk text-xl font-medium">
                            {{$award->flag_code}}
                            {{$award->last_name}}
                            {{$award->first_name}}
                        </span>
                    @elseif ($award->winner_name) 
                        <span class="fyk text-xl font-medium">
                            {{$award->winner_name}}
                        </span>
                    @else
                        <livewire:organization.award.contest-award-assign :ciac="$contest_id.' '.$award->award_code" lazy />
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
    <br />
    <br />
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th>Prizes Won</th>
                    <th>From</th>
                    <th>Last, First Name</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3">
                        <p class="small">
                            {{ __("WARN: That prizes won is a 'records counter', where every record value is 1. 1 for HM, 1 for Gold medal.")}}
                        </p>
                    </td>
                </tr>
                @foreach ($awarded_peoples as $winner)
                    <tr>
                        <td>{{ $winner->n_prizes }}</td>
                        <td>
                            {{ $winner->flag_code }}
                            {{ $winner->country_id }}
                        </td>
                        <td>
                            {{ $winner->last_name }}, 
                            {{ $winner->first_name }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    <br />
    <br />

    <!-- Section Prizes Board -->
    <div class="my-4">
        <table class="data-table-container w-auto">
            <thead>
                <tr>
                    @foreach($contest_sections as $sectionHead)
                    <th scope="col" class="border md-rounded m-2">
                        {{ $sectionHead->code }}
                        {{ $sectionHead->name_en }}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($contest_sections as $sectionBody)
                    <td class="border md-rounded m-2">
                        <livewire:organization.award.contest-assigned-dia :sid="$sectionBody->id" lazy />
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    @endif

</div>
