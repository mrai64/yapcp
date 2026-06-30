<?php

/**
 * Organization Contest design / remove a ContestSection record
 *
 * TODO Observer with deleting ContestJury related to the
 * TODO   removed ContestSection record
 *
 */

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    public ContestSection $contestSection;
    public Organization   $organization;
    public Contest        $contest;

    public function mount(ContestSection $contest_section)
    {
        $this->contestSection = $contest_section;
        $this->contest        = $contest_section->contest;
        $this->organization   = $contest_section->contest->organization;

    }

    public function removeContestSection()
    {
        $this->contestSection->delete();

        return redirect()
            ->route('organization.design.contest-section.listed', ['contest' => $this->contest ])
            ->with('success', __('Section removed, as confirmed.'));

    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-red-500">
            {{ __('REMOVE Contest infos') }}
        </h2>
        <hr class="mb-4" />
        <livewire:organization.design.contest.modify-nav :contest="$contest" />
        <hr class="mb-2" />
        <livewire:organization.design.contest-nav :contest="$contest" />
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

                <h3 class="fyk text-2xl font-medium text-gray-900">
                    {{ __('Contest Section n theme') }}
                </h3>
                <hr class="mb-4" />
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Code') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ $contestSection->code }}
                            </dd>
                        </div>
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Name, en') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ $contestSection->name_en }}
                            </dd>
                        </div>
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Synopsis') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ ($contestSection->synopsis) ? $contestSection->synopsis : '--' }}
                            </dd>
                        </div>
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Accepted fle extensions') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ $contestSection->file_formats }}
                            </dd>
                        </div>
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Under a federation patronage') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ ($contestSection->under_patronage) ? __('Yes, under') : __('No, free from') }}
                            </dd>
                        </div>
                        @if ($contestSection->under_patronage)
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Which federation') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ $contestSection->federation_id }}
                            </dd>
                        </div>
                        @endif
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Works applying') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ __("From :min to :max included", ['min' => $contestSection->min_works, 'max' => $contestSection->max_works]) }}
                            </dd>
                        </div>
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Max short-side size px') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ $contestSection->short_size_max }}
                            </dd>
                        </div>
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Max long-side size px') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ $contestSection->long_size_max }}
                            </dd>
                        </div>
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Max file size Bytes') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ $contestSection->file_size_max }}
                            </dd>
                        </div>
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Only Monochromatic works?') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ ($contestSection->monochromatic_required) ? __('Yes, only') : __('No, Colour') }}
                            </dd>
                        </div>
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Organization n Federation can require original RAW files?') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ ($contestSection->raw_required) ? __('Yes, they can') : __('No. Not required') }}
                            </dd>
                        </div>
                    </dl>
                        <div class="mt-4 sm:col-span-1">
                            <dt class="fyk text-xl font-medium text-gray-700">
                                {{ __('Every Participants can receive max / only a prize per section - theme?') }}
                            </dt>
                            <dd class="mt-1 text-xl text-gray-900 font-semibold">
                                {{ ($contestSection->unique_prize) ? __('Yes, only one') : __('No. can cumulate') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <form wire:submit="removeContestSection">
                    @csrf
                    <x-button class="mt-2 ms-4">
                        {{ __('Are you SURE!? Delete Contest Section. Are You SURE?') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
