@props(['all_countries' => null, 'country_id' => null])

@php
    // Se non vengono passati i paesi, li carichiamo internamente.
    // Assicurati di includere 'id' per il valore della select.
    $allCountriesSet = $all_countries ?? \App\Models\Country::orderBy('country')->get(['id', 'country', 'flag_code']);
@endphp

<div class="mb-4">
    <x-input-label for="countryId" :value="__('Nation, Country')" />
    <select 
        {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full']) }}
        id="countryId"
        name="countryId"
        required >

        <option value="">{{ __("...") }}</option>
        @foreach ($allCountriesSet as $country)
            <option value="{{ $country->id }}" {{ $country->id == $country_id ? 'selected' : '' }}>
                {{ $country->flag_code }} {{ $country->country }}
            </option>
        @endforeach

    </select>
    <x-input-error for="countryId" class="mt-2" />
</div>
