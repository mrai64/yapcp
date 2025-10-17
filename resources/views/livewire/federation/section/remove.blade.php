<?php
/**
 * Federation Section Remove blade
 *
 * 2025-10-16 refactor federations federation_sections
 *
 *
 */

?>
<div>
    <header>
        <h1 class="fyk text-2xl font-medium text-gray-900">
            {{ __('LAST CALL. Are you SURE to delete that?') }}
        </h1>
        <p class="mb-4">
            <a href="{{ route( 'federation-section-list', [ 'fid' => $federation_id]) }}"
                rel="noopener noreferrer">
            [ {{ __("Back to Federation Section list") }} ]
            </a>
        </p>
    </header>

    <form wire:submit="delete_federation_section" method="DELETE">
        @csrf

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="code">
                {{ _('Section Shortcode') }}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48"
                wire:model.live.debounce.500ms="code"
                type="text" name="code"
                readonly
            />
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="name_en">
                {{ __('Section name') }}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text" name="name_en"
                wire:model.live.debounce.500ms="name_en"
                readonly
            />
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="rule_definition">
                {{ __('Section definition') }}
            </label>
            <textarea
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text" name="rule_definition"
                wire:model.live.debounce.500ms="rule_definition"
                readonly
            ></textarea>
        </div>

        <p>&nbsp;</p>
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Confirm') }} ?
        </button>

    </form>
</div>
