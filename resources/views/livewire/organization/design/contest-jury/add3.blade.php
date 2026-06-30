<?php

/**
 * Organization Contest Design / add a juror to ContestJury
 * last of 3 - check personal data then build
 * 
 */

use App\Models\Contest;
use App\Models\ContestJury;
use App\Models\ContestSection;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Session;

use Livewire\Volt\Component;

new class extends Component {
    public Contest $contest;
    public ContestSection $contestSection;
    public Organization $organization;
    // form fields
    public UserContact $userContact;
    public string $contestJurorEmail;
    public string $contestJurorFirstName;
    public string $contestJurorLastName;
    public string $contestJurorCountryId;

    public function mount(ContestSection $contest_section)
    {
        // header
        $this->contestSection = $contest_section;
        $this->contest = $contest_section->contest;
        $this->organization = $this->contest->organization;
        // form fields
        $user_contact_id = session()->get('contest_juror_id');
        $this->userContact = UserContact::where('id', $user_contact_id)->first();


    }
    public function addContestJury()
    {
        // maybe insert contestJury, then thru observer add userRoles
        // but that solution is atomic, "all or nothing"
        $data = [
            'contestId' => $this->contest->id,
            'sectionId' => $this->contestSection->id,
            'userId' => $this->userContact->id,
            'opening' => $this->contest->day_3_jury_opening,
            'closing' => $this->contest->day_4_jury_closing,
        ];

        $res = DB::transaction(function () use ($data) {

            // 1. creazione giurato
            $contestJury = ContestJury::create([
                'contest_id' => $data['contestId'],
                'section_id' => $data['sectionId'],
                'user_id' => $data['userId'],
                'is_president' => false,
            ]);

            // 2. creazione userRole
            $userRole = UserRole::create([
                'user_id' => $data['userId'],
                'role'    => 'juror', 
                'organization_id' => null,
                'contest_id' => $data['contestId'],
                'federation_id' => null,
                'role_opening' => $data['opening'], // default: now()
                'role_closing' => $data['closing'], // default: 9999-12-31 23:59:59
            ]);

            return $contestJury;
        });

        // clean
        session()->forget('contest_juror_id');
        session()->forget('contest_juror_email');

        redirect()
            ->route('organization.design.contest-jury.listed', ['contest' => $this->contest])
            ->with('success', __('Juror added.'));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Add Contest Juror / last of 3') }}
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

                <h2 class="fyk text-2xl font-medium text-gray-900">
                    {{ __('Add Contest Juror for: :code :section', ['code' => $contestSection->code, 'section' => $contestSection->name_en]) }}
                </h2>

                <p class="small">{{ __("") }}</p>
                <table class="data-table-container w-auto">
                    <tbody>
                        <tr class="border">
                            <td class="fyk text-2xl font-medium text-gray-900 w-60" scope="row" valign="top">
                                {{ __("Last Name") }}
                            </td>
                            <td class="fyk text-2xl font-medium text-gray-900 w-auto" scope="row" valign="top">
                                {{ $userContact->last_name }}
                            </td>
                        </tr>
                        <tr class="border">
                            <td class="fyk text-2xl font-medium text-gray-900 w-60" scope="row" valign="top">
                                {{ __("First Name") }}
                            </td>
                            <td class="fyk text-2xl font-medium text-gray-900 w-auto" scope="row" valign="top">
                                {{ $userContact->first_name }}
                            </td>
                        </tr>
                        <tr class="border">
                            <td class="fyk text-2xl font-medium text-gray-900 w-60" scope="row" valign="top">
                                {{ __("Email") }}
                            </td>
                            <td class="fyk text-2xl font-medium text-gray-900 w-auto" scope="row" valign="top">
                                {{ $userContact->email }}
                            </td>
                        </tr>
                        <tr class="border">
                            <td class="fyk text-2xl font-medium text-gray-900 w-60" scope="row" valign="top">
                                {{ __("From") }}
                            </td>
                            <td class="fyk text-2xl font-medium text-gray-900 w-auto" scope="row" valign="top">
                                {{ $userContact->country->flag_code  }}
                                {{ $userContact->country->country }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!--  -->
                <form wire:submit="addContestJury">
                    @csrf

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
