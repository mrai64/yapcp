<?php
/**
 * User Role Federation Add
 * 
 * 2025-10-16 federations now manage hasOne w/countries, more elegant code.
 *            For the same result, not to fix an error.
 */

?>

<div>
    <header>
        <h2 style="font-size:3rem;" class="fyk mb-4">{{ __('So, U are ... of ...?') }}</h2>
    </header>

    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div> 
    @else 
    <p class="small">{{__("Unlock platform feature based on your Federation Role")}}</p>
    @endif
    <br style="clear:both;" />
    <a  href="{{ route('dashboard') }}" 
        class="float-end font-medium rounded-md mb-4 py-2" >
        [ {{ __('Back to dashboard') }} ]
    </a>
    <br style="clear:both;" />

    <form wire:submit="saveUserRole">
        @csrf
        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl" for="role">
                {{ __('Role') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="role"
                name="role" 
                required="required"
                >
                @foreach ($rolesSet as $role_item)
                <option value="{{ $role_item }}" {{ ($role_item == $role) ? 'selected' : '' }}> {{ $role_item }} </option>
                @endforeach
            </select>
            <div class="small">{{ __("If your role is missing tell us which is to add it in role list.") }}</div>
            <div class="small">@error('role') {{ $message }} @enderror</div>
        </div>


        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl" for="federation">
                {{ __('Federation') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="federationId"
                name="federationId" 
                required="required"
                >
                @foreach ($federationList as $fed)
                <option value="{{ $fed->id }}" {{ ($fed->id == $federationId) ? 'selected' : '' }}> {{ $fed->country->flag_code }} {{ $fed->id }} | {{ $fed->name_en }}</option>
                @endforeach
            </select>
            <div class="small">
                {{ __("federation are listed in name order.") }}
                {{ __("All org, not only your' country org.") }}
            </div>
            <div class="small">@error('federation') {{ $message }} @enderror</div>
        </div>

        {{-- role_opening from date --}} 
        {{-- role_closing to date   --}} 

        <hr />
        <button type="submit" 
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Well, add that role to my personal infos') }}
        </button>

    </form>
</div>
