<?php
/**
 * CLASS: app/Livewire/Contest/Jury/Listed.php
 * VIEW:  resources/views/livewire/contest/jury/listed.blade.php
 * 
 */

?>

<div>
    <h3 class="fyk text-2xl font-medium text-gray-900">
        {{ __('Your Juror timetable ') }} 
    </h3>
    <ul>
    @foreach($juries as $jury)
    <li>
        @livewire('contest.jury.section', ['data_json' => json_encode(['section_it' => $jury->section_id])]) 
    </li>
    @endforeach
    </ul>
</div>
