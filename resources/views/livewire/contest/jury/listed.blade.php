<?php
/**
 * CLASS: app/Livewire/Contest/Jury/Listed.php
 * VIEW:  resources/views/livewire/contest/jury/listed.blade.php
 * 
 * Section (list) > Board > Board (single) work
 */

?>

<div>
    @if (count($juries))
    <h3 class="fyk text-2xl font-medium text-gray-900">
        {{ __("Your Juror timetable Theme / sections List") }} 
    </h3>
    <ul>
    @foreach($juries as $jury)
    <li>
        @livewire('contest.jury.section', ['data_json' => json_encode(['section_it' => $jury->section_id])]) 
    </li>
    @endforeach
    </ul>
    @endif
</div>
