<?php

/**
 * User Contact modify 4th of five
 *
 */

use Livewire\Volt\Component;
use App\Models\UserContact;

new class extends Component {
    Public UserContact $userContact;

    public string $website;

    public string $facebook;

    public string $exTwitter;

    public string $linkedin;

    public string $instagram;

    // mount() yes
    // render() no
    // with() no
    public function mount(UserContact $user_contact)
    {
        $this->userContact = $user_contact;

        $this->website   = $user_contact->website     ?? '';
        $this->facebook  = $user_contact->facebook    ?? '';
        $this->exTwitter = $user_contact->x_twitter   ?? '';
        $this->linkedin  = $user_contact->linkedin    ?? '';
        $this->instagram = $user_contact->instagram   ?? '';
    }

    // for validate()
    public function rules(): array
    {  
        return [
            'website'   => 'nullable|string|active_url|max:100',
            'facebook'  => 'nullable|string|active_url|max:100',
            'exTwitter' => 'nullable|string|active_url|max:100',
            'linkedin'  => 'nullable|string|active_url|max:100',
            'instagram' => 'nullable|string|active_url|max:100',
        ];
    }

    public function updateUserContact4th()
    {
        // Rimuove eventuali parametri di query dagli URL (es. tracking tags) prima della validazione
        // Gestisce anche il caso in cui il '?' sia URL-encoded come '%3F'.
        foreach (['website', 'facebook', 'exTwitter', 'linkedin', 'instagram'] as $field) {
            if (!empty($this->$field)) {
                // Decodifica l'URL per convertire '%3F' in '?' e altre codifiche comuni.
                $this->$field = urldecode($this->$field);
            }
            if (!empty($this->$field)) {
                $this->$field = strtok($this->$field, '?');
            }
        }

        $validated = $this->validate();
        $this->userContact->website   = $validated['website'];
        $this->userContact->facebook  = $validated['facebook'];
        $this->userContact->x_twitter = $validated['exTwitter'];
        $this->userContact->linkedin  = $validated['linkedin'];
        $this->userContact->instagram = $validated['instagram'];

        $this->userContact->save();

        return redirect()
            ->route('user.contact.modify4', ['user_contact' => $this->userContact])
            ->with('success', __("personal page urls updated successfully"));
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __(':name, Your personal info / 4th of five', ['name' => $userContact->first_name] ) }}
        </h2>
        <hr class="mb-4" />
        <livewire:user.contact.modify-nav :user_contact="$userContact" />
        <hr class="mb-2" />
        <x-header-link-app 
            txt="Back to dashboard" 
            url="{{ route('user.dashboard') }}" />
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

                <!-- errors list -->
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form wire:submit="updateUserContact4th">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="website" :value="__('Personal website, facultative')" />
                        <x-text-input wire:model.blur="website" id="website" name="website" 
                        class="block mt-1 w-full" type="text" />
                        <x-input-error for="website" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="facebook" :value="__('Personal facebook page, facultative')" />
                        <x-text-input wire:model.blur="facebook" id="facebook" name="facebook" 
                        class="block mt-1 w-full" type="text" />
                        <x-input-error for="facebook" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="exTwitter" :value="__('Personal X formerly Twitter, facultative')" />
                        <x-text-input wire:model.blur="exTwitter" id="exTwitter" name="exTwitter" 
                        class="block mt-1 w-full" type="text" />
                        <x-input-error for="exTwitter" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="linkedin" :value="__('Personal Linkedin, facultative')" />
                        <x-text-input wire:model.blur="linkedin" id="linkedin" name="linkedin" 
                        class="block mt-1 w-full" type="text" />
                        <x-input-error for="linkedin" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="instagram" :value="__('Personal Instagram, facultative')" />
                        <x-text-input wire:model.blur="instagram" id="instagram" name="instagram" 
                        class="block mt-1 w-full" type="text" />
                        <x-input-error for="instagram" class="mt-2" />
                    </div>

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Update, then next panel') }}
                    </x-button>

                </form>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
