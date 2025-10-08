
<?php
/**
 * Contest Subscribe
 * Contest Participation
 *
 * user_id from Auth::id()
 * contest_id from route()
 *
 */

use App\Models\ContestParticipant;
use Illuminate\Support\Facades\Log;

?>

<div>
    <div class="header">
        <!-- Contest info -->
        <p class="fyk text-2xl">{{__("Participate to:")}} {{$contest->name_local }}</p>
        <p class="fyk text-xl">{{__("Closing date:")}} {{$contest->day_2_closing->format("Y-m-d") }}</p>
        <!-- Contest section list w/counter -->
        @foreach($contest_section_list as $section)
        <p class="inline-flex small">[ {{$section->code}} min:{{$section->rule_min}} max:{{$section->rule_max}}]</p>
        @endforeach
        <hr />
        <!-- Contest work list w/counter -->
        <div class="fyk text-xl">{{__("Your counter:")}}
        @foreach($contest_section_list as $section)
        <p class="inline-flex small">[ {{$section->code}} your:{{ ContestParticipant::get_participant_by_section_n_user($section->id, $user_id) }} / {{$section->rule_max}}]</p>
        @endforeach
        </div>

    </div>
    <hr />
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
            @foreach($work_list as $work)
            <tr class="border my-4">
                <td scope="row" class="text-center" align="center">
                    <!-- td add leave -->
                    @if( ContestParticipant::get_participant_by_work($contest_id, $work->id) === '')
                    @livewire('contest.subscribe.add', ['data_json' => json_encode(['contest_id' => $contest->id, 'contest_section_list' => $contest_section_list, 'work_id' => $work->id ]) ])
                    @else
                    @livewire('contest.subscribe.remove', ['pid' => ContestParticipant::get_participant_by_work($contest_id, $work->id) ])
                    @endif
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
                <em>{{ __("Long side:")}}</em>
                    {{$work->long_side}}
                    <x-input-error class="small" :messages="$errors->get('long_side')" />
                <em>{{ __("Short side:")}}</em> 
                    {{$work->short_side}}
                </td>
                @endforeach
            </tr>
        </tbody>
    </table>
    @endif
</div>
