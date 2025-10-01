<?php
/**
 * Contest Section Add
 */

use App\Models\Country;
use App\Models\ContestSection;

?>

<section>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Contest definition: SECTION LIST') }}
        </h2>
        <h3>
            <a href="{{ route('modify-contest', ['cid' => $contest->id ]) }}">
                <span class="fyk text-xl">Main</span>
            </a>
            . .
            <a href="{{ route('contest-section-add', ['cid' => $contest->id]) }}">
                <span class="fyk text-2xl">Sections</span>
            </a>
            @if (ContestSection::first_section_id( $contest->id ) > '')
            <a href="{{ route('contest-jury-add', ['sid' => ContestSection::first_section_id( $contest->id ) ] ) }}">
                <span class="fyk text-xl">Jury</span>
            </a>
            @else
            <a href="#no-section-no-jury" text='{{ __("Before, add a section")}}' alt='{{ __("No link, almost a section before")}}'>
                <span class="fyk text-xl">Jury</span>
            </a>
            @endif
            . .
            <a href="{{ route('contest-award-add', ['cid' => $contest->id ]); }}">
                <span class="fyk text-xl">Awards</span>
            </a>
            . .
            <span class="fyk text-xl">Participants</span>
            . .
            <span class="fyk text-xl">Works</span>
        </h3>
        @if ($contest->is_circuit === 'Y')
        <p class="small">
            {{ __("You have marked main record as Circuit. Sections defined here will be next replied on every contest in circuit") }}
        </p>
        @else
        <p class="small pb-4">
            {{ __("Here we resume few data from main Contest card, list section already inserted and a form to insert new Section data.") }}
        </p>
        @endif
    </header>

    <!-- contest -->
    <div class="mb-4">
        <p class="fyk text-2xl">
            {{ ($contest->is_circuit === 'Y') ? 'Circuit: ' : 'Contest: '; }}
            {{ $contest->name_en }}
        </p>
        <p class="fyk text-xl">Country: {{ Country::country_name( $contest->country_id ) }} </p>
        <p class="small">Closing date: {{ $contest->day_2_closing->format('Y-m-d') }} </p>
        <p class="small py-6">
            <a href="{{ route('modify-contest', ['cid' => $contest->id ]) }}">
                [ {{ __("Back to Main Contest Card")}} ]
            </a>
        </p>
    </div>

    <hr />

    <!-- section -->
    <div class="my-4">
        <table class="data-table-container w-full">
            <thead>
                <tr>
                    <th scope="col" class="data-table-code">Section<br />Code</td>
                    <th scope="col" class="data-table-name">Section</td>
                    <th scope="col" class="data-table-actions">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($contest_section_list) > 0 )
                    @foreach($contest_section_list as $section)
                <tr class="border">
                    <td scope="row"> "{{ $section->code }}"<br />
                    {{ ($section->under_patronage === 'Y') ? "under patronage" : "free of patronage" }}</td>
                    <td >{{ $section->name_en}}<br />{{ $section->name_local}}</td>
                    <td >
                        <a href="{{ route('modify-contest-section', ['sid' => $section->id] ) }}">
                            [ {{ __("Modify") }} ]
                        </a>
                        <a href="{{ route('remove-contest-section', ['sid' => $section->id] ) }}">
                            [ {{ __("Remove") }} ]
                        </a>
                    </td>
                </tr>
                    @endforeach
                @else
                <tr class="border">
                    <td scope="row" colspan="3">
                        <p class="mb-6 small m-auto text-center">{{ __("Insert first contest section") }}</p>
                    </td>
                </tr>
                @endif
                <!-- Form Add section -->
                <form wire:submit="addSectionToContest">
                    @csrf
                <tr>
                    <td scope="row" valign="top" style="width:15% !important">
                        <input
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-20"
                            wire:model="code"
                            type="text" name="code"
                            value="{{ old('code') }}"
                        />
                        <x-input-error class="small" :messages="$errors->get('code')" />
                        <br style="clear:both;" />
                        <div>
                            <label class="block font-medium text-sm text-gray-700">
                                <input type="radio" name="under_patronage" id="under_patronage" value="N" 
                                wire:model="under_patronage" 
                                {{ ( old('under_patronage') == "N") ? 'checked' : ''}}
                                />
                                {{ __("Free of patronage") }}
                            </label>
                            <label class="block font-medium text-sm text-gray-700">
                                <input type="radio" name="under_patronage" id="under_patronage" value="Y" 
                                wire:model="under_patronage" 
                                {{ ( old('under_patronage') == "Y" ) ? 'checked' : '';}}
                                />
                                {{ __("Follow patronage rules") }}
                            </label>
                            <x-input-error class="small" :messages="$errors->get('under_patronage')" />
                        </div>
                    </td>
                    <td valign="top" class="w-full" style="width:75% !important"
                        <label for="name_en" class="block font-medium text-sm text-gray-700">
                            {{ __("Section description [en]") }}
                        </label>
                        <input
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                            wire:model="name_en"
                            type="text" name="name_en"
                            value="{{ old('name_en') }}"
                        />
                        <x-input-error class="small" :messages="$errors->get('name_en')" />
                        <hr style="clear:both;" />
                        <label for="name_local" class="block font-medium text-sm text-gray-700">
                            {{ __("Section description [local]") }}
                        </label>
                        <input
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                            wire:model="name_local"
                            type="text" name="name_local"
                            value="{{ old('name_local') }}"
                        />
                        <x-input-error class="small" :messages="$errors->get('name_local')" />
                    </td>
                    <td valign="top" nowrap>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
                        >
                        {{ __('Add') }}
                        </button>
                    </td>
                </tr>
                </form>
            </tbody>
        </table>
        <br />
        <p class="small">
            {{ __("Assign a unique code to every section, and remember to see if you are under sponsor / patronage") }}
            {{ __("use code valid for your sponsor.") }}
        </p>
    </div>

</section>
