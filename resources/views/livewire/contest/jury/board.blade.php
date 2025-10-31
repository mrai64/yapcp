<?php
/**
 * Contest Section Jury Board
 * list
 * CLASS: app/Livewire/Contest/Jury/Board.php
 * VIEW:  resources/views/livewire/contest/jury/board.blade.php
 * 
 * juror_id == Auth::id()
 * 
 * Section (list) > Board (list) > Board (single) Work > Jury Vote
 * 
 */

?>

<div>
    <div class="header">
        <p class="fyk text-2xl">{{ $contest->name_en         }} </p>
        <p class="fyk text-xl" >{{ $contest_section->name_en }} </p>
        <p class="fyk">
            {{ __("Jury window from: ") }}
            {{ $contest->day_3_jury_opening->format('Y-m-d') }}
            {{ __(" upto: ") }}
            {{ $contest->day_4_jury_closing->format('Y-m-d') }}
        </p>
    </div>

    @if ($participant_works->count() > 0)
    <p class="fyk text-xl">{{ __("Are Waiting Your Vote") }} 
        <a href="{{ route('contest-jury-vote', ['sid' => $this->contest_section->id ]) }}">
           [ {{ __("Start") }} ]
        </a>
    </p>
        <!-- set of un - voted -->
        @foreach ($participant_works as $contest_work)
        <div style="float:left;width:300px !important;height:300px !important;background-color:#f0f0f0;border:10px solid #ccc;display:flex;justify-content: center;align-items: center;box-shadow: 0 0 10px rgba(0,0,0,0.2);margin-top:.5rem;margin-right:.5rem;">
            <img src="{{ asset('storage/contests') .'/'. $contest_work->contest_id .'/'. $contest_work->section_id .'/'. $contest_work->work_id .'.'. $contest_work->extension }}" 
            loading="lazy"
            style="max-width:80%;max-height:80%;object-fit:contain;border-radius:.5rem;" 
            />
        </div>
        @endforeach
    <br style="clear:both;" />
    @endif
        
    @if ($voted_works->count() > 0)
        <!-- set of voted -->
        <p class="fyk text-2xl">
            {{ __("Already voted (but you can change it)") }}
        </p>
        @foreach ($voted_works as $contest_work)
        <div style="float:left;width:300px;height:calc(300px + 2rem);display:block;text-center;background-color:#f0f0f0;margin-top:.5rem;margin-right:.5rem;">
            <p style="float:left;" class="fyk text-xl z-50">{{ __("Assigned vote: ") }}<span class="text-black font-semibold">{{ $contest_work->vote }}</span></p>
            <div style="width:300px !important;height:300px !important;background-color:#f0f0f0;border:10px solid #ccc;display:flex;justify-content: center;align-items: center;box-shadow: 0 0 10px rgba(0,0,0,0.2);">
                <img src="{{ asset('storage/contests') .'/'. $contest_work->contest_id .'/'. $contest_work->section_id .'/'. $contest_work->work_id .'.'. $contest_work->work->extension }}" 
                loading="lazy"
                style="max-width:80%;max-height:80%;object-fit:contain;border-radius:.5rem;" 
                />
            </div>
        </div>
        @endforeach
    <br style="clear:both;" />
    @else 
    <p class="fyk text-2xl">
        &hellip;<br />
        &hellip; 
        <a href="{{ route('contest-jury-vote', ['sid' => $this->contest_section->id ]) }}">
            {{ __("Why Wait? Start Vote NOW!") }}
        </a>
    </p>
    @endif
</div>
