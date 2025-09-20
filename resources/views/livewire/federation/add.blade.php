<div>
    <p class="mb-4">{{ __('Well, New Federation? Insert few data here.') }}</p>
    <p class="mb-4">
        <a  href="{{ route('federation-list') }}"
            rel="noopener noreferrer">
        [ {{ __('Back to list') }} ]
        </a>?
    </p>
    <form wire:submit="save">
        @csrf

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="name">
                {{ __('Federation Name') }}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text"
                wire:model="name"
                value="{{ old('name') }}"
                required="required"
                />
            @error('name')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="code">
                {{ __('Federation Shortcode')}}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48"
                wire:model="code" type="text" name="code"
                value="{{ old('code') }}"
                required="required"
                />
            <div class="small">@error('code') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="website">
                {{ __('Official website') }}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                wire:model="website"
                type="text" name="website"
                value="{{ old('website') }}"
                >
            <div class="small">@error('website') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="country_id">
                {{ __('Country') }}
            </label>
            <select
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
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
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="contact">
                {{ __('Federation Contacts') }}
            </label>
            <textarea
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text" name="contact"
                wire:model="contact"
            >{{ old('contact') }}</textarea>
            <div class="small">@error('contact') {{ $message }} @enderror</div>
        </div>

        <button type="submit"
            class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Add') }}
        </button>

        </div>
    </form>
</div>
