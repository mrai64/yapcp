<?php

/**
 * User can add userWork to him/her Works Gallery 
 * upload in 
 * /storage/app/public/photos/[user_contacts.country_id]/[user_contacts.last_name]/[user_contacts.first_name]_[user_contacts.id]/
 *
 * version 2026-08-04
 */

use App\Models\UserContact;
use App\Models\UserWork;
use Illuminate\Http\File;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Volt\Component;

new class extends Component {
    use WithFileUploads; // for mage upload
    use Notifiable; //      for ad 'image loaded'
    //
    public             $userContact;
    public UserWork    $userWork;
    public             $userWorkTempImage;
    public             $userWorkAlreadyLoaded;
    public             $userPhotoBox;
    // form fields
    // user_works.id               assigned
    // user_works.user_id          from Auth()
    public string      $userWorkTitleEn;
    // user_works.title_en         ==                   ask
    // user_works.title_local      ==                   ask
    // user_works.file_path        was work_file        calculated
    // user_works.file_format      was extension        calculated
    // user_works.file_size        new                  calculated
    // user_works.                 was reference_year   ask
    // user_works.                 was long_side        calculated
    // user_works.                 was short_side       calculated
    public bool        $userWorkIsMonochromatic;
    // user_works.is_monochromatic was monochromatic    ask
    public bool        $userWorkRawAvailable;
    // user_works.has_raw_file     was raw              ask

    public function mount()
    {
        // someone as admin can upload image for user? 
        // mount(?UserContact $userContact = null)
        $this->userContact = Auth::user()->contact;
        $this->userWorkAlreadyLoaded = UserWork::where('user_id', $this->userContact->id)
            ->whereNull('deleted_at')
            ->pluck('title_en');

        $this->userPhotoBox = $this->userContact->photobox();
        $this->userWorkTempImage = null;
        $this->userWorkTitleEn = '';
        $this->userWorkIsMonochromatic = false;
        $this->userWorkRawAvailable = false;
    }

    public function rules()
    {
        return [
            'userWorkTitleEn' => 'required|string|max:250',
            'userWorkTempImage' => 'required|image|mimes:jpg,|max:9000', // KB
            'userWorkIsMonochromatic' => 'nullable|boolean',
            'userWorkRawAvailable' => 'nullable|boolean',
        ];
    }

    public function addUserWork()
    {
        $tmpId = Str::uuid();
        $fileTempImage = $this->userWorkTempImage->getRealPath();
        $imgInfo = getimagesize($fileTempImage);
        $imgFormat = image_type_to_extension($imgInfo[2], false); // no dot
        $imgStorePath = $this->userContact->photoBox() . '/' . $tmpId . '.' . $imgFormat;
        $this->userWorkTempImage->storeAs('photos', $imgStorePath, 'public');
        $imgWidth = $imgInfo[0];
        $imgHeight = $imgInfo[1];
        $imgSize = filesize($fileTempImage);

        $validated = $this->validate();

        $this->userWork = UserWork::create(
            [
                'id'               => $tmpId,
                'user_id'          => $this->userContact->id,
                'title_en'         => $validated['userWorkTitleEn'],
                // title_local
                'file_path'        => $imgStorePath,
                'file_format'      => $imgFormat,
                'file_size'        => $imgSize,
                'long_size'        => ($imgWidth >= $imgHeight) ? $imgWidth : $imgHeight,
                'short_size'       => ($imgWidth <= $imgHeight) ? $imgWidth : $imgHeight,
                'is_monochromatic' => (bool) $validated['userWorkIsMonochromatic'],
                'has_raw_file'     => (bool) $validated['userWorkRawAvailable'],
            ]
        );

        // make miniature

        // redirect to itself
        return redirect()
            ->route('user.work.add')
            ->with('success', __('Added ":title" to your Gallery', ['title' => $validated['userWorkTitleEn']]));
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
            {{ __(':name Add Work to Personal Gallery' , ['name' => $userContact->first_name] ) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    {{ session('success') }}
                </div>
                @endif

                <form wire:submit="addUserWork">
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

                    <!-- image work upload -->
                    <div class="block mb-4">
                        <x-input-label for="userWorkTempImage" :value="__('Your work image')" />

                        @if ($userWorkTempImage)
                        <img src="{{ $userWorkTempImage->temporaryUrl() }}" style="float: left;" class="block w-48 me-3" />
                        <br style="clear:both;" />
                        @else
                        <img src="{{ asset('storage/photos') . '/' . $userContact->passport_photo }}" 
                            alt="" style="float: left;" class="block w-48 me-3" />
                        <br style="clear:both;" />
                        @endif
    
                        <input 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1" 
                            type="file" accept="image/jpeg"
                            name="userWorkTempImage" wire:model="userWorkTempImage"
                            aria-describedby="photoHelp" />
                        <div wire:loading wire:target="userWorkTempImage">{{ __("Uploading...")}}</div>
                        <x-input-error for="userWorkTempImage" class="mt-2" />
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
                        {{ __('Add file in Gallery ') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
    <x-footer-app />
</div>
