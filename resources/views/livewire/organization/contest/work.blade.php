<?php
/**
 * Organization Contest Section Work Review
 * 
 * CLASS: app/Livewire/Organization/Contest/Work.php
 * VIEW:  resources/views/livewire/organization/contest/work.blade.php
 * $work = ContestWork::
 * 
 * Response ✅ 
 * work is ok for all section request, even manual check
 * - put file in contest section folder
 * - add it to ok work_validation table (Job?)
 * 
 * Response ⚠️ / 🟥
 * - pass to form 
 */

?>

<div class="w-auto block p-4 border">
    <!-- work miniature - click to see 100% -->
    <!-- user -->
    <a href="{{ asset('storage/photos').'/'.$work->work_file }}" target="blank" class="w-full h-100">
    <img src="{{ asset('storage/photos').'/'.$work->work_file }}" 
        alt="" class="block w-48 me-3" 
        style="float:left" /></a>    
    <div class="block small w-auto">
        <em>{{ __("Intl Title:")}}</em>
            {{$work->title_en}}<br />
        <em>{{ __("Local Title:")}}</em>
            {{$work->title_local}}<br />
        <em>{{ __("Author:")}}</em>
            {{$work->user_contact->country_id}} |
            {{$work->user_contact->last_name}}, 
            {{$work->user_contact->first_name}}<br />
        <em>{{ __("Reference Year:")}}</em>
            {{$work->reference_year}}
        <em>{{ __("Short side:")}}</em> 
            {{$work->short_side}}
        <em>{{ __("Long side:")}}</em>
            {{$work->long_side}}
    </div>
    <br style="clear:both;" />
    <div class="grid grid-cols-2 items-center gap-2 lg:grid-cols-3">
        <div class="flex lg:justify-start">
            <!-- OK TO GO -->
            <a href="{{ route('organization-contest-pass-next', ['wid' => $contest_work->work_id ]) }}" class="fyk text-xl">
               {{ __("✅ OK IT's IN ✅") }}
            </a>
        </div>
        <div class="flex justify-end">
            <!-- EMAIL TO AUTHOR -->
            <a href="{{ route('organization-contest-warn-email', ['wid' => $contest_work->work_id ]) }}" class="fyk text-xl">
                {{ __("⚠️ OUT 📧") }}
            </a>
        </div>
    </div>
    <br style="clear:both;" />
</div>
