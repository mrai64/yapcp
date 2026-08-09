<?php

/**
 * UserWork Modify 
 *
 * Some fields are modifiable, not all, not even
 *
 */

use App\Models\UserWork;
use App\Models\UserWorkMore;
use Livewire\Volt\Component;

new class extends Component {
    public UserWork $userWork;
    public bool     $isLandscape;
    public int      $width;
    public int      $height;
    public string   $imageUrl;
    public string   $userWorkTitleEn;
    public bool     $userWorkIsMonochromatic;
    public bool     $userWorkRawAvailable;

    // mount()
    // no wth()
    public function mount(UserWork $user_work)
    {
        $this->userWork = $user_work;
        $this->isLandscape = $this->userWork->is_landscape;
        $this->width       = $this->userWork->width;
        $this->height      = $this->userWork->height;
        $this->imageUrl    = $this->userWork->file_path;
        //
        $this->userWorkTitleEn         = $this->userWork->title_en;
        $this->userWorkIsMonochromatic = $this->userWork->is_monochromatic;
        $this->userWorkRawAvailable    = $this->userWork->has_raw_file;
    }

    public function rules()
    {
        return [
            'userWorkTitleEn' => 'required|string|max:250',
            'userWorkIsMonochromatic' => 'nullable|boolean',
            'userWorkRawAvailable' => 'nullable|boolean',
        ];
    }
    public function updateUserWork()
    {
        // 1st check
        $validated = $this->validate();

        //
        $this->userWork->title_en = $validated['userWorkTitleEn'];
        $this->userWork->is_monochromatic = $validated['userWorkIsMonochromatic'];
        $this->userWork->has_raw_file = $validated['userWorkRawAvailable'];
        $this->userWork->save();

        // try to redirect to historic back()
        return redirect()
            ->back()
            ->with('success', __('Modified ":title" into your Gallery, maybe now be not in the original position', ['title' => $validated['userWorkTitleEn']]));

    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('My Works named :title', ['title' => $userWork->title_en]) }}
        </h2>
        <p class="small">
            {{ __("You can´t modify some infos as mage, image width or height. instead delete image and load a new one.") }}
        </p>
        <hr class="mb-4 mt-4" />
        <x-yapcp.header-link
            txt="Back to User dashboard"
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link
            txt="Back to listed Gallery"
            url="{{ route('user.work.listed1') }}" />
        <x-yapcp.header-link
            txt="Back to grid Gallery"
            url="{{ route('user.work.listed2') }}" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Success Message -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Errors List -->
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="flex flex-col items-center justify-center w-full my-4">
                    <div class="flex items-center justify-center p-2 bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
                        <img
                            src="{{ asset('storage/photos') . '/' . $imageUrl }}"
                            alt="{{ $userWork->title_en }}"
                            class="max-w-[50vw] max-h-[50vh] w-auto h-auto object-contain rounded"
                            loading="lazy"
                        />
                    </div>

                    <!-- Dettagli minimi sotto l'immagine (opzionale) -->
                    <div class="text-center mt-2 text-xs text-gray-500">
                        <span>{{ number_format($userWork->width) }} &times; {{ number_format($userWork->height) }} px</span>
                        @if($userWork->is_landscape !== null)
                            &bull; <span>{{ $userWork->is_landscape ? __('Landscape') : __('Portrait') }}</span>
                        @endif
                    </div>
                </div>

                <hr class="my-6 border-gray-200" />

                <!-- Form di modifica dati -->
                <div class="max-w-2xl mx-auto">
                <form wire:submit="updateUserWork">
                    @csrf

                    <!-- international title -->
                    <div class="mb-4">
                        <x-input-label for="userWorkTitleEn" :value="__('International english title')" />
                        <x-text-input wire:model.blur="userWorkTitleEn" id="userWorkTitleEn" name="userWorkTitleEn" 
                        class="block mt-1 w-full" type="text" />
                        <x-input-error for="userWorkTitleEn" class="mt-2" />
                        <div class="small" >
                            {{ __("You can use every title, even Untitled, but we suggest to avoid it.") }}

                            {{ __("Another suggest: avoid duplicate title in your Gallery.") }}
                        </div>
                    </div>

                    <!-- is mono -->
                    <div class="mb-4">
                        <x-input-label for="userWorkIsMonochromatic" :value="__('Declare it as MONOchromatic')" />
                            <x-checkbox wire:model="userWorkIsMonochromatic" id="userWorkIsMonochromatic" name="userWorkIsMonochromatic" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                            {{ __('Yes, is monochromatic aka black n white') }}
                        </label>
                        <x-input-error for="userWorkIsMonochromatic" class="mt-2" />
                    </div>

                    <!-- RAW available -->
                    <div class="mb-4">
                        <x-input-label for="userWorkRawAvailable" :value="__('Have RAW of it?')" />
                            <x-checkbox wire:model="userWorkRawAvailable" id="userWorkRawAvailable" name="userWorkRawAvailable" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                            {{ __('Yes, i have RAW of it') }}
                        </label>
                        <x-input-error for="userWorkRawAvailable" class="mt-2" />
                    </div>

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Update file in Gallery ') }}
                    </x-button>
                </form>
                </div>
            </div>
            <x-footer-app />
        </div>
    </div>
</div>
