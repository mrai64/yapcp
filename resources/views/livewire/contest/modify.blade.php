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

    <form wire:submit="updateContestMain" class="mt-6 space-y-6">
        @csrf

        <div class="mb-4">
            <x-input-label for="name_en" :value="__('Contest Name')" />
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text"
                wire:model="name_en"
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
                wire:model="name_local"
                value="{{ old('name_local') }}"
                {{ (true) ? '' : 'readonly' }}
                />
            <x-input-error class="small" :messages="$errors->get('name_local')" />
        </div>

        <div class="mb-4">
            <x-input-label for="country_id" :value="__('Country')" />
            <select
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl"
                wire:model="country_id"
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
                wire:model="lang_local"
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
                wire:model="timezone"
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
                wire:model="circuit_id"
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
                wire:model="federation_list"
                value="{{ old('federation_list') }}"
                {{ (true) ? '' : 'readonly' }}
                />
            <div class="small">{{ __("Insert comma separate federation codes.") }}</div>
            <x-input-error class="small" :messages="$errors->get('federation_list')" />
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="contact_info">
                {{ __('Chairman contact') }}
            </label>
            <textarea
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text" name="contact_info"
                wire:model="contact_info"
                {{ (true) ? 'required' : 'readonly' }}
            >{{ old('contact_info') }}</textarea>
            <x-input-error class="small" :messages="$errors->get('contact_info')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Main Contest Infos') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</div>
