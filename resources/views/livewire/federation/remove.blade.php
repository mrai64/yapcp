<div>
    <p class="mb-4 font-medium">{{ __('LAST CALL. Are you SURE to delete that?')}} </p>
    <p class="mb-4"> 
        <a  href="{{ route('federation-list') }}" 
            rel="noopener noreferrer">
        [ {{ __('Back to list') }} ]
        </a>?
    </p>
    <form wire:submit="delete" method="DELETE">
        @csrf 
        <input type="hidden" name="id" wire:model.fill="id" />

        <div>
            <label class="block font-medium text-sm text-gray-700" for="name">
                Federation Name
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="name"
                wire:model.fill="name"
                readonly
            />
        </div>
        
        <div>
            <label class="block font-medium text-sm text-gray-700" for="code">
                Federation Shortcode
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="code"
                wire:model.fill="code"
                readonly
            />
        </div>
        
        <div>
            <label class="block font-medium text-sm text-gray-700" for="website">
                {{__('Official website')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="website" 
                wire:model.fill="website"
                readonly
            >
        </div>
        <p>&nbsp;</p>
        <button type="submit" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Confirm') }} ?
        </button>

        </div>
    </form>

</div>
