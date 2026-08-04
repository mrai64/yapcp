<?php

/**
 * User can add userWork to him/her Works Gallery 
 * upload in 
 * /storage/app/public/photos/[user_contacts.country_id]/[user_contacts.last_name]/[user_contacts.first_name]_[user_contacts.id]/
 *
 * 
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
    public UserContact $userContact;
    public UserWork    $userWork;
    public             $userWorkAlreadyLoaded;
    // form fields
    // user_works.id               assigned
    // user_works.user_id          from Auth()
    // user_works.work_file        calculated
    // user_works.extension        calculated
    // user_works.reference_year   ask
    // user_works.title_en         ask
    // user_works.title_local      ask
    // user_works.long_side        calculated
    // user_works.short_side       calculated
    // user_works.monochromatic    ask
    // user_works.raw              ask

    public function mount()
    {
        // someone as admin can upload image for user? 
        // mount(?UserContact $userContact = null)
        $this->userContact = Auth::user()->contact();
        $this->userWorkAlreadyLoaded = UserWork::where('user_id', $this->userContact->id)
            ->whereNull('deleted_at')
            ->pluck('title_en');

    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
            {{ __(':name Dashboard' , ['name' => $user->name] ) }}
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

            </div>
        </div>
    </div>
    <x-footer-app />
</div>
