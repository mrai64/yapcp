<?php

/**
 * Organization Contest Design / Remove a juror from ContestJury
 *
 * Maybe replyed in Organizatino Contest Manage
 *
 */

use App\Models\Contest;
use App\Models\ContestJury;
use App\Models\ContestSection;
use App\Models\Organization;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Volt\Component;

new class extends Component {
    //
    public  Contest        $contest;
    public ?ContestSection $section;
    public  Organization   $organization;
    //
    public ContestJury    $contestJury;
    //
    public function mount(ContestJury $contest_jury)
    {
        $this->contestJury     = $contest_jury;
        $this->section         = $this->contestJury->contestSection;
        $this->contest         = $contest_jury->contest;
        $this->organization    = $this->contest->organization;
    }
    //
    public function removeContestJury()
    {
        $now = Carbon::now();
        $oneSecondAgo = $now->copy()->subSecond();
        $data = [
            'contestJury'        => $this->contestJury,
            'contestId'    => $this->contest->id,
            'sectionId'    => $this->contestJury->section_id,
            'userId'       => $this->contestJury->user_id,
            'oneSecondAgo' => $oneSecondAgo,
        ];
        $res = DB::transaction(function () use ($data){
            // update UserRole
            $userRole = UserRole::where('user_id', $data['userId'])
                ->where('role', 'juror')
                ->where('contest_id', $data['contestId'])
                ->firstOrFail();

            if ($userRole->role_opening > $data['oneSecondAgo']) {
                $userRole->role_opening = $data['oneSecondAgo'];
            }
            $userRole->role_closing = $data['oneSecondAgo'];
            $userRole->save();

            // update ContestJury
            $this->contestJury->delete();
        });
        //
        return redirect()
            ->route('organization.design.contest-jury.listed', ['contest' => $this->contest ])
            ->with('success', __('Juror removed, as confirmed.'));
        //
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify Contest infos') }}
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

                <h3 class="fyk text-2xl font-medium text-red-500">
                    {{ __('‼️ Remove a Juror') }}
                </h3>
                <p class="w-auto inline-float">
                    {{ ($contestJury->is_president) ? __("Jury President") : __("Juror") }} 
                    {{ __("From") }}
                    {{ $contestJury->userContact->country->flag_code }} 
                    {{ $contestJury->userContact->country->country }} <br>
                    {{ $contestJury->userContact->last_name }}, 
                    {{ $contestJury->userContact->first_name }}<br>
                </p>

                <form wire:submit="removeContestJury">
                    @csrf
                    <x-button class="mt-2 ms-4">
                        {{ __('Are you SURE!? Remove Juror. Are You SURE?') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
