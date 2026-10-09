<?php

/**
 * Organization Contest Manage
 * Single work review for human review
 * - pass
 *   then a balde register in userWorkValidation the validated work
 * - don't pass
 *   there s any reason for that and reviewer send an email
 *   notification to ContestWork author
 *   and the record is shifted into ContestWaiting
 * 
 */

use App\Models\Contest;
use App\Models\ContestWork;
use App\Models\Organization;
use App\Models\UserWork;
use Livewire\Volt\Component;

new class extends Component {
    //
    public ContestWork $contestWork;
    public Contest $contest;
    public Organization $organization;
    public UserWork $userWork;
    //
    public function mount(ContestWork $contestWork)
    {
        $this->authorize('update', [Contest::class, $contestWork->contest]);
        $this->contestWork = $contestWork;
        $this->contest = Contest::findOrFail($contestWork->contest_id);
        $this->organization = $this->contest->organization;
        $this->userWork = $contestWork->userWork;
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
        <p class="small">
            {{ __("Your org: :organization", ['organization' => $organization->name]) }}
        </p>
        <hr class="mb-4" />
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

                <div class="fyk">
                    <div class="block small w-full px-6">
                    <!-- image -->
                    <a href="{{ asset('storage/photos').'/'.$userWork->file_path }}" 
                        target="_blank" class="w-full h-100" 
                        title='{{ __("Click to view single image") }}'>
                        <img src="{{ asset('storage/photos').'/'. ContestWork::renameMiniature($userWork->file_path ?? '') }}" 
                            title="click to view full size" 
                            class="block w-48 me-3" 
                            loading="lazy"
                            style="float:left" />
                    </a>
                    <!-- image infos -->
                    <em>{{ __("Author")}}:</em>          {{$userWork->country_id}} | {{$userWork->userContact->last_name}}, {{$userWork->userContact->first_name}} <br />
                    <em>{{ __("Intl Title")}}:</em>      {{$userWork->title_en}} <br />
                    <em>{{ __("Local Title")}}:</em>     {{($userWork->title_local) ? $userWork->title_local : "..." }} <br />
                    <em>{{ __("Short size")}}:</em>      {{$userWork->short_size}}
                    <em>{{ __("Long size")}}:</em>       {{$userWork->long_size}}
                </div>
                <br style="clear:both;" />

                <hr class="my-2" />

                <x-yapcp.inline-link
                    txt="✅ COMPLIANT ✅"
                    url="{{ route('organization.user-work-validation.validate', ['contestWork' => $contestWork]) }}" />

                <hr class="my-2" />

                <x-yapcp.inline-link
                    txt="‼️ DEAR AUTHOR ✍️"
                    url="{{ route('organization.contest-waiting.notify', ['contestWork' => $contestWork]) }}" />

                </div>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
