<x-app-layout>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Add few Federation infos') }}
        </h2>
        <p class="mb-4">
            <a  href="{{ route('federation-list') }}"
                rel="noopener noreferrer">
            [ {{ __('Back to Fed list') }} ]
            </a>
        </p>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <form action="{{ route('federation-store' )}}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="federationName">
                {{ __('Federation Name [en]') }}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text" name="federationName"
                value="{{ old('federationName') }}"
                required="required"
                />
            @error('federationName')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div><!-- federationName -->

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="federationId">
                {{ __('Federation Shortcode')}}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48"
                type="text" name="federationId"
                value="{{ old('federationId') }}"
                required="required"
                />
            <div class="small">@error('federationId') {{ $message }} @enderror</div>
        </div><!-- federationId -->

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="website">
                {{ __('Official website') }}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text" name="website"
                value="{{ old('website') }}"
                >
            <div class="small">@error('website') {{ $message }} @enderror</div>
        </div><!-- website -->

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="countryId">
                {{ __('Country') }}
            </label>
            <select
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                name="countryId"
                required="required"
                >
                <option value="">{{ __('-- choose country --') }}</option>
                @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->country }}</option>
                @endforeach
            </select>
            <div class="small">@error('countryId') {{ $message }} @enderror</div>
        </div><!-- countryId -->

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="contactInfo">
                {{ __('Federation Contacts') }}
            </label>
            <textarea
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text" name="contactInfo"
            >{{ old('contact') }}</textarea>
            <div class="small">@error('contactInfo') {{ $message }} @enderror</div>
        </div><!-- contactInfo -->

        <button type="submit"
            class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Add') }}
        </button>

    </form>
    </div>
</x-app-layout>
