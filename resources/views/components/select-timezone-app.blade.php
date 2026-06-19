@props(['all_timezones' => null, 'timezone_id' => null])

@php
    // Se non vengono passati i fusi orari, li carichiamo internamente.
    $allTimezonesSet = $all_timezones ?? \App\Models\Timezone::orderBy('id')->get(['id']);
@endphp

<div class="mb-4">
    <x-input-label for="timezoneId" :value="__('Timezone')" />
    <select
        {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full']) }}
        id="timezoneId"
        name="timezoneId"
        required>

        <option value="">{{ __('...') }}</option>
        @foreach ($allTimezonesSet as $timezone)
            <option value="{{ $timezone->id }}" {{ $timezone->id == $timezone_id ? 'selected' : '' }}>
                {{ $timezone->id }}
            </option>
        @endforeach
    </select>
    <x-input-error for="timezoneId" class="mt-2" />
</div>