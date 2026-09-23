<?php

/**
 * Admin Dashboard
 * 
 */

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public User $admin;
    // mount()
    public function mount()
    {
        $this->admin = Auth::user();
        if (!$this->admin->isAdmin()){
            redirect()
                ->route('user.dashboard')
                ->with('error', __("Sorry, you can't"));
        }
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Your ADMIN Dashboard") }}
        </h2>
        <hr class="my-4" />
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

                <!-- Backup set-->
                <table class="data-table-container w-auto">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <h3 class="fyk text-2xl font-medium w-full">
                                    {{ __("Backups")}}
                                </h3>
                            </td>
                        </tr>
                        <tr class="border">
                            <td>
                                <x-yapcp.inline-link 
                                    txt="Run" 
                                    url="{{ route('admin.backup.contest1st') }}" />
                            </td>
                            <td class="fyk text-xl w-4fifths">
                                {{ __("Contest, ContestPatronage, ContestSection, ContestJury, ContestAward / 1st") }}
                            </td>
                        </tr>
                        <tr class="border">
                            <td>
                                <x-yapcp.inline-link 
                                    txt="Run" 
                                    url="{{ route('admin.backup.user') }}" />
                            </td>
                            <td class="fyk text-xl w-4fifths">
                                {{ __("User, userContact, UserContactMore") }}
                            </td>
                        </tr>
                        <tr class="border">
                            <td>
                                <x-yapcp.inline-link
                                    txt="Run"
                                    url="{{ route('admin.backup.user-work', ['backingUpUser' => 'all' ]) }}" />
                            </td>
                            <td class="fyk text-xl w-4fifths">
                                {{ __("UserWork, UserContact, UserWorkMore") }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr class="my-4" />

                <!-- Import set -->
                <table class="data-table-container w-auto">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <h3 class="fyk text-2xl font-medium w-full">
                                    {{ __("Imports")}}
                                </h3>
                            </td>
                        </tr>
                        <tr class="border">
                            <td>
                                <x-yapcp.inline-link 
                                    txt="Run" 
                                    url="{{ route('admin.import.contest1st') }}" />
                            </td>
                            <td class="fyk text-xl w-4fifths">
                                {{ __("Contest, ContestPatronage, ContestSection, ContestJury, ContestAward / 1st") }}
                            </td>
                        </tr>
                        <tr class="border">
                            <td>
                                <x-yapcp.inline-link 
                                    txt="Run" 
                                    url="{{ route('admin.import.user') }}" />
                            </td>
                            <td class="fyk text-xl w-4fifths">
                                {{ __("User, UserContact, UserContactMore") }}
                            </td>
                        </tr>
                        <tr class="border">
                            <td>
                                <x-yapcp.inline-link 
                                    txt="Run" 
                                    url="{{ route('admin.import.user-edited') }}" />
                            </td>
                            <td class="fyk text-xl w-4fifths">
                                {{ __("EDITED User, UserContact, UserWork, UserWorkMore") }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr class="my-4" />

                <!-- other add / modify -->
                 <table class="data-table-container w-auto">
                    <tbody>
                        <tr>
                            <td>
                                <h3 class="fyk text-2xl font-medium w-full">
                                    {{ __("You can also...")}}
                                </h3>
                            </td>
                        </tr>
                        <tr class="border">
                            <td>
                                <x-yapcp.inline-link 
                                    txt="User Contact Index" 
                                    url="{{ route('admin.user-contact.listed') }}" />
                            </td>
                        </tr>
                        <tr class="border">
                            <td>
                                <x-yapcp.inline-link 
                                    txt="Add Federation" 
                                    url="{{ route('federation.add') }}" />
                                <x-yapcp.inline-link 
                                    txt="Modify Federation" 
                                    url="{{ route('federation.listed') }}" />
                            </td>
                        </tr>
                        <tr class="border">
                            <td>
                                <x-yapcp.inline-link 
                                    txt="Add Fed Section" 
                                    url="{{ route('federation.listed') }}" />
                                <x-yapcp.inline-link 
                                    txt="Modify Fed Section" 
                                    url="{{ route('federation.listed') }}" />
                            </td>
                        </tr>
                        <tr class="border">
                            <td>
                                <x-yapcp.inline-link 
                                    txt="Add 'Fed More'" 
                                    url="{{ route('federation.listed') }}" />
                                <x-yapcp.inline-link 
                                    txt="Modify 'Fed More'" 
                                    url="{{ route('federation.listed') }}" />
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
