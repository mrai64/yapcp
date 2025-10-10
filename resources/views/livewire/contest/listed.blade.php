<?php
/**
 * Open Contest list
 */

// check all contest w/day_2_closing >= today
// sorted by day_2_closing, country_id, contest_name, 

use App\Models\Country;
use App\Models\Organization;

?>

<div>
    <div class="header">
        <h2 class="fyk text-2xl my-6">
            {{ __("Open Contest List") }}
        </h2>
        <p class="text-sm">
            {{ __("After U registered in platform, after U load your better works and masterpiece, ")}}
            {{ __("that's the moment to put in the green table and play your game.")}}
            {{ __("Read the Open Contest list, choice a contest at time and ")}}
            {{ __("section by section assign your work to fill the participant work list.")}}
            {{ __("All data U have already inserted in platform only once will be used")}}
            {{ __("to participate to every contest without reinsert it manually every time.")}}
            <br />
            {{ __("Enjoy!")}}
        </p>
    </div>
    @if(isset($contest_list))
    <div>
        <br />
        <hr />
        @foreach($contest_list as $contest)
        <p class="fyk text-2xl">{{ Country::country_flag( $contest->country_id ) }} | {{$contest->name_en}}</p>
        <p class="fyk text-xl">{{ __("Closing date")}}: {{$contest->day_2_closing->format('Y-m-d')}}</p>
        <p class="small">{{ __("Organized by")}}: {{ Organization::organization_name($contest->organization_id) }}</p>
        <p class="small">{{$contest->id}}</p>
        <p class="mb-4">
            <a  href="{{ route('public-participant-list', [ 'cid' => $contest->id ] ) }}" rel="noopener noreferrer">
                [ {{ __('Participation list')}} ]
            </a>
            <a  href="{{ route('participate-contest', [ 'cid' => $contest->id ] ) }}" rel="noopener noreferrer">
                [ {{ __('Participate? Great!')}} ]
            </a>
        </p>
        <hr />
        @endforeach
    </div>
    @else
    <p class="text-2xl text-center">{{ __("At today no contest are open to participate in")}}</p>
    @endif
</div>
