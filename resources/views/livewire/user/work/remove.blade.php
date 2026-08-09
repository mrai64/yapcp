<?php

/**
 * UserWork Remove
 *
 * All the fields are readonly, the form only ask a confirm
 *   before soft-delete the image that remain in disk with a prefix
 *
 */

use App\Models\UserContact;
use App\Models\UserWork;
use Livewire\Volt\Component;

new class extends Component {
    public UserWork    $userWork;
    public UserContact $userContact;
    public string      $imageUrl;
    // mount()
    public function mount(UserWork $user_work)
    {
        $this->userWork = $user_work;
        $this->userContact = $this->userWork->userContact;
        $this->imageUrl    = $this->userWork->file_path;
    }
    // rules()
    // removeWorkUser()
    public function removeUserWork()
    {
        $title = $this->userWork->title_en;
        $this->userWork->delete();
        // back to dashboard
        return redirect()
            ->route('user.dashboard')
            ->with('success', __('Removed ":title" from your Gallery', ['title' => $title]));
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('My Works named :title', ['title' => $userWork->title_en]) }}
        </h2>
        <p class="small">
            {{ __("CONFIRM that you want remove THAT image.") }}
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
                        <span>{{ $userWork->title_en }}</span>
                    </div>
                    <div class="text-center mt-2 text-xs text-gray-500">
                        <span>{{ number_format($userWork->width) }} &times; {{ number_format($userWork->height) }} px</span>
                        @if($userWork->is_landscape !== null)
                            <br />
                            &bull; <span>{{ $userWork->is_landscape ? __('Landscape') : __('Portrait') }}</span>
                        @endif
                        @if($userWork->is_monochromatic !== null)
                            <br />
                            &bull; <span>{{ $userWork->is_monochromatic ? __('Monochromatic') : __('Colour') }}</span>
                        @endif
                        @if($userWork->has_raw_file !== null)
                            <br />
                            &bull; <span>{{ $userWork->has_raw_file ? __('YES i HAVE the RAW file(s)') : __('No, missing RAW file for it') }}</span>
                        @endif
                    </div>
                </div>

                <hr class="my-6 border-gray-200" />

                <!-- Form di modifica dati -->
                <div class="text-center mx-auto">
                <form wire:submit="removeUserWork">
                    @csrf

                    <x-button class="mt-2 ms-4">
                        {{ __('Confirm remove') }}
                    </x-button>
                </form>
                </div>
            </div>
            <x-footer-app />
        </div>
    </div>
</div>
