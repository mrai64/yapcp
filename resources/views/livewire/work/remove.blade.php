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
        [ {{ __('Back to Gallery') }} ]
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

            <img src="{{ asset('storage/photos') .'/'.$workFile }}" 
                style="float: left;" class="block w-48 me-3" />

        </div>
        <br style="clear:both;" />

        <!-- english title -->
        <div class="mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700" for="titleEnglish">
                {{ __('Work title, in international english language') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="titleEnglish"
                wire:model.fill="titleEnglish" 
                readonly
            />
        </div>

        <!-- TODO remove field-->
        <!-- local title -->
        <div class="mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700" for="titleLocal">
                {{ __('Work title, in your local language') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="titleLocal"
                wire:model.fill="titleLocal" 
                readonly
            />
        </div>

        <!-- referenceYear -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="referenceYear">
                {{ __('Reference year') }} 
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="referenceYear"
                wire:model.fill="referenceYear" 
                readonly
            />
        </div>

        <!-- Long side readonly -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="longSide">
                {{ __('Long side') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="longSide"
                wire:model.fill="longSide" 
                readonly
            />
        </div>

        <!-- Short side readonly -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="shortSide">
                {{ __('Short side') }} 
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="shortSide"
                wire:model.fill="shortSide" 
                readonly
            />
        </div>

        <!-- Extension readonly -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="shortSide">
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
