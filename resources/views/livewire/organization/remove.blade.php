<div>
    <p class="mb-4 font-medium">{{ __('LAST CALL. Are you SURE to delete that?')}} </p>
    <p class="mb-4">
        <a  href="{{ route('organization-list') }}"
            rel="noopener noreferrer">
        [ {{ __('Back to list') }} ]
        </a>?
    </p>
    <form wire:submit="delete" method="DELETE">
        @csrf

        <input type="hidden" name="id" wire:model.fill="id" />

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="country_id">
                {{ __('Country') }}
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
                class="block mt-4 font-medium text-sm text-gray-700"
                >
                {{__('name')}}
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
                class="block mt-4 font-medium text-sm text-gray-700"
                >
                {{__('email')}}
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
                class="block mt-4 font-medium text-sm text-gray-700"
                >
                {{__('website')}}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="url" name="website"
                wire:model.fill="website"
                readonly
                />
        </div>

        <hr />

        <button type="submit"
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Confirm') }} ?
        </button>
    </form>
</div>
