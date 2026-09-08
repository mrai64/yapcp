<?php

/**
 * Organization Contest Design / modify a juror in ContestJury
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
use Livewire\Volt\Component;

new class () extends Component {
    public Contest $contest;
    public ContestJury $contestJury;
    public ContestSection $contestSection;
    public Organization $organization;
    public UserContact $userContact;
    public string $contestJurorEmail;
    public string $contestJurorFirstName;
    public string $contestJurorLastName;
    public string $contestJurorCountryId;
    // form fields
    public string $contestJurorIsPresident;
    public string $contestJurorQualify;

    public function mount(ContestJury $contest_jury)
    {
        // policy
        $this->authorize('update', [ContestJury::class, $contest_jury]);
        //
        $this->contestJury    = $contest_jury;
        $this->contestSection = $contest_jury->contestSection;
        $this->contest        = $contest_jury->contest;
        $this->organization   = $this->contest->organization;
        $this->userContact    = $this->contestJury->userContact;
        //
        $this->contestJurorIsPresident = $this->contestJury->is_president;
        $this->contestJurorQualify     = $this->contestJury->qualify;
    }

    //
    public function rules()
    {
        return [
            'contestJurorIsPresident'  => 'nullable|boolean',
            'contestJurorQualify'  => 'required|string|min:2|max:255',
        ];
    }

    public function resignContestJury()
    {
        // for db::transaction()
        $data = [
            'userId' => $this->userContact->id,
            'contestId' => $this->contest->id,
            'contestJury' => $this->contestJury,
        ];
        $res = DB::transaction( function () use ($data){
        // 1st of 2 the juror is out
        $userRole = UserRole::where('user_id', $data['userId'])
            ->where('role', 'juror')
            ->where('contest_id', $data['contestId'])
            ->first();
        $userRole->update([
            'role_opening' => now()->format('Y-m-d\TH:i'),
            'role_closing' => now()->format('Y-m-d\TH:i'),
        ]);
        // 2nd of 2
        $data['contestJury']->delete();
        }); // db::transaction
        //
        redirect()
            ->route('organization.design.contest-jury.listed', ['contest' => $this->contest])
            ->with('success', __('Juror retired.'));
    } // resignContestJury

    public function modifyContestJury()
    {
        $validated = $this->validate();
        // if null become false
        $validated['contestJurorIsPresident'] = $validated['contestJurorIsPresident'] ?? false;

        // 1. creazione giurato
        $this->contestJury->update([
            'is_president' => (bool) $validated['contestJurorIsPresident'],
            'qualify' => $validated['contestJurorQualify'],
        ]);

        redirect()
            ->route('organization.design.contest-jury.listed', ['contest' => $this->contest])
            ->with('success', __('Juror updated.'));
    } // modifyContestJury
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify Contest Juror / Resign or correct') }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.organization.design.contest-nav :contest="$contest" active="juries" />
        <hr class="mb-2" />
        <livewire:organization.design.contest-jury.jury-nav :contest="$contest" />
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
                    {{ __('Modify Contest Juror for: :code :section', ['code' => $contestSection->code, 'section' => $contestSection->name_en]) }}
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
                        <tr class="border">
                            <td class="fyk text-2xl font-medium text-gray-900 w-60" scope="row" valign="top">
                                {{ __("Qualify") }}
                            </td>
                            <td class="fyk text-2xl font-medium text-gray-900 w-auto" scope="row" valign="top">
                                {{ $contestJury->qualify }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr class="mb-4" />

                <form wire:submit="resignContestJury">
                    @csrf
                    <x-button class="mt-2 ms-4">
                        {{ __('Juror Resign') }}
                    </x-button>
                </form>

                <hr class="mt-4 mb-4" />

                <h3 class="fyk text-2xl font-medium text-gray-900">
                    {{ __("Change Juror record") }}
                </h3>

                <form wire:submit="modifyContestJury">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="contestJurorQualify" :value="__('Juror qualifing status')" />
                        <x-text-input wire:model="contestJurorQualify" id="contestJurorQualify" name="contestJurorQualify" 
                            class="block mt-1 w-full" type="text" required />
                        <x-input-error for="contestJurorQualify" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="contestJurorIsPresident" :value="__('Is Jury President?')" />
                            <x-checkbox wire:model.live="contestJurorIsPresident" id="contestJurorIsPresident" name="contestJurorIsPresident" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                            {{ __('Yes, only and unique Jury President') }}
                        </label>
                        <x-input-error for="contestJurorIsPresident" class="mt-2" />
                    </div>

                    <x-button class="mt-2 ms-4">
                        {{ __('Juror modify') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
