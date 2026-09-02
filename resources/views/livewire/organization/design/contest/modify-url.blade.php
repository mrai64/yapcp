<?php

/**
 * Organization Contest Design / Step 3 - Some url
 *
 */

use App\Models\Contest;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    public Contest $contest;
    public Organization $organization;
    //
    public string $url1Rule;
    public string $url2ConcurrentList;
    public string $url3AdmitNAwardList;
    public string $url4Catalogue;

    public function mount(Contest $contest)
    {
        $this->contest      = $contest;
        $this->organization = $contest->organization;

        $this->url1Rule            = $contest->url_1_rule ?? '';
        $this->url2ConcurrentList  = $contest->url_2_concurrent_list ?? '';
        $this->url3AdmitNAwardList = $contest->url_3_admit_n_award_list ?? '';
        $this->url4Catalogue       = $contest->url_4_catalogue ?? '';
    }

    public function rules()
    {
        return [
            'url1Rule'            => 'required|active_url|string|max:255',
            'url2ConcurrentList' => 'required|active_url|string|max:255',
            'url3AdmitNAwardList' => 'required|active_url|string|max:255',
            'url4Catalogue'       => 'required|active_url|string|max:255',
        ];
    }

    public function modifyContest()
    {
        $validated = $this->validate();

        $this->contest->url_1_rule               = $validated['url1Rule'];
        $this->contest->url_2_concurrent_list    = $validated['url2ConcurrentList'];
        $this->contest->url_3_admit_n_award_list = $validated['url3AdmitNAwardList'];
        $this->contest->url_4_catalogue          = $validated['url4Catalogue'];

        $this->contest->save();

        // redirect itself
        return redirect()
            ->route('organization.design.contest.modify-url', ['contest' => $this->contest])
            ->with('success', __('Contest infos updated.'));

    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify Contest infos') }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.organization.design.contest-nav :contest="$contest" active="general" />
        <hr class="mb-2" />
        <livewire:organization.design.contest.general-nav :contest="$contest" />
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

                <div class="mb-4">
                    <h3 class="fyk text-xl font-medium text-gray-900">
                        {{ __('How find Contest Rule doc, Board of participants, n others. In or Out platform.') }}
                    </h3>
                </div>

                <form wire:submit="modifyContest">
                    @csrf

                    <!-- url for rules -->
                    <div class="mb-4">
                        <x-input-label for="url1Rule" :value="__('Where is, or where will be, the contest rules?')" />
                        <x-text-input wire:model="url1Rule" id="url1Rule" name="url1Rule" 
                            class="block mt-1 w-full" type="url" required />
                        <x-input-error for="url1Rule" class="mt-2" />
                    </div>

                    <!-- url2ConcurrentList -->
                    <div class="mb-4">
                        <x-input-label for="url2ConcurrentList" :value="__('Board of participants')" />
                        <x-text-input wire:model="url2ConcurrentList" id="url2ConcurrentList" name="url2ConcurrentList" 
                            class="block mt-1 w-full" type="url" required />
                        <x-input-error for="url2ConcurrentList" class="mt-2" />
                    </div>

                    <!-- url3AdmitNAwardList -->
                    <div class="mb-4">
                        <x-input-label for="url3AdmitNAwardList" :value="__('Board of contest result')" />
                        <x-text-input wire:model="url3AdmitNAwardList" id="url3AdmitNAwardList" name="url3AdmitNAwardList" 
                            class="block mt-1 w-full" type="url" required />
                        <x-input-error for="url3AdmitNAwardList" class="mt-2" />
                    </div>

                    <!-- url4Catalogue -->
                    <div class="mb-4">
                        <x-input-label for="url4Catalogue" :value="__('Contest denomination, for local language')" />
                        <x-text-input wire:model="url4Catalogue" id="url4Catalogue" name="url4Catalogue" 
                            class="block mt-1 w-full" type="url" required />
                        <x-input-error for="url4Catalogue" class="mt-2" />
                    </div>
                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Check all, then Modify') }}
                    </x-button>

                </form>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
