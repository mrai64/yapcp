<?php

/**
 * Organization - User Add
 * 
 * The Auth::id() user is added to organization as member
 */

use App\Models\Organization;
use App\Models\UserContact;
use App\Models\UserRole;
use App\Models\UserRolesContextSet;
use App\Models\UserRolesRoleContext; // aka UserRolesRoleContextSets
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

new class extends Component {
    //
    public Organization $organization;
    public UserRole     $userRole;
    public UserContact  $userContact;
    public              $roleSet;
    //
    public $userRoleRole;

    // mount()
    public function mount(Organization $organization)
    {
        $this->organization = $organization;
        $this->userContact = Auth::user()->contact;
        if (Auth::user()->isAdmin()) {
            $this->roleSet = UserRolesRoleContext::where('context_type', 'organizations')
                ->where('green', true)
                ->whereNull('deleted_at')
                ->get();
            //
        } else {
            // others non admin
            $this->roleSet = UserRolesRoleContext::where('context_type', 'organizations')
                ->where('green', true)
                ->whereNot('role', 'admin')
                ->whereNull('deleted_at')
                ->get();
            //
        }
    }
    // render no
    // validate
    public function rules()
    {
        return [
            'userRoleRole' => 'required|string|exists:user_roles_role_sets,role'
        ];
    }
    // addUserToOrganizationInUserRole()
    public function addUserToOrganizationInUserRole()
    {
        $validated = $this->validate();

        // Definisci le date di apertura e chiusura (es. da form oppure di default)
        $opening = now();
        $closing = Carbon::parse('9999-12-31 23:59:59'); // in a time far, far, far away

        // Creazione del ruolo con gestione automatica delle sovrapposizioni
        $roleCreate = UserRole::createWithOverlaps([
            'user_id'         => $this->userContact->id,
            'role'            => $validated['userRoleRole'],
            'organization_id' => $this->organization->id,
            'contest_id'      => null,
            'federation_id'   => null,
            'role_opening'    => $opening,
            'role_closing'    => $closing,
        ]);

        // back to user dashboard
        return redirect()
            ->route('user.dashboard')
            ->with('success', __('New role :role added to you, enjoy!', ['role' => $validated['userRoleRole']]));
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Add you as ... in Organization") }}
            <br />
            {{ $organization->country->flag_code }}
            {{ $organization->name }}
        </h2>
        <p class="small">
            {{ __("Pick your role in organization, from") }}
        </p>
        <hr class="mb-4 mt-4" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link 
            txt="Back to Organization List" 
            url="{{ route('organization.listed') }}" />
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    {{ session('success') }}
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
                <form wire:submit="addUserToOrganizationInUserRole">
                    @csrf

                    <p class="fyk text-2xl font-medium text-gray-900">
                        {{ __('Add me as') }}
                    </p>

                    <div class="mb-4">
                        <select 
                            class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48'
                            id="userRoleRole"
                            name="userRoleRole"
                            wire:model="userRoleRole"
                            required >

                            <option value="">{{ __("...") }}</option>
                            @foreach ($roleSet as $role)
                                <option value="{{ $role->role }}" >
                                    {{ Str::ucfirst((string) $role->role) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="userRoleRole" class="mt-2" />
                    </div>

                    <p class="fyk text-2xl font-medium text-gray-900">
                        {{ __("into Organization") }}
                        <br />
                        {{ $organization->country->flag_code }}
                        {{ $organization->name }}
                    </p>
                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Add me as .. To') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
