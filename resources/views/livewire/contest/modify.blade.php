<div>
    <!-- contest modify -->
    <header>
        <h2 class="fyk text-2xl">
            {{ __('Contest Modify Form') }}
        </h2>
        <p class="mt-6">
            {{ __("Warning: if first opening date is today/passed, all fields become readonly.") }}
        </p>
    </header>

    <form wire:submit="updateContestMain" class="mt-6 space-y-6">
        @csrf

        <div class="mb-4">
            <x-input-label for="name_en" :value="__('Contest Name')" />
            <x-text-input wire:model="name_en" id="name_en" name="name_en" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
            {{ (true) ? 'required' : 'readonly' }} 
            autofocus />
            <x-input-error class="small" :messages="$errors->get('name_en)" />
        </div>

        <div class="mb-4">
            <x-input-label for="name_local" :value="__('Contest Name Local Lang')" />
            <x-text-input wire:model="name_local" id="name_local" name="name_local" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
            {{ (true) ? '' : 'readonly' }} 
            />
            <x-input-error class="small" :messages="$errors->get('name_local)" />
        </div>

        <div class="mb-4">
            <x-input-label for="country_id" :value="__('Country')" />
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl" 
                wire:model="country_id"
                name="country_id" 
                {{ (true) ? 'required' : 'readonly' }} 
                >
                <option value="">{{ __('-- choose country --') }}</option>
                @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->country }}</option>
                @endforeach
            </select>
            <x-input-error class="small" :messages="$errors->get('country_id)" />
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
            <x-input-error class="small" :messages="$errors->get('lang_local)" />
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
            <x-input-error class="small" :messages="$errors->get('timezone)" />
        </div>

        <div class="mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700">
                {{ __("Is that a Circuit record or a Contest record?") }}
            </label>
            <label class="block font-medium text-sm text-gray-700">
                <input type="radio" name="is_circuit" id="" value="Y" />
                {{ __("That's a CIRCUIT record, NOT of a Contest") }}
            </label>
            <label class="block font-medium text-sm text-gray-700">
                <input type="radio" name="is_circuit" id="" value="N" checked />
                {{ __("That's a CONTEST, NOT a Circuit") }}
            </label>
            <div class="small">@error('is_circuit') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="circuit_id">
                {{ __('Circuit uuid') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" 
                wire:model="circuit_id" 
                value="{{ old('circuit_id') }}"
                />
            <div class="small">@error('circuit_id') {{ $message }} @enderror</div>
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
                />
            @error('federation_list')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
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
                {{ (true) ? '' : 'readonly' }} 
            >{{ old('contact_info') }}</textarea>
            <div class="small">@error('contact_info') {{ $message }} @enderror</div>
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>

    </form>
</div>
