<div>
    <p class="mb-4">{{ __('Well, Contest record is already created.') }}<br />
     {{ __('If you interrupt compiling form, you can retrieve it in your Organization Daskboard.') }}</p>

    <p class="mb-4"> 
        <a  href="{{ route('dashboard') }}" 
            rel="noopener noreferrer">
        [ {{ __('Back to Dashboard')}} ]
        </a>?
    </p>


    <form wire:submit="save">
        @csrf

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="name_en">
                {{ __('Contest Name') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" 
                wire:model="name_en" 
                value="{{ old('name_en') }}"
                required="required" 
                />
            <div class="small">@error('name_en') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="name_local">
                {{ __('Contest Name lang') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" 
                wire:model="name_local" 
                value="{{ old('name_local') }}"
                required="required" 
                />
            <div class="small">@error('name_local') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="country_id">
                {{ __('Country') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl" 
                wire:model="country_id"
                name="country_id" 
                required="required
                >
                <option value="">{{ __('-- choose country --') }}</option>
                @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->country }}</option>
                @endforeach
            </select>
            <div class="small">@error('country_id') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="lang_local">
                {{ __('Language code (for future use)') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl" 
                wire:model="lang_local"
                name="lang_local" 
                required="required
                >
                @foreach ($lang_list as $lang_code => $lang_lang)
                <option value="{{ $lang_code }}" {{($lang_code == $lang_local) ? 'selected' : '' }} > {{ $lang_lang }}</option>
                @endforeach
            </select>
            <div class="small">{{ __('When * marked, we need help to complete i18n. Help us.')}}</div>
            <div class="small">@error('lang_local') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl" for="timezone">
                {{ __('Timezone') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="timezone"
                name="timezone" 
                required="required"
                >
                @foreach ($timezone_list as $timezone_item)
                <option value="{{ $timezone_item }}" {{ ($timezone_item == $timezone) ? 'selected' : '' }}> {{ $timezone_item }} </option>
                @endforeach
            </select>
            <div class="small">{{ __('As worldwide platform we need to manage correctly time.') }} {{ __('List is in alphabetically order A>Z') }}</div>
            <div class="small">@error('timezone') {{ $message }} @enderror</div>
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
            >{{ old('contact_info') }}</textarea>
            <div class="small">@error('contact_info') {{ $message }} @enderror</div>
        </div>

        <div class="mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700">
                {{ __('Is that a Circuit record?') }}
            </label>
            <label class="block font-medium text-sm text-gray-700">
                <input type="radio" name="is_circuit" id="" value="Y" />
                {{ __('Yes, it\'s a Circuit record') }}
            </label>
            <label class="block font-medium text-sm text-gray-700">
                <input type="radio" name="is_circuit" id="" value="N" checked />
                {{ __('No, it\'s a Contest') }}
            </label>
            <div class="small">@error('is_circuit') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="circuit_id">
                {{ __('Cut n paste Circuit uuid - chain id') }}
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
            <label class="block font-medium text-sm text-gray-700" for="url_1_rule">
                {{ __('Official Contest Rule url (with subscription link)') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="url_1_rule" 
                type="text" name="url_1_rule" 
                value="{{ old('url_1_rule') }}"
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
                wire:model="url_2_concurrent_list" 
                type="text" name="url_2_concurrent_list" 
                value="{{ old('url_2_concurrent_list') }}"
                >
            <div class="small">@error('url_2_concurrent_list') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="url_3_admit_n_award">
                {{ __('Official Contest Result List url') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="url_3_admit_n_award" 
                type="text" name="url_3_admit_n_award" 
                value="{{ old('url_3_admit_n_award') }}"
                required="required"
                >
            <div class="small">@error('url_3_admit_n_award') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="url_4_catalogue">
                {{ __('Official Contest Result List url') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="url_4_catalogue" 
                type="text" name="url_4_catalogue" 
                value="{{ old('url_4_catalogue') }}"
                >
            <div class="small">@error('url_4_catalogue') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_1_opening">
                {{ __('Date (n time) opening Contest') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day_1_opening" 
                type="datetime-local" name="day_1_opening" 
                value="{{ old('day_1_opening') }}"
                required="required"
                >
            <div class="mb-4">{{ __('Date format must be a sortable iso datetime: yyyy-mm-dd hh:mm:ss') }}</div>
            <div class="small">@error('day_1_opening') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_2_closing">
                {{ __('End of participation Contest') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day_2_closing" 
                type="datetime-local" name="day_2_closing" 
                value="{{ old('day_2_closing') }}"
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
                wire:model="day_3_jury_opening" 
                type="datetime-local" name="day_3_jury_opening" 
                value="{{ old('day_3_jury_opening') }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="small">@error('day_3_jury_opening') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_4_jury_closing">
                {{ __('End of jury works') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day_4_jury_closing" 
                type="datetime-local" name="day_4_jury_closing" 
                value="{{ old('day_4_jury_closing') }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="small">@error('day_4_jury_closing') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_5_revelations">
                {{ __('Result communication') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day_5_revelations" 
                type="datetime-local" name="day_5_revelations" 
                value="{{ old('day_5_revelations') }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="small">@error('day_5_revelations') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="day_6_awards">
                {{ __('Award ceremony date / 1 of 2') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-xl" 
                wire:model="day_6_awards" 
                type="datetime-local" name="day_6_awards" 
                value="{{ old('day_6_awards') }}"
                required="required"
                >
            <div class="mb-4">{{ __('Must be not minor of previous date') }}</div>
            <div class="small">@error('day_6_awards') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="award_ceremony_info">
                {{ __('Award\' Ceremony info / 2 of 2') }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="award_ceremony_info"
                wire:model="award_ceremony_info"
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
                wire:model="day_7_catalogues" 
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
                wire:model="day_8_closing" 
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
            {{ __('Completed') }}
        </button>

    </form>

    <p class="mb-4"> 
        <a  href="{{ route('federation-list') }}" 
            rel="noopener noreferrer">
        [ {{ __('Back to Dashboard')}} ]
        </a>?
    </p>

</div>
