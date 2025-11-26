<?php
/**
 * Contest Section Jury Board
 * 
 * work in vote list
 * CLASS: app/Livewire/Contest/Jury/Board.php
 * VIEW:  resources/views/livewire/contest/jury/board.blade.php
 * 
 * juror_id == Auth::id()
 * 
 * Section (list) > Board (list) > Board (single) Work > Jury Vote
 * 
 * 2025-11-02 add counter voted / total 
 * 2025-11-18 dias now has its livewire component ...lazy
 * and paginated 
 */

use Illuminate\Support\Facades\Log;

?>

<div>
    <div class="header">
        <p class="fyk text-2xl">{{ $contest->name_en         }} </p>
        <p class="fyk text-xl" >{{ $contestSections->name_en }} </p>
        <p class="fyk">
            {{ __("Jury window from: ") }}
            {{ $contest->day_3_jury_opening->format('Y-m-d') }}
            {{ __(" upto: ") }}
            {{ $contest->day_4_jury_closing->format('Y-m-d') }}
            | {{ __("Vote Status for that section: ") }}
            [ {{ $votedCounter }} voted over all {{ $participantsCounter }} ]
        </p>
    </div>

    @if (count($participantWorks) > 0)
    <h2 class="fyk text-2xl">{{ __("These (and more...) Are Waiting Your Vote") }} 
        <a href="{{ route('contest-jury-vote', ['sid' => $contestSections->id ]) }}">
        [ {{ __("Start") }} ]
        </a>
    </h2>
        <!-- set of un - voted -->
        @foreach ($participantWorks as $k => $imgdias)
        <livewire:contest.jury.dias :imgdias="$imgdias"  lazy />

        @endforeach
    <br style="clear:both;" />
    <hr />
    @else
    <h2 class="fyk text-2xl">
        {{ __("All Voted Now") }} 
    </h2>
    <br style="clear:both;" />
    <hr />
    @endif

    @if (count($votedWorks) > 0)
    <!-- set of voted -->
    <h2 class="fyk text-2xl">
        {{ __("Already voted (but you can change it) ") . $votedCounter . ' / ' . $participantsCounter }}
    </h2>

        @foreach ($votedWorks as $vid)
        <livewire:contest.jury.voteddias :vid="($vid->id)"  lazy />

        @endforeach
    <br style="clear:both;" />
    <div class="paginationDiv">
        {{ $votedWorks->links() }}
    </div>


    @else 
    <p class="fyk text-2xl">
        &hellip;<br />
        &hellip; 
        <a href="{{ route('contest-jury-vote', ['sid' => $contestSections->id ]) }}">
            {{ __("Why Wait? Start Vote NOW!") }}
        </a>
    </p>
    @endif
    @php 
    Log::info('Blade completed ' . __FILE__ );
    @endphp 
</div>
