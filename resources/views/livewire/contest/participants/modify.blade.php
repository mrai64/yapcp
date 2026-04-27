<?php
/**
 * Contest Participants List / Modify 
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
use App\Models\ContestSection;
use App\Models\ContestWork;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

?>

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Participant List for Contest:') }}<br />
            {{ $contest->name_en }}
        </h2>
        <h3>
            <a href="{{ route('organization.contest.modify', ['contest' => $contest ]) }}">
                <span class="fyk text-xl">Main</span>
            </a>
            . .
            <a href="{{ route('organization.contest-section.add', ['contest' => $contest]) }}">
                <span class="fyk text-xl">Sections</span>
            </a>
            @php $sid = ContestSection::firstContestSectionId( $contest->id ); @endphp
            @if($sid > '')
            <a href="{{ route('organization.contest-jury.add', ['sid' => $sid] ); }}">
                <span class="fyk text-xl">Jury</span>
            </a>
            @else
            <a href="#no-section-no-jury" text='{{ __("Before, add a section")}}' alt='{{ __("No link, almost a section before")}}'>
                <span class="fyk text-xl">Jury</span>
            </a>
            @endif
            . .
            <a href="{{ route('organization.contest-award.add', ['contest' => $contest]) }}">
                <span class="fyk text-xl">Awards</span>
            </a>
            . .
            <a href="{{ route('contest-participant.modify', ['cid' => $contest->id ]); }}">
                <span class="fyk text-2xl">Participants</span>
            </a>
            . .
            <span class="fyk text-xl">Works</span>
        </h3>
    </header>
    @if (count($participantSet) < 1)
    <div class="my-4">
        <h3 class="fyk text-2xl">
            <a href="{{ route('user.contest.participate', ['contest' => $contest]) }}"></a>
                [ {{ __("Wanna become the first?") }} ]
            </a>
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
            @foreach($participantSet as $participant)
                <tr class="border py-2">
                    <td scope="row" class="fyk text-xl">
                        {{ Country::countryFlag($participant->contact->country_id) }}
                        {{ $participant->contact->country_id }}
                    </td>
                    <td class="fyk text-2xl">
                        {{ $participant->contact->last_name }}, {{ $participant->contact->first_name }}
                    </td>
                    <td>
                        @php
                            $userCanEditThisRow = $isManager || (Auth::check() && Auth::id() === $participant->user_id);
                        @endphp
                        @if(!$participant->fee_payment_completed)
                            @if($userCanEditThisRow)
                                @livewire('contest.participants.complete',  ['dataJson' => json_encode(['contestId' => $contest->id, 'participantId' => $participant->user_id, 'feePaymentCompleted' => $participant->fee_payment_completed ? 'Y' : 'N' ] ) ] )
                            @else
                                {{ __("🟨 Waiting payment receipt") }}
                            @endif
                        @else
                            @if($userCanEditThisRow)
                                @livewire('contest.participants.remove',  ['dataJson' => json_encode(['contestId' => $contest->id, 'participantId' => $participant->user_id, 'feePaymentCompleted' => $participant->fee_payment_completed ? 'Y' : 'N' ] ) ] )
                            @else
                                {{ __("✅ Completed") }}
                            @endif
                        @endif
                    </td>
                    <td class="small kbd" nowrap>
                        <!-- works of max works -->
                        @foreach($contestSectionSet as $section)
                        [{{$section->code}}: {{ $workCounts[$participant->user_id][$section->id] ?? 0 }} / {{$section->rule_max}}] 
                        &nbsp;
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <p class="small">
        {{ __("-- End of list--") }}
    </p>
</div>
