<?php
/**
 * Contest Main Modify
 */

use App\Models\ContestSection;

?>

<div>
    <!-- contest modify -->
    <header>
        <h2 class="fyk text-2xl">
            {{ __('Contest Main Form') }}
        </h2>
        <h3>
            <a href="{{ route('modify-contest', ['cid' => $contest->id ]) }}">
                <span class="fyk text-2xl">Main</span>
            </a>
            . .
            <a href="{{ route('contest-section-add', ['cid' => $contest->id]) }}">
                <span class="fyk text-xl">Sections</span>
            </a>
            . .
            <a href="{{ route('contest-jury-add', ['sid' => ContestSection::first_section_id( $contest->id )] ); }}">
                <span class="fyk text-xl">Jury</span>
            </a>
            . .
            <a href="{{ route('contest-award-add', ['cid' => $contest->id ]); }}">
                <span class="fyk text-xl">Awards</span>
            </a>
            . .
            <span class="fyk text-xl">Participants</span>
            . .
            <span class="fyk text-xl">Works</span>
        </h3>
    </header>

    <hr />
    
    <p class="mb-4">{{ __('Well, Contest record is already created.') }}<br />
        {{ __('If you interrupt compiling form, you can retrieve it in your Organization Daskboard.') }}
    </p>
    <p class="mb-4">
        {{ __('After that contest general definition, next step are: section list, jury definition, prize list definition.') }}
    </p>    
    <p class="mb-4"> 
        <a  href="/dashboard" rel="noopener noreferrer">
        [ {{ __('Back to Personal Dashboard')}} ]
        </a>
        <a  href="{{ route('organization-dashboard', [ 'id' => $organization_id ]) }}" rel="noopener noreferrer">
        [ {{ __('Back to organization Dashboard')}} ]
        </a>
    </p>

    <hr />

    <form wire:submit="update_contest_main" class="mt-6 space-y-6">
        @csrf

        <div class="mb-4">
            <x-input-label for="name_en" :value="__('Contest Name')" />
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text"
                wire:model.live.debounce.500ms="name_en"
                value="{{ old('name_en') }}"
                {{ (true) ? 'required' : 'readonly' }}
                autofocus />
            <x-input-error class="small" :messages="$errors->get('name_en')" />
        </div>

        <div class="mb-4">
            <x-input-label for="name_local" :value="__('Contest Name Local Lang')" />
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text"
                wire:model.live.debounce.500ms="name_local"
                value="{{ old('name_local') }}"
                {{ (true) ? '' : 'readonly' }}
                />
            <x-input-error class="small" :messages="$errors->get('name_local')" />
        </div>

        <div class="mb-4">
            <x-input-label for="country_id" :value="__('Country')" />
            <select
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl"
                wire:model.live.debounce.500ms="country_id"
                name="country_id"
                {{ (true) ? 'required' : 'readonly' }}
                >
                @foreach ($countries as $country)
                <option value="{{ $country->id }}"
                {{ ($country_id == $country_id) ? 'selected' : '' }}
                >{{ $country->country }}</option>
                @endforeach
            </select>
            <x-input-error class="small" :messages="$errors->get('country_id')" />
        </div>

        <div class="mb-4">
            <x-input-label for="lang_local" :value="__('Language code (for future use)')" />
            <select
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl"
                wire:model.live.debounce.500ms="lang_local"
                name="lang_local"
                {{ (true) ? 'required' : 'readonly' }}
                >
                @foreach ($lang_list as $lang_code => $lang_lang)
                <option value="{{ $lang_code }}" {{($lang_code == $lang_local) ? 'selected' : '' }} > {{ $lang_lang }}</option>
                @endforeach
            </select>
            <div class="small">{{ __('When * marked, we need help to complete i18n. Help us.')}}</div>
            <x-input-error class="small" :messages="$errors->get('lang_local')" />
        </div>

        <div class="mb-4">
            <x-input-label for="timezone" :value="__('Timezone')" />
            <select
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl"
                wire:model.live.debounce.500ms="timezone"
                name="timezone"
                {{ (true) ? 'required' : 'readonly' }}
                >
                @foreach ($timezone_list as $timezone_item)
                <option value="{{ $timezone_item }}" {{ ($timezone_item == $timezone) ? 'selected' : '' }}> {{ $timezone_item }} </option>
                @endforeach
            </select>
            <div class="small">{{ __('When * marked, we need help to complete i18n. Help us.')}}</div>
            <x-input-error class="small" :messages="$errors->get('timezone')" />
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="contact_info">
                {{ __('Chairman contact') }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="contact_info"
                wire:model.live.debounce.500ms="contact_info"
            >{{ old('contact_info') }}</textarea>
            <div class="small">@error('contact_info') {{ $message }} @enderror</div>
        </div>

        <div class="mt-4 mb-4">
            <!-- TODO when circuit_id became a select remove the exposing of id -->
            <label class="block font-medium text-sm text-gray-700">
                {{ __("Circuit or Contest") }}
            </label>
            <label class="block font-medium text-sm text-gray-700">
                <input type="radio" name="is_circuit" id="" value="N" checked />
                {{ __("That's a CONTEST") }}
            </label>
            <label class="block font-medium text-sm text-gray-700">
                <input type="radio" name="is_circuit" id="" value="Y" />
                {{ __("That's a CIRCUIT record, then copy that as circuit id: ") }} {{$id}}
                {{ __("Otherwise ignore it.")}}
            </label>
            <x-input-error class="small" :messages="$errors->get('is_circuit')" />
        </div>

        <div class="mb-4">
            <!-- TODO replace w/select -->
            <label class="block font-medium text-sm text-gray-700" for="circuit_id">
                {{ __('Circuit id') }}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text"
                wire:model.live.debounce.500ms="circuit_id"
                value="{{ old('circuit_id') }}"
                {{ (true) ? '' : 'readonly' }}
                />
            <div class="small">{{ _("For contest-in-circuit paste here previously copied circuit id.") }}</div>
            <x-input-error class="small" :messages="$errors->get('circuit_id')" />
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="federation_list">
                {{ __('Patronage / Sponsor Federation List') }}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text"
                wire:model.live.debounce.500ms="federation_list"
                value="{{ old('federation_list') }}"
                {{ (true) ? '' : 'readonly' }}
                />
            <div class="small">{{ __("Insert comma separate federation codes.") }}</div>
            <x-input-error class="small" :messages="$errors->get('federation_list')" />
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="url_1_rule">
                {{ __('Official Contest Rule url (with subscription link)') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model.live.debounce.500ms="url_1_rule" 
                type="text" name="url_1_rule" 
                required="required"
                >
            <div class="small">@error('url_1_rule') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="url_2_concurrent_list">
                {{ __('Official Contest Participant List url') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model.live.debounce.500ms="url_2_concurrent_list" 
                type="text" name="url_2_concurrent_list" 
                value="{{ old('url_2_concurrent_list') }}"
                >
            <div class="small">@error('url_2_concurrent_list') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="url_3_admit_n_award_list">
                {{ __('Official Contest Result List url') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model.live.debounce.500ms="url_3_admit_n_award_list" 
                type="text" name="url_3_admit_n_award_list" 
                value="{{ old('url_3_admit_n_award_list') }}"
                required="required"
                >
            <div class="small">@error('url_3_admit_n_award_list') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="url_4_catalogue">
                {{ __('Official Contest Catalogues url') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model.live.debounce.500ms="url_4_catalogue" 
                type="text" name="url_4_catalogue" 
                value="{{ old('url_4_catalogue') }}"
                >
            <div class="small">@error('url_4_catalogue') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="fee_info">
                {{ __('Participation Fee info') }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="fee_info"
                wire:model.live.debounce.500ms="fee_info"
            >{{ old('fee_info') }}</textarea>
            <div class="small">{{ __('Only for info, and replied in Rules pdf. Even for free fee.') }}</div>
            <div class="small">@error('fee_info') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_1_opening">
                {{ __('Date (n time) opening Contest') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model.live.debounce.500ms="day_1_opening" 
                type="datetime-local" name="day_1_opening" 
                required="required"
                >
            <div class="small">@error('day_1_opening') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_2_closing">
                {{ __('End of participation Contest') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model.live.debounce.500ms="day_2_closing" 
                type="datetime-local" name="day_2_closing" 
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="small">@error('day_2_closing') {{ $message }} @enderror</div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_3_jury_opening">
                {{ __('Begin of jury works') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model.live.debounce.500ms="day_3_jury_opening" 
                type="datetime-local" name="day_3_jury_opening" 
                value="{{ old('day_3_jury_opening') }}"
                required="required"
                >
            <div class="small">@error('day_3_jury_opening') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_4_jury_closing">
                {{ __('End of jury works') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model.live.debounce.500ms="day_4_jury_closing" 
                type="datetime-local" name="day_4_jury_closing" 
                value="{{ old('day_4_jury_closing') }}"
                required="required"
                >
            <div class="small">@error('day_4_jury_closing') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_5_revelations">
                {{ __('Result communication') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model.live.debounce.500ms="day_5_revelations" 
                type="datetime-local" name="day_5_revelations" 
                value="{{ old('day_5_revelations') }}"
                required="required"
                >
            <div class="small">@error('day_5_revelations') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_6_awards">
                {{ __("Award' Ceremony 1 Date") }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model.live.debounce.500ms="day_6_awards" 
                type="datetime-local" name="day_6_awards" 
                value="{{ old('day_6_awards') }}"
                required="required"
                >
            <div class="small">@error('day_6_awards') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="award_ceremony_info">
                {{ __("Award' Ceremony 2 location info") }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="award_ceremony_info"
                wire:model.live.debounce.500ms="award_ceremony_info"
                required="required"
            >{{ old('award_ceremony_info') }}</textarea>
            <div class="small">Location, date and time and/or Broadcast platform </div>
            <div class="small">@error('award_ceremony_info') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_7_catalogues">
                {{ __('Catalogue publication, printed or online') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model.live.debounce.500ms="day_7_catalogues" 
                type="datetime-local" name="day_7_catalogues" 
                value="{{ old('day_7_catalogues') }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="small">@error('day_7_catalogues') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_8_closing">
                {{ __('Deadline for award postal send to awarded') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model.live.debounce.500ms="day_8_closing" 
                type="datetime-local" name="day_8_closing" 
                value="{{ old('day_8_closing') }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="small">@error('day_8_closing') {{ $message }} @enderror</div>
        </div>

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Completed, NEXT') }}
        </button>

    </form>

    <p class="mb-4"> 
        <a  href="/dashboard" rel="noopener noreferrer">
        [ {{ __('Back to Personal Dashboard')}} ]
        </a>
        <a  href="{{ route('organization-dashboard', [ 'id' => $organization_id ]) }}" rel="noopener noreferrer">
        [ {{ __('Back to organization Dashboard')}} ]
        </a>
    </p>

</div>
