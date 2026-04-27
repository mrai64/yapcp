<?php
/**
 * Contest live: participant board
 *
 * organization member: action button modify fee payment status
 *                      upto starting jury working day
 * admin: the same
 * others: a readonly list, absolutely no action buttons
 *
 * @see /App/Livewire/Contest/Participants/Listed.php
 *
 */

use App\Models\Country;
use App\Models\ContestWork;

?>

<div>
    <div class="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Participant List for') }}
        </h2>
        <h3 class="fyk text-2xl">
            {{ $contest->country->flag_code }} | {{ $contest->name_en }}
        </h3>
        <hr />
        <div class="p-4 border rounded-md">
            [ 
                <a href="{{route('contest.dashboard', ['contest' => $contest ])}}">
                    {{__("Back to contest live panel")}} 
                </a>
            ]
        </div>
    </div>

    @if (count($contestParticipantsSet) < 1)
    <div>
        <h3 class="fyk text-2xl">
            {{ __("Wanna become the first?") }}
        </h3>
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
            @foreach($contestParticipantsSet as $key => $participant)
                <tr class="border py-2">
                    <td scope="row" class="fyk text-xl">
                        {{ Country::countryFlag($participant['country_id']) }}
                        {{ $participant['country_id'] }}
                    </td>
                    <td class="fyk text-2xl">
                        {{ $participant['last_name'] }}, {{ $participant['first_name'] }}
                    </td>
                    <td>@if(($participant['fee_payment_completed'] === 'Y'))
                        {{ __("completed") }}
                        @else
                        <div class="alert alert-danger small">{{ __("waiting confirm") }} </div>
                        @endif
                    </td>
                    <td class="small kbd" nowrap>
                        @foreach($contestSectionsSet as $section)
                        [{{$section->code}}: {{ ContestWork::sectionWorksCounter($section->id, $participant['user_id']) }} / {{$section->rule_max}}] 
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