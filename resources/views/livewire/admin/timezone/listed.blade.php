<?php

/**
 * Admin timezone index list
 *
 */

use App\Models\Timezone;
use App\Models\User;
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
    // with() - with every enter for pagination
    public function with()
    {
        return [
            'timezones' => Timezone::withTrashed()
            ->orderBy('id', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate(20)
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Timezones Index | Admin only") }}
        </h2>
        <p class="small">Regions are: Africa, America, Antarctica, Arctit, Asia, Atlantic, Australia, Europe, Indian, Pacific.</p>
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
                    {{ $timezones->links() }}
                </div>

                <table class="data-table-container w-auto">
                    <thead>
                        <tr>
                            <th scope="col" class="data-table-section-counter">{{ __("#")}}</td>
                            <th scope="col" class="data-table-section-code">{{ __("Region")}}</td>
                            <th scope="col" class="data-table-section-country">{{__("Timezone")}}</td>
                            <th scope="col" class="data-table-section-actions">
                                {{ __("Active / Deleted") }}
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timezones as $deltaItem => $timezone)
                        <tr class="border my-2">
                            <td valign="top" class="small px-2">{{ $timezones->firstItem() + $deltaItem }}&nbsp;&nbsp;</td>
                            <td valign="top" class="fyk text-xl px-2">{{ $timezone->region_id }} &nbsp;&nbsp;</td>
                            <td valign="top" class="fyk text-2xl px-2">{{ $timezone->id }}</td>
                            <td valign="top" class="small px-2" >
                                {{ ($timezone->trashed()) ? __("Deleted") : __("Active") }}
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
