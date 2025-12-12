<?php 
/**
 * SET Admit for a Contest Section 
 * 
 * Reserved for organization members 
 * 
 */
?>

<div>
    <!-- contest header -->
    <div class="header mb-4">
        <div class="fyk text-2xl">{{ $contest->country->flag_code }} | {{$contest->name_en}}</div>
        <div class="small">Few contest info</div>
        <hr />
        <div class="p-4 border rounded-md">
            [ 
                <a href="{{route('contest-live-dashboard', ['cid' => $contest->id ])}}">
                    {{__("Back to contest live panel")}} 
                </a>
            ]
        </div>
        <br />
        <h3 class="fyk text-2xl"><strong>{{__("Contest SET ADMIT")}}</strong></h3>
        <br />
        <div class="mb-4">
            {{ __("In that page as Contest Organizer you insert") }}
            {{ __("the minimum sum vote to rise admit in contest, valid.") }}
        </div>
    </div>

    <!-- success -->
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div>
    @endif

    <!-- list of votes --> 
    <div class="my-4 font-semibold">
    <table class="data-table-container w-auto m-auto">
        <thead>
            <tr class="border rounded-md mt-4 mb-4">
                <th scope="col" class="data-table-sumvote">{{ __("Vote received") }}&nbsp;&nbsp;</td>
                <th scope="col" class="data-table-percent">{{ __("% voted works") }}&nbsp;&nbsp;</td>
                <th scope="col" class="data-table-actions">{{ __("Action") }}</td>
            </tr>
        </thead>
        <tbody>
            @foreach($vote_assigned_board as $vote_item)
            <tr class="border rounded-md mt-4 mb-4">
                <td scope="row" align="right">
                    {{ $vote_item->voted_sum }}&nbsp;&nbsp;
                </td>
                <td align="right">
                    {{ sprintf('%3.2f', ($vote_item->admission_percent / 100) ) }} %&nbsp;&nbsp;
                </td>
                <td>
                <form wire:submit="setAdminFromValue({{$vote_item->voted_sum}})">
                    <x-secondary-button type="submit">
                        &nbsp;&nbsp; 🔼 {{ __("ADMIT FROM HERE") }}  🔼
                    </x-primary-button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
