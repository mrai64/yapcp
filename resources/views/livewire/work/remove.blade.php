<div>
    <!-- That page is accessibile after login so your id is'n necessary in that form 4 load works --> 
    <h2 style="font-size:3rem;" class="fyk mb-4">{{ __('Are you sure? Remove that Work?') }}</h2>

    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div> 
    @endif

    <br style="clear:both;" />
    <a  href="{{ route('photo-box-list') }}" 
        class="float-end font-medium rounded-md mb-4 py-2"
        >
        [ {{ __('Your beautiful Gallery') }} ]
    </a>

    <hr />
    <br style="clear:both;" />

    <form wire:submit="delete" method="DELETE">
        @csrf

        <!-- work_id -->
        <!-- user_id -->

        <!-- work readonly -->
        <div class="block mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700" >
                {{ __('Your work') }}
            </label>

            <img src="{{ asset('storage/photos') .'/'.$work_file }}" 
                style="float: left;" class="block w-48 me-3" />

        </div>
        <br style="clear:both;" />

        <!-- english title -->
        <div class="mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700" for="title_en">
                {{ __('Work title, in international english language') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="title_en"
                wire:model.fill="title_en" 
                readonly
            />
        </div>

        <!-- local title -->
        <div class="mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700" for="title_local">
                {{ __('Work title, in your local language') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="title_local"
                wire:model.fill="title_local" 
                readonly
            />
        </div>

        <!-- reference_year -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="reference_year">
                {{ __('Reference year') }} 
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="reference_year"
                wire:model.fill="reference_year" 
                readonly
            />
        </div>

        <!-- Long side readonly -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="long_side">
                {{ __('Long side') }} | 🔒
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="long_side"
                wire:model.fill="long_side" 
                readonly
            />
        </div>

        <!-- Short side readonly -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="short_side">
                {{ __('Short side') }} 
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="short_side"
                wire:model.fill="short_side" 
                readonly
            />
        </div>

        <!-- Extension readonly -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="short_side">
                {{ __('Extension') }} 
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="extension"
                wire:model.fill="extension" 
                readonly
            />
        </div>

        <br style="clear:both;" />
        <hr />

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Yes. Remove that') }}
        </button>
    </form>
    <br style="clear: both;" />
    <a  href="{{ route('photo-box-list') }}" 
        class="float-end font-medium rounded-md mt-4 py-2"
        >
        [ {{ __('Your beautiful Gallery') }} ]
    </a>

</div>
