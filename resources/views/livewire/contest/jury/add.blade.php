<?php 
/**
 * Contest (Section) Jury Add
 * 
 * Add a juror to jury set for contest section-theme
 * TODO review for circuit (bugged)
 */

use App\Models\ContestJury;
use App\Models\Country;
use App\Models\UserContact;
use App\Models\ContestSection;

?>

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('JURY LIST f/SECTION ') }} {{ $section->name_en }} 
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
                <span class="fyk text-2xl">Jury</span>
            </a>
            . .
            <a href="{{ route('contest-award-add', ['cid' => $contest->id ]); }}">
                <span class="fyk text-xl">Awards</span>
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
    </header>
    <!-- contest info -->
    <div class="mb-4">
        @if($contest->is_circuit === 'Y')
        <p class="fyk text-2xl">
            {{ __("Sorry, but that's marked as CIRCUIT, no jury required. Jury are for Contest") }}
        </p>
        @else
        <p class="fyk text-2xl">
            {{ __('Contest: ') }} {{ $contest->name_en }}
        </p>
        <p class="fyk text-xl">Country: {{ Country::countryName( $contest->country_id ) }} </p>
        <p class="small">Closing date: {{ $contest->day_2_closing->format('Y-m-d') }} </p>
        @endif
        <p class="flex-inline small py-6">
            <a href="{{ route('modify-contest', ['cid' => $contest->id ]) }}">
                [ {{ __("Back to Main Contest Card")}} ]
            </a>
            . .
            <a href="{{ route('contest-award-add', ['cid' => $contest->id ]) }}">
                [ {{ __("Go to Award List Contest Card")}} ]
            </a>
        </p>
    </div>

    <hr />
    <!-- contest section list -->
    <div class="my-4">
        <table class="data-table-container w-full">
            <thead>
                <tr>
                    <th scope="col" class="data-table-code">Section<br />Code</td>
                    <th scope="col" class="data-table-name">Section</td>
                    <th scope="col" class="data-table-actions">Juror #</td>
                </tr>
            </thead>
            <tbody>
                @foreach($contestSectionSet as $contest_section)
                <tr class="border">
                    <td scope="row"> "{{ $contest_section->code }}"<br />
                    {{ ($contest_section->under_patronage === 'Y') ? "under patronage" : "free of patronage" }}
                    </td>
                    <td valign="top">{{ $contest_section->name_en}}<br />{{ $contest_section->name_local}}</td>
                    <td valign="top">
                        {{ ContestJury::jurorCount( (string) $contest_section->id ); }}
                        <br />
                        <a href="{{ route('contest-jury-add', ['sid' => $contest_section->id] ) }}"
                        >
                            [ {{ __("Modify that jury") }} ]
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    <hr />

    <!-- Juror list for -->
    <h3 class="fyk text-2xl">
        {{ __('JURY LIST f/SECTION ') }} {{ $section->name_en }} 
    </h3>
    <div class="my-6">
        <table class="data-table-container w-full">
            <thead>
                <tr>
                    <th width="35%" scope="col" class="data-table-email"     >{{__("Juror email")}}</th>
                    <th width="20%" scope="col" class="data-table-first-name">{{__("First name")}}</th>
                    <th width="20%" scope="col" class="data-table-last-name" >{{__("Last name")}}</th>
                    <th width="15%" scope="col" class="data-table-country"   >{{__("Country")}}</th>
                    <th width="10%" scope="col" class="data-table-action"    > Action </th>
                </tr>
            </thead>
            <tbody>
                @if (count($jurySet) > 0)
                @foreach($jurySet as $juror)
                <tr class="my-4 border">
                    <td scope="row">{{ UserContact::getEmail( $juror->user_contact_id ) }}</td>
                    <td>{{ UserContact::getFirstName( $juror->user_contact_id ) }}</td>
                    <td>{{ UserContact::getLastName( $juror->user_contact_id ) }}</td>
                    <td>{{ Country::countryName( UserContact::getCountryId( $juror->user_contact_id ) ) }}</td>
                    <td>
                        {{ $juror->id }}
                    </td>
                </tr>
                @endforeach
                @endif
                <tr class="my-4 border">
                    <td colspan="5">&nbsp;</td>
                </tr>
                <!-- finally the form -->
                <form wire:submit="addContestJuror">
                    @csrf
                    <tr>
                    <td scope="row">
                        <!-- email -->
                        <div class="mb-4">
                            <label for="email"
                                class="block font-medium text-sm text-gray-700">
                                {{ __('Email') }}
                            </label>
                            <input type="email" name="email"
                                wire:model.live.debounce.500ms="email" 
                                required="required"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                            />
                            <div class="small">@error('email') {{ $message }} @enderror</div>
                        </div>
                    </td>
                    <td>
                        <!-- first name -->
                        <div class="mb-4">
                            <label for="jurorFirstName"
                                class="block font-medium text-sm text-gray-700">
                                {{ __('First name') }}
                            </label>
                            <input type="text" name="jurorFirstName"
                                wire:model.live.debounce.500ms="jurorFirstName" 
                                required="required" 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                            />
                            <div class="small">@error('jurorFirstName') {{ $message }} @enderror</div>
                        </div>
                    </td>
                    <td>
                        <!-- last name -->
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700" for="jurorLastName">
                                {{ __('Last name') }}
                            </label>
                            <input 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                type="text" name="jurorLastName"
                                wire:model.live.debounce.500ms="jurorLastName" 
                                required="required" 
                            />
                            <div class="small">@error('jurorLastName') {{ $message }} @enderror</div>
                        </div>
                    </td>
                    <td>
                        <div class="mb-4">
                            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="countryId">
                                {{ __('Country') }}
                            </label>
                            <select 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                wire:model.live="countryId"
                                name="countryId" 
                                required="required"
                                >
                                @foreach ($countries as $country)
                                <option value="{{ trim($country->id) }}" {{ ($country->id === $countryId ) ? 'selected' : '' }}>{{ $country->country }}</option>
                                @endforeach
                            </select>
                            <div class="small">@error('countryId') {{ $message }} @enderror</div>
                        </div>
                    </td>
                    <td>
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
    </div>
    <hr />
</div>
