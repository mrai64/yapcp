<?php

/**
 * Organization Contest design / add a juror to ContestJury
 * 2nd of 3 - ask personal data to build user n user_contacts
 *
 */

use App\Actions\Yapcp\RegisterContestJuror;
use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserContact;
use Livewire\Attributes\Session;
use Livewire\Volt\Component;

new class extends Component {
    public Contest $contest;
    public ContestSection $contestSection;
    public Organization $organization;
    // form fields
    public string $contestJurorEmail;
    public string $contestJurorFirstName;
    public string $contestJurorLastName;
    public string $contestJurorCountryId;

    public function mount(ContestSection $contest_section)
    {
        // header
        $this->contestSection = $contest_section;
        $this->contest = $contest_section->contest;
        $this->organization = $this->contest->organization;
        // form fields
        $this->contestJurorEmail = session()->get('contest_juror_email');
        $this->contestJurorFirstName = '';
        $this->contestJurorLastName = '';
        $this->contestJurorCountryId = 'ITA'; //default
    }
    //
    public function rules()
    {
        return [
            'contestJurorEmail'      => 'required|email|unique:users,email',
            'contestJurorFirstName'  => 'required|string|min:2|max:255',
            'contestJurorLastName'   => 'required|string|min:2|max:255',
            'contestJurorCountryId'  => 'required|exists:countries,id',
        ];
    }
    //
    public function addUserContact()
    {
        $validated = $this->validate();

        $user = app(RegisterContestJuror::class)
            ->execute([
            'email' => $validated['contestJurorEmail'],
            'first_name' => $validated['contestJurorFirstName'],
            'last_name' => $validated['contestJurorLastName'],
            'country_id' => $validated['contestJurorCountryId'],
        ]);

        session()->put('contest_juror_id', $user->id);

        // know, add Juror
        return redirect()
            ->route('organization.design.contest-jury.add3', ['contest_section' => $this->contestSection ])
            ->with('success', __('Juror found then added to contest, enjoy!'));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Add Contest Juror / 2nd of 3') }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.organization.design.contest-nav :contest="$contest" active="juries" />
        <hr class="mb-2" />
        <livewire:organization.design.contest-jury.jury-nav :contest="$contest" />
        <hr class="mb-2" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-yapcp.header-link 
			txt="Organization dashboard" 
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    {{ session('success') }}
                </div>
                <hr />
                @endif

                <!-- errors list -->
                @if ($errors->any())
                <br />
                <div class="mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                <br />
                @endif

                <!--  -->
                <form wire:submit="addUserContact">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="contestJurorFirstName" :value="__('First name')" />
                        <x-text-input wire:model="contestJurorFirstName" id="contestJurorFirstName" class="block mt-1 w-full" type="text" name="contestJurorFirstName" required 
                        placeholder="{{ __('First name') }}" />
                        <x-input-error for="contestJurorFirstName" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="contestJurorLastName" :value="__('Last name, Surname')" />
                        <x-text-input wire:model="contestJurorLastName" id="contestJurorLastName" class="block mt-1 w-full" type="text" name="contestJurorLastName" required placeholder="{{ __('Last name') }}"/>
                        <x-input-error for="contestJurorLastName" class="mt-2" />
                    </div>


                    <!-- country select -->
                    <x-select-country-app wire:model="contestJurorCountryId" :country_id="$contestJurorCountryId" /> 

                    <!-- contestSectionNameEn -->
                    <div class="mb-4">
                        <x-input-label for="contestJurorEmail" :value="__('Juror email')" />
                        <x-text-input wire:model="contestJurorEmail" id="contestJurorEmail" name="contestJurorEmail" 
                            class="block mt-1 w-full" type="email" required />
                        <x-input-error for="contestJurorEmail" class="mt-2" />
                    </div>

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Check then Add') }}
                    </x-button>
                </form>
                <!--/ -->

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
