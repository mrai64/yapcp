<?php

/**
 * Organization Contest Design / remove Contest Federation Patronage
 *
 */

use App\Models\Contest;
use App\Models\ContestPatronage;
use App\Models\Federation;
use App\Models\Organization;
use Livewire\Volt\Component;

new class () extends Component {
    public ContestPatronage $contestPatronage;
    public Contest $contest;
    public Organization $organization;
    //
    public function mount(ContestPatronage $contest_patronage)
    {
        $this->authorize('delete', [ContestPatronage::class, $contest_patronage]);
        $this->contestPatronage = $contest_patronage;
        $this->contest = $contest_patronage->contest;
        $this->organization = $this->contest->organization;
    }
    //
    // rules() no
    // 
    public function removeContestPatronage()
    {
        $this->contestPatronage->delete();
        // redirect
        return redirect()
            ->route('organization.design.contest-patronage.listed', ['contest' => $this->contest])
            ->with('success', __('Federation Patronage modified, enjoy!'));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Federation Patronage Code Remove') }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.organization.design.contest-nav :contest="$contest" active="patronages" />
        <hr class="mb-2" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-yapcp.header-link 
			txt="Organization dashboard" 
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
        <x-yapcp.header-link 
            txt="Patronages List" 
            url="{{ route('organization.design.contest-patronage.listed', ['contest' => $contest]) }}" />
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

                <div class="fyk text-2xl font-medium text-red-600">
                    {{ __('Federation Patronage assigned to ') }}
                    <br />
                    {{ $contest->name_en }}
                </div>
                <p class="small text-red-600">{{ __("Remove only if you ABSOLUTELY KNOW what are the consequences") }}</p>
                <br />
                <hr />
                <ul>
                    <li class="font-mono">
                        {{ $contestPatronage->federation->country->flag_code}}
                        {{ $contestPatronage->federation->id}}
                        {{ $contestPatronage->patronage_code}}
                        |
                        {{ $contestPatronage->federation->name_en}}
                        <br />
                    </li>
                </ul>
                <br />


                <form wire:submit="removeContestPatronage">
                    @csrf

                    <x-button class="mt-2 ms-4">
                        {{ __('LAST CALL. Are you SURE to delete that?') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
