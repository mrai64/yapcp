<?php

/**
 * Organization manage Contest - before Jury works
 *
 * Here is listed in paginated way the works to be validated,
 * for what is only human checkable.
 * 
 * Check for:
 * - ContestWorks,
 * - ContestWorkWaiting,
 * - UserWorkValidated.
 * Paginated: ContestWork not present in ContestWorkWaiting and
 *   in UserWorkValidated (to reduce list).
 *
 */

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\ContestWaiting;
use App\Models\UserWorkValidation;
use Illuminate\Support\Facades\Log;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    //
    public Contest $contest;
    public $federationSections     = [];
    public $contestWorkUserWorkIds = [];
    //
    public function work(Contest $contest)
    {
        $this->contest = $contest;
        $this->authorize('update', [Contest::class, $this->contest]);
    }
    //
    public function with(): array
    {
        $federationSectionsSet = ContestSection::query()
            ->whereNotNull('federation_section_id')
            ->get();

        $this->federationSections = collect($federationSectionsSet)
            ->pluck('federation_section_id')
            ->unique()
            ->toArray();

        if (! $this->federationSections){
            Log::info(__FUNCTION__.':'.__LINE__.' federationSections formatted');
            $this->federationSections = [];
        }

        $contestWorkSet = ContestWork::where('contest_id', $this->contest->id)
            ->get();
        $this->contestWorkUserWorkIds = collect($contestWorkSet)
            ->pluck('user_work_id')
            ->unique()
            ->toArray();

        if (is_null($this->contestWorkUserWorkIds)) {
            Log::info(__FUNCTION__.':'.__LINE__.' contestWorkUserWorkIds formatted');
            $this->contestWorkUserWorkIds = [];
        }
        // updated values
        $contestWaitingsSet = ContestWaiting::query()
            ->where('contest_id', $this->contest->id)
            ->get();

        $contestWaitingIds = collect($contestWaitingsSet)
            ->pluck('user_work_id')
            ->unique()
            ->toArray();

        $userWorkValidatedSet = UserWorkValidation::query()
            ->whereIn('user_work_id', $this->contestWorkUserWorkIds)
            ->whereIn('federation_section_id', $this->federationSections)
            ->get();

        $validatedUserWorkIds = collect($userWorkValidatedSet)
            ->pluck('user_work_id')
            ->unique()
            ->toArray();

        $excludedUserWorkIds = array_unique(array_merge($contestWaitingIds, $validatedUserWorkIds));

        return [
            'contest' => $this->contest,
            'organization' => $this->contest->organization,
            'contestWorks' => ContestWork::query()
                ->with(['userWork'])
                ->where('contest_id', $this->contest->id)
                ->whereNotIn('user_work_id', $excludedUserWorkIds)
                ->orderBy('updated_at')
                ->paginate(6),
        ];
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

                <div class="paginationDiv">
                    {{ $contestWorks->links() }}
                </div>

                @if ($contestWorks->isEmpty())
                <h3 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
                    {{ __("No works to review") }}
                </h3>
                @else
                <table class="data-table-container w-auto">
                    <tbody>
                @foreach ($contestWorks as $deltaItem => $contestWork)
                    <tr class="border my-2">
                        <td valign="top" class="pe-4">{{ $contestWorks->firstItem() + $deltaItem }}</td>
                        <td valign="top" >
                            <x-yapcp.header-link
                                txt="Review"
                                url="{{ route('organization.contest-work.review', ['contestWork' => $contestWork]) }}" />
                        </td>
                        <td valign="top" class="fyk">{{ $contestWork->userWork->title_en }}</td>
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
