<?php
/**
 * Contest Section Jury Board
 * CLASS: app/Livewire/Contest/Jury/Board.php
 * VIEW:  resources/views/livewire/contest/jury/board.blade.php
 * 
 * juror_id == Auth::id()
 * 
 */

?>

<div>
    <div class="header">
        <p class="fyk text-2xl">{{ $contest->name_en }} </p>
        <p class="fyk text-xl">{{ $contest_section->name_en }} </p>
        <p class="fyk">
            {{ __("Jury window from: ") }}
            {{ $contest->day_3_jury_opening->format('Y-m-d')}}
            {{ __(" upto: ") }}
            {{ $contest->day_4_jury_closing->format('Y-m-d')}}
        </p>
    </div>
    
    @foreach ($participant_works as $work)
    @endforeach
</div>
