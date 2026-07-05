@props(['fld', 'head' => '', 'value' => ''])

<div class="mb-4">
    @if($head)
        <label class="block fyk font-medium text-lg text-gray-700 mb-1" for="{{ $fld }}">
            {{ $head }}
        </label>
    @endif

    <label class="flex items-center space-x-2 cursor-pointer w-fit">
        <input type="checkbox" 
            {{ $attributes->whereDoesntStartWith('class') }} 
            id="{{ $fld }}"
            name="{{ $fld }}"
            wire:model="{{ $fld }}"
            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 {{ $attributes->get('class') }}"
        >
        <span class="fyk text-lg text-gray-700 px-2">
            {{ $value ?? $slot }}
        </span>
    </label>
</div>