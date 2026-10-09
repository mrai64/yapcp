<?php
/**
 * Organization Contest Section Work Review Warn Email
 * 
 * CLASS: app/Livewire/Organization/Contest/WarnEmail.php
 * VIEW:  resources/views/livewire/organization/contest/warn-email.blade.php
 * 
 */

?>

<div>
    <div class="small">
        {{ _("Be patient an kind. You are informing an AUTHOR that him/her work IS NOT GOOD.")}}
        {{ _("First, it could be an inadvertent mistake. Second, there may be time to fix it. Almost always.")}}
    </div>
    <form wire:submit="register_n_send">
        @csrf

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="because">
                {{ __("Dear Author, we are sorry to inform you that") }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="because"
                wire:model="because"
            >{{ old('because') }}</textarea>
            <div class="small">@error('because') {{ $message }} @enderror</div>
        </div>

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Check three times, AND count to TEN. Then SEND') }}
        </button>
    </form>
</div>
