<?php
/**
 * Contest Participants Modify 
 * 
 * Here we can change (only, if) the fee_payment_completed field
 * First parte mount/render is for build the list of participants
 * Second part validate/update is only for one record in the list.
 * 
 * First use of gates.
 * 
 */

use App\Models\Country;
use App\Models\ContestParticipant;
use App\Models\ContestWork;
use Illuminate\Support\Facades\Gate;

?>

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Participant List for Contest:') }}<br />
            {{ $contest->name_en }}
        </h2>
    </header>
    @if (count($participant_list) < 1)
    <div>
        <h3 class="fyk text-2xl">{{ __("Waitin', but 🏁 you should be the first") }}</h3>
    </div>
    @else
    <div class="my-4">
        <table class="data-table-container w-full">
            <thead>
                <tr>
                    <th scope="col" class="data-table-country">From</td>
                    <th scope="col" class="data-table-name">Surname, Name</td>
                    <th scope="col" class="data-table-actions">Fee status</td>
                    <th scope="col" class="data-table-actions">Work participation</td>
                </tr>
            </thead>
            <tbody>
            @foreach($participant_list as $key => $participant)
                <tr class="border py-2">
                    <td scope="row" class="fyk text-xl">
                        {{ Country::country_flag($participant['country_id']) }}
                        {{ $participant['country_id'] }}
                    </td>
                    <td class="fyk text-2xl">
                        {{ $participant['last_name'] }}, {{ $participant['first_name'] }}
                    </td>
                    <td>
                        @if( ($participant['fee_payment_completed'] === 'N') )
                            @can('contest-participants-update', ContestParticipant::where('user_id', $participant['user_id'])->get()[0] )
                                @livewire('contest.participants.complete',  ['data_json' => json_encode(['contest_id' => $contest->id, 'participant_id' => $participant['user_id'], 'fee_payment_completed' => $participant['fee_payment_completed'] ] ) ] );
                            @endcan
                            @cannot('contest-participants-update', ContestParticipant::where('user_id', $participant['user_id'])->get()[0] )
                                {{ __("🟨 Waiting payment receipt") }}
                            @endcan
                        @else
                            @can('contest-participants-update', ContestParticipant::where('user_id', $participant['user_id'])->get()[0] )
                                @livewire('contest.participants.remove',  ['data_json' => json_encode(['contest_id' => $contest->id, 'participant_id' => $participant['user_id'], 'fee_payment_completed' => $participant['fee_payment_completed'] ] ) ] );
                            @endcan
                            @cannot('contest-participants-update', ContestParticipant::where('user_id', $participant['user_id'])->get()[0] )
                                {{ __("✅ Completed") }}
                            @endcan
                        @endif
                    </td>
                    <td class="small kbd" nowrap>
                        @foreach($contest_section_list as $section)
                        [{{$section->code}}: {{ ContestWork::count_works_for_section_user($section->id, $participant['user_id']) }} / {{$section->rule_max}}] 
                        &nbsp;
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="small">{{__("-- End of list--")}}</div>
    @endif
</div>
