<?php
/**
 * Contest Section - Work List - for Organization
 * CLASS: app/Livewire/Organization/Contest/Section.php
 * VIEW:  resources/views/livewire/organization/contest/section.blade.php
 *
 * Contest $contest
 * Work    $user_works_set
 */

?>

<div>
    <div class="header mb-4">
        <h2 class="fyk text-2xl">{{$section->contest->country->flag_code}} | {{$section->contest->name_en }} </h2>
        <p class="small">
            Begin Jury: {{$section->contest->day_3_jury_opening->format("Y-m-d") }} 
            End   Jury: {{$section->contest->day_4_jury_closing->format("Y-m-d") }} 
        </p>
        <h3 class="fyk text-xl">{{ __("Section list")}}</h3>
        <ul>
            @foreach( $section->contest->sections as $section_item)
            <li class="small border inline-flex p-4" style="32%">
                #{{ $section_item->works->count() }} {{ __(" works participants") }} | {{$section_item->code}} | {{$section_item->name_en }} <br />
                <a href="{{ route('organization-contest-section-list', ['sid' => $section_item->id]) }}">
                [ {{ __("Review") }} ]</a>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- success -->
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div>
    @endif

    <!-- pagination nav rule --> 
    <br />
    <div class="paginationDiv">
        {{ $userWorksSet->links() }}
    </div>

    <!-- list of participant works in no sorted order -->
    @foreach($userWorksSet as $work)
    <div class="w-auto block p-4 border">
        <!-- image -->
        <a href="{{ asset('storage/photos').'/'.$work->work_file }}" 
            target="_blank" class="w-full h-100" 
            title='{{ __("Click to view single image") }}' 
            >
            <img src="{{ asset('storage/photos').'/'. $work->work_file }}" 
                title="click to view full size" 
                class="block w-48 me-3" 
                loading="lazy"
                style="float:left" />
        </a>    
        <!-- image infos -->
        <div class="block small w-auto px-6">
            <em>{{ __("Intl Title:")}}</em>      {{$work->title_en}}<br />
            <em>{{ __("Local Title:")}}</em>     {{$work->title_local}}<br />
            <em>{{ __("Reference Year:")}}</em>  {{$work->reference_year}}
            <em>{{ __("Short side:")}}</em>      {{$work->short_side}}
            <em>{{ __("Long side:")}}</em>       {{$work->long_side}}
        </div>
        <br style="clear:both;" />
        
        <div class="grid grid-cols-2 items-center gap-2 lg:grid-cols-3">
            <div class="flex lg:justify-start">
                <!-- OK TO GO -->
                <a href="{{ route('organization-contest-pass-next', ['wid' => $work->id ]) }}" class="fyk text-xl">
                {{ __("✅ OK IT's IN ✅") }}
                </a>
            </div>
            <div class="flex justify-end">
                <!-- EMAIL TO AUTHOR -->
                <a href="{{ route('organization-contest-warn-email', ['wid' => $work->id ]) }}" class="fyk text-xl">
                    {{ __("⚠️ OUT 📧") }}
                </a>
            </div>
        </div>
        <br style="clear:both;" />
    </div>
    @endforeach

    <!-- pagination nav rule --> 
    <div class="paginationDiv">
        {{ $userWorksSet->links() }}
    </div>
</div>
