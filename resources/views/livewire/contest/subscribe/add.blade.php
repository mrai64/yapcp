<?php
/**
 * add a work in a contest/section
 * - work_id
 * - contest_id > contest_section_list
 * arr_participant > insert in contest_participants
 */


?>
<form wire:submit.prevent="add_work_to_contest">
    @csrf

    <input name="work_id" wire:model="work_id" type="hidden" 
        value="{{$work_id}}" readonly />
    <div>
        <select name="section_id" wire:model.defer="section_id"
            required="required"
            class="inline-flex items-center border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block px-4 py-2 mt-4 w-auto max-w-7xl"
            >
            @foreach($contest_section_list as $section)
            <option value="{{$section->id}}">{{$section->code}}</option>
            @endforeach
        </select>
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
