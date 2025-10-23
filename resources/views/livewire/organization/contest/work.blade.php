<?php
/**
 * Organization Contest Section Work Review
 * 
 * CLASS: app/Livewire/Organization/Contest/Work.php
 * VIEW:  resources/views/livewire/organization/contest/work.blade.php
 * $work = ContestWork::
 * 
 */

?>

<div class="w-auto block p-4">
    <!-- work miniature to click to see 100% -->
    <!-- user -->
    <img src="{{ asset('storage/photos').'/'.$work->work_file }}" 
        alt="" class="block w-48 mx-3" 
        style="float:left" /">    
    <div class="block small w-auto">
        <em>{{ __("Intl Title:")}}</em>
            {{$work->title_en}}<br />
        <em>{{ __("Local Title:")}}</em>
            {{$work->title_local}}<br />
        <em>{{ __("Reference Year:")}}</em>
            {{$work->reference_year}}
        <em>{{ __("Short side:")}}</em> 
            {{$work->short_side}}
        <em>{{ __("Long side:")}}</em>
            {{$work->long_side}}
    </div>
    <br style="clear:both;" />
</div>
