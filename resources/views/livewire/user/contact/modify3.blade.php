<?php

/**
 * User Contact modify 3rd of five
 * 
 * TODO apply sms check to international number
 */

use App\Notifications\PhoneVerifiedSms;
use Livewire\Volt\Component;
use App\Models\UserContact;

new class extends Component {
    //
    public UserContact $userContact; 

    public $cellular;
    public $whatsapp;

    // mount() yes
    // render() no - it's Volt
    // with() no
    public function mount(UserContact $user_contact)
    {
        $this->userContact = $user_contact;
        $this->cellular = $user_contact->cellular;
        $this->whatsapp = $user_contact->whatsapp ?? 'https://wa.me/';
    }

    // for validate()
    public function rules(): array
    {
        return [
            'cellular' => 'nullable|phone:INTERNATIONAL,LENIENT',
            'whatsapp' => [
                'nullable',
                'string',
                'regex:/^https:\/\/wa\.me\/[0-9]+$/',
                'max:50'
            ],
        ];
    }

    // act
    public function updateUserContact3rd()
    {
        // Se l'utente non ha inserito il +, lo aggiungiamo noi per aiutare il validatore
        // a riconoscere il formato internazionale richiesto dal pacchetto
        if ($this->cellular && !str_starts_with($this->cellular, '+')) {
            $this->cellular = '+' . $this->cellular;
        }

        $validated = $this->validate();
        $this->userContact->cellular = $validated['cellular'];
        $this->userContact->whatsapp = $validated['whatsapp'];

        $this->userContact->save();

        // Esempio: Invia SMS di conferma all'utente autenticato
        // auth()->user()->notify(new PhoneVerifiedSms());

        return redirect()
            ->route('user.contact.modify4', ['user_contact' => $this->userContact])
            ->with('success', __("Contact numbers updated successfully"));
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __(':name, Your personal info / 3rd of five', ['name' => $userContact->first_name] ) }}
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

                <form wire:submit="updateUserContact3rd">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="cellular" :value="__('Cellular number with intl code')" />
                        <x-text-input wire:model.blur="cellular" id="cellular" name="cellular" 
                        class="block mt-1 w-full" type="text" required 
                        placeholder="393301234567 for Italy" />
                        <p class="small" id="cellularHelp"><em>{{ __('no dots, no spaces, no commas. Only digit prefixed by your +country_code, for international text / sms.') }}</em></p>
                        <x-input-error for="cellular" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="whatsapp" :value="__('Whatsapp url, facultative')" />
                        <x-text-input wire:model.blur="whatsapp" id="whatsapp" name="whatsapp" 
                        class="block mt-1 w-full" type="text" 
                        placeholder="https://wa.me/393301234567 for Italy" />
                        <x-input-error for="whatsapp" class="mt-2" />
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
