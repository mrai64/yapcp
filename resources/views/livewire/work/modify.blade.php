<div>
    <!-- That page is accessibile after login so your id is'n necessary in that form 4 load works --> 
    <h2 style="font-size:3rem;" class="fyk mb-4">{{ __('Update your Work data') }}</h2>

    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div> 
    @else 
    <p class="small">{{ __('Warning: you can change some data but not image. Instead remove and upload another.') }}</p>
    @endif
    <br style="clear:both;" />
    <a  href="{{ route('photo-box-list') }}" 
        class="float-end font-medium rounded-md mb-4 py-2"
        >
        [ {{ __('Your beautiful Gallery') }} ]
    </a>

    <hr />
    <br style="clear:both;" />

    <form wire:submit="update" >
        @csrf

        <!-- work_id -->
        <!-- user_id -->

        <!-- work readonly -->
        <div class="block mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700" >
                {{ __('Your work') }} | 🔒
            </label>

            <img src="{{ asset('storage/photos') . '/' . $work_file }}" 
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
                wire:model.live.debounce.1500ms="title_en" 
                required="required"
                aria-describedby="photoHelp"
            />
            <div class="small" id="photoHelp">{{ __('Remember: Some contest not allow work w/title "Untitled", your title work should appear [and 🤞🏻 we hope 4 u] in contest catalogue.') }}</div>
            <div class="small">@error('title_en') {{ $message }} @enderror</div>
        </div>

        <!-- local title -->
        <div class="mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700" for="title_local">
                {{ __('Work title, in your local language') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="title_local"
                wire:model.live.debounce.500ms="title_local" 
                aria-describedby="photoHelp2"
            />
            <div class="small" id="photoHelp2">{{ __('Remember: Some contest not allow work w/title "Untitled", also translated in your language words.') }}</div>
            <div class="small">@error('title_local') {{ $message }} @enderror</div>
        </div>

        <!-- reference_year -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="reference_year">
                {{ __('Reference year') }} 
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="reference_year"
                wire:model.live.debounce.500ms="reference_year" 
                aria-describedby="refYearHelp"
                placeholder="yyyy"
                required="required"
            />
            <div class="small" id="refYearHelp">{{ __('Year in 4 digit form, from 1826 upto present year.') }}</div>
            <div class="small">@error('reference_year') {{ $message }} @enderror</div>
        </div>

        <!-- Long side readonly -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="long_side">
                {{ __('Long side') }} | 🔒
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="long_side"
                wire:model.live.debounce.500ms="long_side" 
                aria-describedby="longsideHelp"
                readonly
            />
            <div class="small" id="longsideHelp">{{ __('Read only.') }}</div>
            <div class="small">@error('long_side') {{ $message }} @enderror</div>
        </div>

        <!-- Short side readonly -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="short_side">
                {{ __('Short side') }} | 🔒
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="short_side"
                wire:model.live.debounce.500ms="short_side" 
                aria-describedby="shortsideHelp"
                readonly
            />
            <div class="small" id="shortsideHelp">{{ __('Read only.') }}</div>
            <div class="small">@error('short_side') {{ $message }} @enderror</div>
        </div>

        <!-- Extension readonly -->
        <div class="mt-4 mb-4 block" style="width:23%;float:left;">
            <label class="block font-medium text-sm text-gray-700" for="short_side">
                {{ __('Extension') }} | 🔒
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="extension"
                wire:model.live.debounce.500ms="extension" 
                aria-describedby="extensionHelp"
                readonly
            />
            <div class="small" id="extensionHelp">{{ __('Read only.') }}</div>
            <div class="small">@error('extension') {{ $message }} @enderror</div>
        </div>

        <br style="clear:both;" />
        <hr />

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Done, update it') }}
        </button>
    </form>
    <br style="clear: both;" />
    <a  href="{{ route('photo-box-list') }}" 
        class="float-end font-medium rounded-md mt-4 py-2"
        >
        [ {{ __('Your beautiful Gallery') }} ]
    </a>


</div>
