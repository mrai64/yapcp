<div>
    <!-- That page is accessibile after login so your id is'n necessary in that form 4 load works --> 
    <h2 style="font-size:3rem;" class="fyk mb-4">{{ __('Increment Your Gallery') }}</h2>

    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div> 
    @else 
    <p class="small">🆙 Add another masterpiece to your private Uffizi' Gallery.</p>
    @endif
        <br style="clear:both;" />
    <a  href="{{ route('photo-box-list') }}" 
        class="float-end font-medium rounded-md mb-4 py-2"
        >
        [ {{ __('Your beautiful Gallery') }} ]
    </a>
    <br style="clear:both;" />

    <form wire:submit="save" enctype="multipart/form-data">
        @csrf
        <!-- work -->
        <div class="block mb-4">
            <label class="block font-medium text-sm text-gray-700" for="work_image">
                {{ __('Your work') }}
            </label>
            @if ($work_image)
            <img src="{{ $work_image->temporaryUrl() }}" 
                style="float: left;" class="block w-48 me-3" />
            @else
                &nbsp;
            @endif
            <input 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1" 
            type="file" accept="image/webp, image/jpeg"
            name="work_image" wire:model="work_image"
            aria-describedby="photoHelp"
            />
            <div wire:loading wire:target="work_image">Uploading...</div>
            <div class="small" id="photoHelp">{{ __('One at time, Jpg/Webp, upto 2500px long side, upto 64MB. Wait until thumb appear. ') }}</div>
            <div class="small">@error('work_image') {{ $message }} @enderror</div>
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
            />
            <div class="small" id="photoHelp">{{ __('Remember: Some contest not allow work w/title "Untitled", your title work should appear [and 🤞🏻 we hope 4 u] in contest catalogue.') }}</div>
            <div class="small">@error('title_en') {{ $message }} @enderror</div>
        </div>

        <!-- local title -->
        <div class="mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700" for="text_local">
                {{ __('Work title, in your local language') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="title_local"
                wire:model.live.debounce.500ms="title_local" 
            />
            <div class="small">@error('title_local') {{ $message }} @enderror</div>
        </div>

        <!-- monochromatic -->
        <div class="mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700">
                <input type="radio" name="monochromatic" id="" value="Y" />
                {{ __('Yes, it\'s monochrome') }}
            </label>
            <label class="block font-medium text-sm text-gray-700">
                <input type="radio" name="monochromatic" id="" value="N" checked />
                {{ __('No, it\'s NOT monochrome') }}
            </label>
            <div class="small">@error('monochromatic') {{ $message }} @enderror</div>
        </div>

        <hr />

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Well, add that to my Gallery') }}
        </button>

        <br style="clear:both" />
    <a  href="{{ route('photo-box-list') }}" 
        class="float-end font-medium rounded-md mb-4 py-2"
        >
        [ {{ __('Your beautiful Gallery') }} ]
    </a>

    </form>

</div>
