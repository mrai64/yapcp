<?php

/**
 * Organization dashboard
 * 
 * access granted to alla organization members and admin
 * 
 */

use App\Models\Contest;
use App\Models\Organization;
use App\Models\UserContact;
use App\Models\UserRole;
use Carbon\CarbonImmutable;
use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


new class extends Component {

    public Organization $organization;
    public UserContact $userContact;
    public $organizationMembersList;
    public $designContestsSet;
    public $runningContestsSet;
    public $pastContestsSet;

    public function mount(Organization $organization)
    {
        $this->organization = $organization;
        $this->userContact = Auth::user()->contact;

        $now = now();

        $this->organizationMembersList = UserContact::query()
        ->with(['userRoles' => function ($query) use ($now) {
            $query->where('role_opening', '<=', $now)
                   ->where('organization_id', $this->organization->id)
                   ->where('role_closing', '>=', $now);
        }])
        ->whereHas('userRoles', function (Builder $query) use ($now) {
            $query->where('role_opening', '<=', $now)
                   ->where('organization_id', $this->organization->id)
                   ->where('role_closing', '>=', $now);
            })
            ->orderBy('user_contacts.last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->get();
        
        // contest in design have now < day_1_opening
        $this->designContestsSet = Contest::query()
            ->where('organization_id', $organization->id)
            ->where('day_1_opening', '>', $now)
            ->orderBy('day_1_opening')
            ->get();


        // contest running have now >= day_1_opening and
        //                      now <= day_8_closing
        $this->runningContestsSet = Contest::query()
            ->where('organization_id', $organization->id)
            ->where('day_1_opening', '<=', $now)
            ->where('day_8_closing', '>=', $now)
            ->orderBy('day_1_opening')
            ->get();

        // past contest have now > day_8_closing
        $this->pastContestsSet = Contest::query()
            ->where('organization_id', $organization->id)
            ->where('day_8_closing', '<', $now)
            ->orderBy('day_1_opening')
            ->get();

    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ __(':name Dashboard' , ['name' => $organization->name] ) }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
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

                <h3 class="fyk text-2xl font-bold mb-4">
                    {{ __("Members") }}
                </h3>
                <x-yapcp.inline-link 
                    txt="Members list" 
                    url="{{ route('organization.user.listed', ['organization' => $organization]) }}" />
                <x-yapcp.inline-link 
                    txt="Add new Member" 
                    url="{{ route('organization.user.add', ['organization' => $organization]) }}" />
                <dl class="space-y-6">
                    @foreach ($organizationMembersList as $organizationMember)
                    <div class="sm:col-span-1 mb-4">
                        <dt class="mt-1 text-lg text-gray-900 font-semibold">{{ $organizationMember->last_name }}, {{ $organizationMember->first_name }}</dt>
                        @foreach ($organizationMember->userRoles as $userRole)
                        <dd class="text-sm font-medium text-gray-500">{{ $userRole->role }}, {{ __('upto') }} {{ $userRole->role_closing->format('Y-m-d') }}</dd>
                        @endforeach
                    </div>
                    @endforeach
                </dl>

                <h3 class="fyk text-2xl font-bold mb-4">
                    {{ __("Contests") }}
                </h3>
                <x-yapcp.inline-link 
                    txt="Contests List" 
                    url="{{ route('organization.contest.listed', ['organization' => $organization]) }}" />
                <x-yapcp.inline-link 
                    txt="Design new Contest" 
                    url="{{ route('organization.design.contest.make', ['organization' => $organization]) }}" />
                @if ($designContestsSet->isNotEmpty())
                <h3 class="fyk text-2xl font-bold mb-4">
                    {{ __("Future Contests") }}
                </h3>
                    @foreach ($designContestsSet as $contest)
                    <x-yapcp.inline-link 
                        txt="{{ ($contest->name_en) ? $contest->name_en : $contest->id }}" 
                        url="{{ route('organization.design.contest.modify-name', ['contest' => $contest]) }}" />
                    @endforeach
                @endif



                <h3 class="fyk text-2xl font-bold mb-4">
                    {{ __("Organization") }}
                </h3>
                <x-yapcp.inline-link 
                    txt="Update Org Infos" 
                    url="{{ route('organization.modify', ['organization' => $organization]) }}" />

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
