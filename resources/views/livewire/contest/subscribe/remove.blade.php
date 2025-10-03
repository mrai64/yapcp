<?php 
/**
 * delete a work from contest / section participating list 
 */

?>

<div class="text-center">
    [ {{ $section_code }} ]
    <br />
    <form wire:submit="delete" method="DELETE">
        @csrf
        <!-- participant id: {{ $participant_id }} -->
        <button type="submit"
            class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Leave') }}
        </button>
    </form>
</div>
