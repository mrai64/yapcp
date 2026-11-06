<?php

/**
 * Start a job to create participant board
 *   a full length web page stored in contest folder
 *
 */

use App\Jobs\WriteParticipantBoardResultJob;
use App\Models\Contest;
use App\Models\Organization;
use Livewire\Volt\Component;
use Illuminate\Bus\Batch;


new class extends Component {
    //
    public Contest $contest;
    public Organization $organization;
    //
    public function mount(Contest $contest) // route()
    {
        // can - cannot
        $this->authorize('update', [Contest::class, $contest]);
        //
        $this->contest = $contest;
        $this->organization = $this->contest->organization;
    }
    // 
    public function generateStaticParticipantsBoards()
    {
        Bus::batch([
            new WriteParticipantBoardResultJob($this->contest),
        ])->then(function (Batch $batch) { // <-- Qui c'è l'errore
            // ...
        })->dispatch();

        session()->flash('success', __("Started Job for Participation Board static page generation"));

    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ $contest->name_en }}
        </h2>
        <h3 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
            {{ __("Generation of Participation Board") }}
        </h3>
        <hr class="mb-4" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link 
            txt="Back to Org Dashboard" 
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
        <x-yapcp.header-link 
            txt="Final Minute Draft" 
            url="{{ route('organization.contest-award.minute', ['contest' => $contest]) }}" />
        <x-yapcp.header-link 
            txt="Contest doc folder" 
            url="{{ route('organization.docs.listed', ['contest' => $contest]) }}" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    ✅ {{ session('success') }}
                </div>
                <hr class="mb-4" />
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

                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="p-2 my-2 border">
                            <td valign="top" class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ __("Generate a static html page, check the url ")}} <br />
                                'https://yapcp.test/contests/{{$contest->id}}/participants_board.html' <br />
                                <x-yapcp.inline-link 
                                    txt="Check" 
                                    url="https://yapcp.test/contests/{{$contest->id}}/participants_board.html" 
                                    />
                            </td>
                        </tr>
                        <tr class="p-2 my-2 border">
                            <td valign="top" class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                <x-yapcp.inline-link 
                                    txt="Generate / regenerate" 
                                    url="#" 
                                    wire:click="generateStaticParticipantsBoards"
                                    />
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>