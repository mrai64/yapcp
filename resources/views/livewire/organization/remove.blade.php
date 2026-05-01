<?php 

/**
 * User remove Organization
 *
 * @see /app/Livewire/Organization/Remove.php
 *
 */

?>

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Remove Organization') }}
        </h2>
        <hr />
        <br />
        <p class="small text-red-600">
            ⚠️ {{ __("Cancel only organization that are double in Organization list and added to platform with no suspended action.")}}
        </p>
        <p class="fyk text-xl font-medium mb-4">
            <a href="{{ route('organization.list') }}">
                [ {{__('Organization list')}} ]
            </a>
        </p>
    </header>

    <form wire:submit="deleteOrganization" method="DELETE">
        @csrf

        <input type="hidden" name="id" wire:model.fill="id" />

        <div class="mb-4">
            <label  for="country_id"
                class="block mt-4 font-medium text-sm text-gray-700">
                {{ __('Country') }}
                | {{ __("readonly")}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="website" 
                wire:model.fill="country"
                readonly
            >
        </div>
        
        <div>
            <label for="name"
                class="block mt-4 font-medium text-sm text-gray-700">
                {{__('name')}}
                | {{ __("readonly")}}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text" name="name"
                wire:model.fill="name"
                readonly
                />
        </div>

        <div>
            <label for="email"
                class="block mt-4 font-medium text-sm text-gray-700">
                {{__('email')}}
                | {{ __("readonly")}}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="email" name="email"
                wire:model.fill="email"
                readonly
                />
        </div>

        <div>
            <label for="website"
                class="block mt-4 font-medium text-sm text-gray-700">
                {{__('website')}}
                | {{ __("readonly")}}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="url" name="website"
                wire:model.fill="website"
                readonly
                />
        </div>

        <br />
        <hr />
        <br />

        <p class="small text-red-600">
            ⚠️ {{ __("Cancel only organization that are double in Organization list and added to platform with no suspended action.")}}
        </p>

        <button type="submit"
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Confirm') }} ?
        </button>
    </form>
</div>
