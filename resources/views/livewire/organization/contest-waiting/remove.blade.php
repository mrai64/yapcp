<?php

/**
 * Organization Contest Manage - ContestWaiting list, for remove
 *
 */

use App\Models\Contest;
use App\Models\ContestWaiting;
use App\Models\Organization;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    //
    public Contest $contest;
    public $contestWaitingSet;
    public Organization $organization;
    //
    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $this->contest->organization;
    }
    //
    public function with(): array
    {
        return [
            'contestWaitingSet' => ContestWaiting::query()
                ->with(['userWork'])
                ->where('contest_id', $this->contest->id)
                ->orderBy('section_id')
                ->paginate(6),
        ];
    }
    //
    public function revokeContestWaiting(string $sectionId, string $userWorkId)
    {
        ContestWaiting::where('section_id', $sectionId)
            ->where('user_work_id', $userWorkId)
            ->delete();
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
            {{ __("These are the troubled title of image that be solved.")}}<br>
            {{ __("Look at the right line then click the Solved button.")}}
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

                <!-- -->
                @if ($contestWaitingSet->isEmpty())
                <h3 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
                    {{ __("No works to recover") }}
                </h3>
                @else
                <div class="paginationDiv">
                    {{ $contestWaitingSet->links() }}
                </div>

                <table class="data-table-container w-auto">
                    <tbody>
                    @foreach ($contestWaitingSet as $deltaItem => $contestWaiting)
                        <tr class="border my-2" wire:key="waiting-{{ $contestWaiting->section_id }}-{{ $contestWaiting->user_work_id }}">
                            <td valign="top" class="pe-4">{{ $contestWaitingSet->firstItem() + $deltaItem }}</td>
                            <td valign="top" >
                                <form wire:submit.prevent="revokeContestWaiting('{{ $contestWaiting->section_id }}', '{{ $contestWaiting->user_work_id }}')">
                                    <x-button class="mb-4 mx-4">
                                        {{ __("✅ SOLVED ✅") }}
                                    </x-button>
                                </form>
                            </td>
                            <td valign="top" class="fyk text-2xl ms-4">{{ $contestWaiting->userWork->title_en }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
