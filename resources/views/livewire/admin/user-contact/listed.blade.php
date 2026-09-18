<?php

/**
 * Admin User index list
 *
 */

use App\Models\User;
use App\Models\UserContact;
use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    //
    use WithPagination;

    public User $userAdmin;

    // mount() - only the first
    public function mount()
    {
        $this->userAdmin = Auth::user(); // connected user
    }

    // with() - with every enter
    public function with()
    {
        return [
            'userContacts' => UserContact::withTrashed()
            ->with([
                'country', // user_contacts.country()
                'user' => fn($query) => $query->withTrashed() // return implicito 
            ])
            ->orderBy('country_id', 'asc')
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate(20)
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("User Contact Index | Admin only") }}
        </h2>
        <hr class="my-4" />
        <x-yapcp.header-link
            txt="Back to User dashboard"
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link
            txt="Back to ADMIN dashboard"
            url="{{ route('admin.dashboard') }}" />
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

                <div class="paginationDiv">
                    {{ $userContacts->links() }}
                </div>

                <table class="data-table-container w-auto">
                    <thead>
                        <tr>
                            <th scope="col" class="data-table-section-counter">{{ __("#")}}</td>
                            <th scope="col" class="data-table-section-country">{{ __("Country")}}</td>
                            <th scope="col" class="data-table-section-name">{{__("Surname, Name")}}</td>
                            <th scope="col" class="data-table-section-actions">
                                {{__("Action")}}
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4">
                                <x-yapcp.inline-link
                                    txt="All Work Backup"
                                    url="{{ route('admin.backup.user-work', ['backuppedUser' => 'all' ]) }}" />
                            </td>
                        </tr>
                        @foreach($userContacts as $deltaItem => $uc)
                        <tr class="border my-2">
                            <td valign="top" class="small">{{ $userContacts->firstItem() + $deltaItem }}&nbsp;&nbsp;</td>
                            <td valign="top" class="small">{{ $uc->country->flag_code }} {{ $uc->country->country }}&nbsp;&nbsp;</td>
                            <td valign="top" class="small">
                                {{ $uc->last_name }}, {{ $uc->first_name }} - {{ $uc->email }}
                                <br />
                                {{ ($uc->city) ? $uc->city : __('city...') }} - {{ ($uc->address) ? $uc->address : __('address...') }}
                            </td>
                            <td valign="top" >
                            @if ($uc->trashed())
                                <x-yapcp.inline-link
                                    txt="Restore"
                                    url="#" />
                            @else
                                <x-yapcp.inline-link
                                    txt="Modify"
                                    url="#" />
                            @endif
                                <x-yapcp.inline-link
                                    txt="Work Backup"
                                    url="{{ route('admin.backup.user-work', ['backuppedUser' => $uc->user ]) }}" />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
