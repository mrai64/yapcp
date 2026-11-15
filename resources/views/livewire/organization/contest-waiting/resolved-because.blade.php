<?php

/**
 * Organization / Contest Manage / ContestWaiting update 
 * Resolve ContestWork Issue with a motivation
 *
 */

use App\Models\Contest;
use App\Models\ContestWaiting;
use App\Models\ContestWork;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Volt\Component;

new class extends Component {
    //
    public ContestWaiting $contestWaiting;
    public Contest $contest;
    public Organization $organization;
    public bool $sectionIsFull = false;
    //
    public string $resolvedBecause;
    //
    public function mount(ContestWaiting $contestWaiting)
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $this->contestWaiting = $contestWaiting;
        $this->contest        = $this->contestWaiting->contest;
        $this->organization   = $this->contest->organization;

        $this->resolvedBecause = '';
        $this->sectionIsFull = ContestWork::sectionIsFull($this->contestWaiting->section_id, $this->contestWaiting->participant_user_id);
        // sectionIsFull -> image remain locked

    }
    // for validation
    public function rules()
    {
        return [
            'resolvedBecause' => 'required|string|max:2000',
        ];
    }
    //
    public function solvedContestWaiting()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $validated = $this->validate();
        //
        $this->contestWaiting->update([
            'resolved_by_user_id'  => Auth::id(),
            'resolved_because'     => $validated['resolvedBecause'],
        ]);
        if (! $this->sectionIsFull) {
            // then remove
            $this->contestWaiting->delete();
            Log::debug('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ 
                . ' ContestWaiting id: ' . $this->contestWaiting->id . ' resolved and soft-deleted.');
        }
        // redirect to list updated 
        return redirect()
            ->route('organization.contest-waiting.resolve', ['contest' => $this->contest])
            ->with('success', __("Updated"));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ __("Contest participant works review for contest:") }}
            <br />
            {{ $contest->name_en }}
        </h2>
        <hr class="my-2" />
        <p class="fyk text-xl">
            {{ __("Your org: :organization", ['organization' => $organization->name]) }}
        </p>
        <hr class="my-2" />
        <div class="fyk text-xl">
            {{ __("Before re-insert that Work into the contest, write a Because text.")}}<br>
        </div>
        <hr class="my-4" />
        <x-yapcp.header-link 
            txt="User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link
            txt="Org Dashboards"
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
        <x-yapcp.header-link
            txt="Contest Review Dashboards"
            url="{{ route('organization.contest-work.listed', ['contest' => $contest]) }}" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    ✅ {{ session('success') }}
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

                <h3 class="fyk text-2xl font-medium text-gray-900">
                    {{ __('Resolve Issue question over Contest Work') }}
                </h3>
                <hr class="mb-4" />
                <form wire:submit="solvedContestWaiting">
                    @csrf

                    @if ($sectionIsFull)
                        <x-input-label for="resolvedBecause" :value="__('Remain locked')" />
                        <textarea readonly
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                            type="text" name="resolvedBecause"
                            wire:model="resolvedBecause"
                        >{{ __("This image remains frozen, because the contestant has already used up all the available slots to take part.")}}</textarea>
                    @else
                    <div class="mb-4">
                        <style>textarea {resize:vertical;}</style>
                        <x-input-label for="resolvedBecause" :value="__('Resolution reasoning, english')" />
                        <textarea 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                            type="text" name="resolvedBecause"
                            wire:model="resolvedBecause"
                        ></textarea>
                        <p class="test-sm">{{ __("Input area can be resized. Facultative. ")}}</p>
                        <x-input-error for="resolvedBecause" class="mt-2" />
                    </div>
                    @endif

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Confirm Solution') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
