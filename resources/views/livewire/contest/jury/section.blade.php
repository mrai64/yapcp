<?php 
/**
 * CLASS: app/Livewire/Contest/Jury/Section.php
 * VIEW:  resources/views/livewire/contest/jury/section.blade.php
 * 
 * 
 */

?>

<div class="w-full border py-4">
    <span class="fyk text-2xl">{{ $contest->name_en }}<br /></span>
    <span class="small">from: {{ $contest->day_3_jury_opening->format('Y-m-d') }} upto: {{ $contest->day_4_jury_closing->format('Y-m-d') }} (format is yyyy-mm-dd)<br /></span>
    <span class="fyk text-xl">{{ $contest_section->name_en }}<br /></span>
    @if ($open)
    <a href="{{ Route('contest-jury-board', ['sid' => $contest_section->id] ) }}">
        {{ __("✅ Jury window is OPEN! 👍🏻 👎 👍🏻")}}
    </a>
    @else
    {{ __("🟥 Jury window it's CLOSED now.")}}
    @endif
</div>
