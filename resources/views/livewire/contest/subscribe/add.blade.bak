<?php
/**
 * add a work in a contest/section
 * - userWorkId
 * - contest_id > contestSectionSet
 * arr_participant > insert in contest_participants
 *
 */

?>
<form wire:submit.prevent="addUserWorkToContest">
    @csrf

    <input name="userWorkId" wire:model="userWorkId" type="hidden"
        value="{{$userWorkId}}" readonly />
    <div>
        <select name="sectionId" wire:model.defer="sectionId"
            required="required"
            class="inline-flex items-center border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block px-4 py-2 mt-4 w-auto max-w-7xl"
            >
            <option value="">--</option>
            @foreach($contestSectionSet as $section)
            <option value="{{$section->id}}">{{$section->code}}</option>
            @endforeach
        </select>
        <!-- portfolio sequence -->
        <input type="number" 
            name="portfolioSequence" wire:model.defer="portfolioSequence" 
            min="0" max="255"
            class="inline-flex items-center border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2 mt-4 w-12"
            />

    </div>

    @foreach ($errors->all() as $message)
    <div class="small">{{$message}}</div>
    @endforeach

    <button type="submit"
        class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
        >
        {{ __('Add') }}
    </button>
</form>
