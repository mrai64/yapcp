<?php

/**
 * Organization Contest Design / Contest full detail
 * 
 */

use App\Models\Contest;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    public Contest $contest;
    public Organization $organization;

    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $contest->organization;

    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Detailed Contest infos') }}
        </h2>
        <hr class="mb-4" />
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

                <!-- general -->
                <livewire:organization.design.contest.detail-general1 :contest="$contest" />
                <div class="text-3xl">&nbsp;</div>
                <!-- section n themes + juries --> 
                <livewire:organization.design.contest-section.details :contest="$contest" />
                <div class="text-3xl">&nbsp;</div>
                <!-- awards --> 
                <livewire:organization.design.contest-award.details :contest="$contest" />
                <!-- appling info --> 
                <livewire:organization.design.contest.detail-general2 :contest="$contest" />
                <div class="text-3xl">&nbsp;</div>



            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
