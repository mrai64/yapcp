<?php

/**
 * Organization Contest Design / add a Contest Federation Patronage
 */

use App\Models\Contest;
use App\Models\ContestPatronage;
use App\Models\Federation;
use App\Models\Organization;
use Livewire\Volt\Component;

new class () extends Component {
    public Contest $circuit;
    public Organization $organization;
    public $contPatrFederationIdsSet;
    public string $contPatrFederationId;
    public string $contPatrPatronageCode;
    //
    public function mount(Contest $contest)
    {
        $this->authorize('create', [ContestPatronage::class, $contest]);
        $this->circuit = $contest;
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
            'contPatrPatronageCode' => 'required|string|uppercase|max:72',
        ];
    }
    //
    public function addCircuitPatronage()
    {
        $validated = $this->validate();
        $contestId = $this->circuit->id;
        $federationId = $validated['contPatrFederationId'];
        $patronageCode = $validated['contPatrPatronageCode'];

        $patronage = ContestPatronage::withTrashed()
            ->where('contest_id', $contestId)
            ->where('federation_id', $federationId)
            ->first();

        if ($patronage) {
            if ($patronage->trashed()) {
                $patronage->restore();
            }

            $patronage->update([
                'patronage_code' => $patronageCode,
            ]);
        } else {
            ContestPatronage::create([
                'contest_id' => $contestId,
                'federation_id' => $federationId,
                'patronage_code' => $patronageCode,
            ]);
        }

        // redirect
        return redirect()
            ->route('organization.design.circuit-patronage.listed', ['contest' => $this->circuit])
            ->with('success', __('New Federation Patronage added, enjoy!'));

    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Add Federation Patronages Codes for Circuit') }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.organization.design.circuit-nav :circuit="$circuit" active="patronages" />
        <hr class="mb-2" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-yapcp.header-link 
			txt="Organization dashboard" 
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
        <x-yapcp.header-link 
            txt="Patronages List" 
            url="{{ route('organization.design.circuit-patronage.listed', ['contest' => $circuit]) }}" />
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

                <form wire:submit="addCircuitPatronage">
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
                        <x-input-label for="contPatrPatronageCode" :value="__('Patronage codes')" />
                        <x-text-input wire:model="contPatrPatronageCode" id="contPatrPatronageCode" name="contPatrPatronageCode" 
                            class="block mt-1 w-full" type="text" required />
                        <p class="small">
                            {{ __("Insert all patronage codes from the same federation, using space as separator.")}}
                            {{ __("Next, for every contest insert single contest federation patronage code.")}}
                        </p>
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
