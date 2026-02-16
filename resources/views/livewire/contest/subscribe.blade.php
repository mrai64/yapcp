
<?php
/**
 * Contest Work Subscribe / add
 * Contest Participation
 *
 * user_id from Auth::id()
 * contest_id from route()
 *
 * 2025-10-21 add portfolio_sequence to ContestWork model
 */

use App\Models\ContestWork;
use App\Models\ContestSection;
use Illuminate\Support\Facades\Log;

?>

<div>
    <div class="header">
        <!-- Contest info -->
        <p class="fyk text-2xl">{{__("Participate to:")}} {{$contest->name_local }}</p>
        <p class="fyk text-xl">{{__("Closing date:")}} {{$contest->day_2_closing->format("Y-m-d") }}</p>

        <!-- Contest section list w/counter -->
        @foreach($contestSectionSet as $section)
        <p class="small">[  {{$section->code}} {{($section->rule_min > 0) ? "Portfolio min:".$section->rule_min : "" }} max:{{$section->rule_max}} short_side:{{$section->rule_min_size}}  long_side:{{$section->rule_max_size}}  mono:{{($section->rule_monochromatic === 'Y') ? 'Y' : 'N' }}  raw:{{($section->rule_raw === 'Y') ? 'Y' : 'N' }}  ]</p>
        @endforeach

        <hr />

        <!-- Contest work list w/counter only -->
        <div class="fyk text-xl">{{__("Your counter:")}}
        @foreach($contestSectionSet as $section)
        <p class="inline-flex small">[ {{$section->code}} your:{{ ContestWork::sectionWorksCounter($section->id, $user_id) }} / {{$section->rule_max}}]</p>
        @endforeach
        </div>

    </div>
    <hr />
    <!-- user work -->
    @if (count($work_list) < 1)
    <div class="fyk text-xl">
        {{__("Seems you have no work uploaded to submit.")}}
        <a href="{{ route('photo-box-list') }}">
            {{ __("Upload some photos") }}
        </a>
    </div>
    @else
    <!-- table of works sorted for -->
    <table class="data-table-container w-full">
        <thead>
            <tr>
                <th scope="col" class="data-table-code">Section<br />Assign</td>
                <th scope="col" class="data-table-name">Work miniature</td>
                <th scope="col" class="data-table-actions">Work infos</td>
            </tr>
        </thead>
        <tbody>
            <!-- work in contest --> 
            <tr class="border my-4">
            @foreach($contestWorkSet as $contest_work)
            <tr class="border my-4">
                <td scope="row" class="text-center" align="center">
                    @livewire('contest.subscribe.remove', ['pid' => $contest_work->id ])
                </td>
                <td>
                    <!-- td work miniature TODO shadow img -->
                    <img src="{{ asset('storage/photos') .'/'. $contest_work->work->work_file }}"
                        style="float: left;" class="block w-48 me-3" />
                </td>
                <td>
                <!-- td work info  -->
                <em>{{ __("Intl Title:")}}</em>
                    {{$contest_work->work->title_en}}<br />
                <em>{{ __("Local Title:")}}</em>
                    {{$contest_work->work->title_local}}<br />
                <em>{{ __("Reference Year:")}}</em>
                    {{$contest_work->work->reference_year}}
                <em>{{ __("Short side:")}}</em> 
                    {{$contest_work->work->short_side}}
                <em>{{ __("Long side:")}}</em>
                    {{$contest_work->work->long_side}}
                </td>
            </tr>
            @endforeach
            </tr>
            <tr><td colspan="3"><p class="small">&nbsp;</p></td></tr>
            <!-- work eligible --> 
            @foreach($work_list as $work)
                @if( ContestWork::userWorksCounter($contest_id, $work->id) === '')
                <tr class="border my-4">
                    <td scope="row" class="text-center" align="center">
                        @livewire('contest.subscribe.add', ['data_json' => json_encode(['contest_id' => $contest->id, 'work_id' => $work->id, 'contestSectionSet' => $contestSectionSet ]) ])
                    </td>
                    <td>
                        <!-- td work miniature TODO shadow img -->
                        <img src="{{ asset('storage/photos') .'/'. $work->work_file }}"
                            style="float: left;" class="block w-48 me-3" />
                    </td>
                    <td>
                        <!-- td work info  -->
                        <em>{{ __("Intl Title:")}}</em>
                            {{$work->title_en}}<br />
                        <em>{{ __("Local Title:")}}</em>
                            {{$work->title_local}}<br />
                        <em>{{ __("Reference Year:")}}</em>
                            {{$work->reference_year}}
                        <em>{{ __("Short side:")}}</em> 
                            {{$work->short_side}}
                        <em>{{ __("Long side:")}}</em>
                            {{$work->long_side}}
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    @endif
</div>
