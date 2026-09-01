<?php

/**
 * Organization Contest Design / add a Contest Federation Patronage
 */

use App\Models\Contest;
use App\Models\ContestPatronage;
use App\Models\Federation;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    public Contest $contest;
    public Organization $organization;
    public $contPatrFederationIdsSet;
    public string $contPatrFederationId;
    public string $contPatrPatronageCode;
    //
    public function mount(Contest $contest)
    {
        $this->authorize('create', [ContestPatronage::class, $contest]);
        $this->contest = $contest;
        $this->organization = $contest->organization;
        //
        $contPatrFederationIdsSet = Federation::query()
            ->with(['country'])
            ->orderBy('country_id', 'asc')
            ->orderBy('name_en', 'asc')
            ->get();
        $this->contPatrFederationIdsSet = $contPatrFederationIdsSet;// ->toArray();
    }
    //
    public function rules(): array
    {
        return [
            'contPatrFederationId' => 'required|string|exists:federations,id',
            'contPatrPatronageCode' => 'required|string|uppercase|max:20',
        ];
    }
    //
    public function addContestPatronage()
    {
        $validated = $this->validate();

        $contestPatronage = ContestPatronage::create([
            'contest_id' => $this->contest->id,
            'federation_id' => $validated['contPatrFederationId'],
            'patronage_code' => $validated['contPatrPatronageCode'],
        ]);

        // redirect
        return redirect()
            ->route('organization.design.contest-patronage.listed', ['contest' => $this->contest])
            ->with('success', __('New Federation Patronage added, enjoy!'));

    }
}; ?>

<div>
<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Add Federation Patronage Code') }}
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

                <form wire:submit="addContestPatronage">
                    @csrf

                    <!-- should be an x-yapcp-select-federation -->
                    <div class="mb-4">
                        <x-input-label for="contPatrFederationId" :value="__('Federation ID')" />
                        <select 
                            class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full'
                            id="contPatrFederationId"
                            name="contPatrFederationId"
                            wire:model="contPatrFederationId"
                            required >
                            <option value="">{{ __("...") }}</option>
                            @foreach ($contPatrFederationIdsSet as $federation)
                                <option value="{{ $federation->id }}" {{ $federation->id == $contPatrFederationId ? 'selected' : '' }}>
                                    {{ $federation->country->flag_code }} {{ $federation->id }} | {{ $federation->name_en}} 
                                </option>
                            @endforeach

                        </select>
                        <x-input-error for="contPatrFederationId" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="contPatrPatronageCode" :value="__('Patronage code')" />
                        <x-text-input wire:model="contPatrPatronageCode" id="contPatrPatronageCode" name="contPatrPatronageCode" 
                            class="block mt-1 w-60" type="text" required />
                        <x-input-error for="contPatrPatronageCode" class="mt-2" />
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
