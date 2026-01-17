<?php
/**
 * Contest Definition - Awards Add
 * 
 */

use App\Models\Country;
use App\Models\ContestAward;
use App\Models\ContestSection;

?>

<div>
    <!-- page header -->
    <div class="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('AWARDs LIST f/CONTEST ') }} {{ $contest->name_en }}
        </h2>
        <h3>
            <a href="{{ route('modify-contest', ['cid' => $contest->id ]) }}">
                <span class="fyk text-xl">Main</span>
            </a>
            . .
            <a href="{{ route('contest-section-add', ['cid' => $contest->id]) }}">
                <span class="fyk text-xl">Sections</span>
            </a>
            . .
            <a href="{{ route('contest-jury-add', ['sid' => ContestSection::firstContestSectionId( $contest->id )] ); }}">
                <span class="fyk text-xl">Jury</span>
            </a>
            . .
            <a href="{{ route('contest-award-add', ['cid' => $contest->id ]); }}">
                <span class="fyk text-2xl">Awards</span>
            </a>
            . .
            <a href="{{ route('modify-participant-list', ['cid' => $contest->id ]); }}">
                <span class="fyk text-xl">Participants</span>
            </a>
            . .
            <a href="{{ route('organization-contest-list', ['cid' => $contest->id ]); }}">
                <span class="fyk text-xl">Works</span>
            </a>
            
        </h3>
    </div>
    <!-- contest info -->
    <div class="mb-4">
        @if($contest->is_circuit === 'Y')
        <p class="fyk text-2xl">
            {{ __("It's a Circuit, also circuit should have its Awards.") }}
        </p>
        @else
        <p class="fyk text-2xl">
            {{ ($contest->is_circuit === 'Y') ? __('Circuit: ') : __('Contest: ') }} {{ $contest->name_en }}
        </p>
        <p class="fyk text-xl">Country: {{ Country::country_name( $contest->country_id ) }} </p>
        <p class="small">Closing date: {{ $contest->day_2_closing->format('Y-m-d') }} </p>
        @endif
        <p class="small py-6">
            <a href="{{ route('modify-contest', ['cid' => $contest->id ]) }}">
                [ {{ __("Back to main Contest Definition")}} ]
            </a>
        </p>
    </div>
    <hr />
    <!-- contest sections list -->
    <div class="small">
        <table class="data-table-container w-full">
            <thead>
                <tr>
                    <th scope="col" class="data-table-section-code">{{ __("Section Code")}}</td>
                    <th scope="col" class="data-table-section-name">{{__("section name")}}</td>
                </tr>
            </thead>
            <tbody>
                @foreach($contest_section_list as $contest_list)
                <tr>
                    <td class="small">{{ $contest_list->code }}</td>
                    <td class="small">{{ $contest_list->name_en }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="my-4">
        <table class="data-table-container w-full">
            <tbody>
                <form wire:submit="add_contest_award">
                    @csrf
                <tr class="border">
                    <td class="w-48" scope="row" valign="top">
                        <!-- section code -->
                        <div class="mb-4">
                                <label for="section_code"
                                class="block font-medium text-sm text-gray-700">
                                {{ __('Section Code') }}
                            </label>
                            <input type="text" name="section_code"
                                wire:model.live.debounce.500ms="section_code"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48"
                            />
                            <div class="small">@error('section_code') {{ $message }} @enderror</div>
                        </div>
                    </td>
                    <td class="w-48" valign="top">
                        <!-- award code -->
                        <div class="mb-4">
                            <label for="award_code"
                                class="block font-medium text-sm text-gray-700">
                                {{ __('Award Code') }}
                            </label>
                            <input type="text" name="award_code"
                                wire:model.live.debounce.500ms="award_code"
                                required="required"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48"
                            />
                            <x-input-error class="small" :messages="$errors->get('award_code')" />
                            <label class="block font-medium text-sm text-gray-700">
                                <input type="radio" name="is_award" id="is_award" value="N"
                                wire:model="is_award"
                                {{ ( old('is_award') == "N") ? 'checked' : ''}}
                                />
                                {{ __("It's a Mention/Other") }}
                            </label>
                            <label class="block font-medium text-sm text-gray-700">
                                <input type="radio" name="is_award" id="" value="Y"
                                wire:model="is_award"
                                {{ ( old('is_award') == "Y" ) ? 'checked' : '';}}
                                />
                                {{ __("It's an AWARD / Prize") }}
                            </label>
                            <x-input-error class="small" :messages="$errors->get('is_award')" />
                        </div>
                    </td>
                    <td width="90%" valign="top">
                        <!-- award name -->
                        <div class="mb-4">
                            <label for="award_name"
                                class="block font-medium text-sm text-gray-700">
                                {{ __('Award Name') }}
                            </label>
                            <input type="text" name="award_name"
                                wire:model.live.debounce.500ms="award_name"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                            />
                            <div class="small">@error('award_name') {{ $message }} @enderror</div>
                        </div>
                    </td>
                    <td nowrap valign="top">
                        <label for="_alignment"
                            class="block font-medium text-sm text-gray-700">
                            &nbsp;
                        </label>
                        <!-- action -->
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
                        >
                        {{ __('Add') }}
                        </button>
                    </td>
                </tr>
            </form>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td scope="col" class="data-table-section-code strong">{{ __("Section Code")}}</td>
                <td scope="col" class="data-table-award-name strong">{{__("Award Code")}}</td>
                <td scope="col" class="data-table-name strong">{{ __("Award name")}}</td>
                <td scope="col" class="data-table-actions strong">{{ __("Action") }}</td>
            </tr>
            @foreach($contest_award_list as $contest_award)
                <tr class="border">
                    <td scope="row" valign="top">
                        {{$contest_award->section_code}}
                    </td>
                    <td valign="top">
                        {{ $contest_award->award_code}}<br />
                        {{($contest_award->is_award === 'Y') ? __("Award/prize") : __("Mention, Others")}}
                    </td>
                    <td valign="top">
                        {{ $contest_award->award_name }}
                    </td>
                    <td valign="top">
                        <a href="#">
                            [ {{ __("Modify") }} ]
                        </a>
                        <br />
                        <a href="#">
                            [ {{ __("Remove") }} ]
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr class="border">
                <td colspan="4">&nbsp;</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
