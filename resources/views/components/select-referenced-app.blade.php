@props(['all_referenced' => null, 'referenced_id' => null])

@php
    // Se non vengono passate le tabelle correlate, le carichiamo internamente.
    // Assicurati di includere 'id' per il valore della select.
    $allReferencedSet = $all_referenced ?? \App\Models\FederationMoresReferencedSet::orderBy('id')->get(['id']);
@endphp

<div class="mb-4">
    <x-input-label for="fedMoreReferencedId" :value="__('referenced table')" />
    <select 
        {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full']) }}
        id="fedMoreReferencedId"
        name="fedMoreReferencedId"
        required >

        <option value="">{{ __("...") }}</option>
        @foreach ($allReferencedSet as $referenced)
            <option value="{{ $referenced->id }}" {{ $referenced->id == $referenced_id ? 'selected' : '' }}>
                {{ $referenced->id }}
            </option>
        @endforeach

    </select>
    <x-input-error for="fedMoreReferencedId" class="mt-2" />
</div>
