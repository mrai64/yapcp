<?php
/**
 * Juror Vote modification 
 * CLASS: app/Livewire/Contest/Jury/VoteMod.php
 * VIEW:  resources/views/livewire/contest/jury/vote-mod.blade.php
 * 
 * Change vote +1 -1 in vote_rule scale
 * 
 */

?>

<div style="justify-content:center;">
    <!-- success -->
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div>
    @endif

    <div style="width:80%;height:80%;display:block;margin:0 auto;background-color:#f0f0f0;">
        <a href="route('contest-jury-board', ['sid' => $vote->section_id ])">
            [ {{ __("Back to Board")}} ]
        </a>
        <div style="max-width:90%;max-height:90%;background-color:#f0f0f0;border:10px solid #ccc;display:flex;justify-content: center;align-items: center;box-shadow: 0 0 10px rgba(0,0,0,0.2);">
            <img src="{{ asset('storage/contests') .'/'. $vote->contest_id .'/'. $vote->section_id .'/'. $vote->work_id .'.'. $vote->work->extension }}"
            style="max-width:80%;max-height:80%;object-fit:contain;border-radius:.5rem;"
            />
        </div>
        <div style="max-width:90%;margin:0 auto;">
            <button wire:click="change_that_vote('down')"
                class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
                >
                {{ __('⬇️ Down 1') }}
            </button>

            &nbsp;|&nbsp;

            <button wire:click="change_that_vote('up')"
                class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
                >
                {{ __('Up 1 ⬆️') }}
            </button>

        </div>
    </div>
</div>
