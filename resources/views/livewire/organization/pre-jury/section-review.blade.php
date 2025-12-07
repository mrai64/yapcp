<?php
/**
 * Contest Section - Work List - for Organization Review 
 * 
 * CLASS: app/Livewire/Organization/Contest/SectionBoard.php
 * VIEW:  resources/views/livewire/organization/contest/section-board.blade.php
 *
 * Not all rules are automatic-able, i.e. if you ask to search
 * sign and mark, personal signature an mark on author' works,
 * actually there is no AI to run that task. And here is the 
 * section board
 */

?>

<div>
    <!-- contest header -->
    <div class="header mb-4">
        <h2 class="fyk text-2xl">{{$section->contest->country->flag_code}} | {{$section->contest->name_en }} </h2>
        <p class="small">
            Begin Jury: {{$section->contest->day_3_jury_opening->format("Y-m-d") }} 
            End   Jury: {{$section->contest->day_4_jury_closing->format("Y-m-d") }} 
        </p>
        <h3 class="fyk text-xl">{{ __("Contest pre-jury IN / OUT")}}</h3>
        <div class="header mb-4">
            {{ __("As member of organization, in that page you check in human way")}}
            {{ __("if these works can be pass to Jury work. ")}}<br />
            {{ __("Or advice author that her/him work have a little trouble.")}}<br >
            {{ __("For every img choice Ok/IN or KO/WARN.)")}}
        </div>
        <h3 class="fyk text-xl">{{ __("Section list")}}</h3>
        <ul>
            @foreach( $section->contest->sections as $section_item)
            <li class="small border inline-flex p-4" style="width:32%;">
                #{{ $section_item->works->count() }} {{ __(" works participants") }} | {{$section_item->code}} | {{$section_item->name_en }} 
                <br />
                <a href="{{ route('organization-contest-section-list', ['sid' => $section_item->id])}}">
                    [ {{ __("Review") }} ]
                </a>
                <a href="{{ route('contest-before-final-jury', ['sid' => $section->id ]) }}">
                    [ {{ __("General Vote Board for that section") }} ]
                </a>    

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
    <div class="mb-2 mt-2 p-4 border rounded-md" style="border-width:3px;">
        <div class="block small w-full px-6">
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
            <em>{{ __("Author:")}}</em>          {{$work->country_id}} | {{$work->last_name}}, {{$work->first_name}} <br />
            <em>{{ __("Intl Title:")}}</em>      {{$work->title_en}}<br />
            <em>{{ __("Local Title:")}}</em>     {{($work->title_local) ? $work->title_local : "..." }}<br />
            <em>{{ __("Reference Year:")}}</em>  {{$work->reference_year}}
            <em>{{ __("Short side:")}}</em>      {{$work->short_side}}
            <em>{{ __("Long side:")}}</em>       {{$work->long_side}}
        </div>
        <br style="clear:both;" />

        <!-- "navigation" IN / OUT bar -->
        <nav role="navigation" aria-label="IN OUT work choice" class="flex justify-between">
            <span>
                <!--[if BLOCK]><![endif]-->
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                    <a href="{{ route('organization-contest-pass-next', ['wid' => $work->id ]) }}" class="fyk text-xl">
                    {{ __("✅ OK IT's IN ✅") }}
                    </a>
                    </span>
                <!--[if ENDBLOCK]><![endif]-->
            </span>
            <span>                
                <!--[if BLOCK]><![endif]-->                        
                <button class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                    <a href="{{ route('organization-contest-warn-email', ['wid' => $work->id ]) }}" class="fyk text-xl">
                        {{ __("⚠️ OUT 📧") }}
                    </a>
                </button>
                <!--[if ENDBLOCK]><![endif]-->
            </span>
        </nav>        
    </div>
    @endforeach
    <br />

    <!-- pagination nav rule --> 
    <div class="paginationDiv">
        {{ $userWorksSet->links() }}
    </div>
</div>
