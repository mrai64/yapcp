<?php

/**
 * Organization Contest Manage | Notify Author that her/him image
 * seem to have one or more trouble
 *
 */

use App\Models\Contest;
use App\Models\ContestWork;
use App\Models\ContestWaiting;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserWork;
use App\Notifications\ContestWarning;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Volt\Component;

new class extends Component {
    //
    public ContestWork $contestWork;
    public Contest $contest;
    public Organization $organization;
    public UserWork $userWork;
    public User $userParticipant;
    public User $userReviewer;
    public $because;
    //
    public function mount(ContestWork $contestWork)
    {
        $this->authorize('update', [Contest::class, $contestWork->contest]);
        $this->contestWork    = $contestWork;
        $this->contest        = Contest::findOrFail($contestWork->contest_id);
        $this->organization   = $this->contest->organization;
        $this->userWork       = $contestWork->userWork;
        $this->userParticipant= $contestWork->userWork->user;
        $this->userReviewer   = Auth::user();
    }
    //
    public function rules()
    {
        return [
            'because' => 'required|string',
        ];
    }
    //
    public function registerAndNotify()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' called');
        $validated = $this->validate();
        Log::debug('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' validated:' . json_encode($validated));

        // integration
        $validated['contest_id']          = $this->contestWork->contest_id;
        $validated['section_id']          = $this->contestWork->section_id;
        $validated['participant_user_id'] = $this->contestWork->user_id;
        $validated['user_work_id']        = $this->contestWork->user_work_id;
        $validated['portfolio_sequence']  = $this->contestWork->portfolio_sequence;
        $validated['email']               = $this->contestWork->userContact->email;
        $validated['organization_user_id'] = Auth::id();
        Log::debug('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' validated:' . json_encode($validated));

        $contestWaiting = ContestWaiting::create($validated);
        Log::debug('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' contestWaiting:' . json_encode($contestWaiting));

        // ContestWarning notification w/ContestWaiting 'emailgram'
        $contestWaiting->notifyNow(new ContestWarning($contestWaiting));

        return redirect()
            ->route('organization.contest-work.listed', ['contest' => $this->contestWork->contest])
            ->with('success', __('Warn Send. Next,...'));

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
            {{ __("Be patient an kind. You are informing an AUTHOR that him/her work IS NOT GOOD.")}}<br>
            {{ __("First, it could be an inadvertent mistake.")}}<br>
            {{ __("Second, there may be time to fix it. Almost always.")}}
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

                <form wire:submit="registerAndNotify">
                    @csrf

                    <div class="mb-4">
                        <p class="fyk">
                            {{ __("Dear Author, ") }}           <br />
                            {{ $contestWork->userWork->user->name }} ,    <br />
                            {{ __("we are sorry to inform you that your work titled") }} <br />
                            {{ $contestWork->userWork->title_en }} <br />
                            {{ __("was parked from our contest because of")}}
                        </p>
                        <style>textarea {resize:vertical;}</style>
                        <textarea 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                            type="text" 
                            name="because"
                            wire:model="because"
                        >{{ old('because') }}</textarea>
                    </div>

                    <x-button class="mt-2 ms-4">
                        {{ __('Check three times. AND count to TEN. Then, SEND.') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
