<?php

/**
 * Organization Contest design / add a juror to ContestJury
 * 1st of 3 - check email
 *
 */

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\Organization;
use App\Models\UserContact;
use Livewire\Attributes\Session;
use Livewire\Volt\Component;

new class extends Component {
    public Contest $contest;
    public ContestSection $contestSection;
    public Organization $organization;
    // form fields
    public string $contestJurorEmail;

    public function mount(ContestSection $contest_section)
    {
        $this->contestSection = $contest_section;
        $this->contest = $contest_section->contest;
        $this->organization = $this->contest->organization;
        // clean
        session()->forget('contest_juror_id');
        session()->forget('contest_juror_email');
    }

    public function rules()
    {
        return [
            'contestJurorEmail' => 'required|email|max:255',
        ];

    }

    public function checkEmail()
    {
        $validated = $this->validate();
        session()->put('contest_juror_email', $validated['contestJurorEmail']);

        $userContact = UserContact::where('email', $validated['contestJurorEmail'])
            ->first();
        if ($userContact) {
            session()->put('contest_juror_id', $userContact->id);
            // know, add Juror
            return redirect()
                ->route('organization.design.contest-jury.add3', ['contest_section' => $this->contestSection ])
                ->with('success', __('Juror found then added to contest, enjoy!'));
        } else {
            // who is?
            return redirect()
                ->route('organization.design.contest-jury.add2', ['contest_section' => $this->contestSection ])
                ->with('success', __('Juror email not found, who is?'));
        }

    }


}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Add Contest Juror / 1st of 3') }}
        </h2>
        <hr class="mb-4" />
        <livewire:organization.design.contest.modify-nav :contest="$contest" />
        <hr class="mb-2" />
        <livewire:organization.design.contest-nav :contest="$contest" />
        <hr class="mb-2" />
        <x-header-link-app 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-header-link-app 
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
                <form wire:submit="checkEmail">
                    @csrf

                    <!-- contestSectionNameEn -->
                    <div class="mb-4">
                        <x-input-label for="contestJurorEmail" :value="__('Juror email')" />
                        <x-text-input wire:model="contestJurorEmail" id="contestJurorEmail" name="contestJurorEmail" 
                            class="block mt-1 w-full" type="email" required />
                        <x-input-error for="contestJurorEmail" class="mt-2" />
                    </div>

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Check if present') }}
                    </x-button>
                </form>
                <!--/ -->

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
