<?php
/**
 * Organization Contest Section Work Review Pass 
 * 
 * CLASS: app/Livewire/Organization/Contest/PassNext.php
 * VIEW:  resources/views/livewire/organization/contest/pass-next.blade.php
 * 
 */

?>

<div>
    <a href="{{ route('organization-contest.review.section-list', ['contest-section' => $contest_section]) }}">
        [ {{ __("All right, back n Refresh list")}} ]
    </a>
</div>
