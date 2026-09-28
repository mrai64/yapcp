<?php

/**
 * Admin Federation More fields index list
 *
 */

use App\Models\FederationMore;
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
            'federationMoreSet' => FederationMore::withTrashed()
            ->orderBy('federation_id', 'asc')
            ->orderBy('referenced', 'asc')
            ->orderBy('field_label', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate(5)
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("'Federation More' Index | Admin only") }}
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
                    {{ $federationMoreSet->links() }}
                </div>

                <table class="data-table-container w-auto">
                    <tbody>
                        @foreach ($federationMoreSet as $deltaItem => $fedMore)
                        <tr class="border">
                            <td valign="top" class="pe-4" >{{ $federationMoreSet->firstItem() + $deltaItem }}</td>
                            <td valign="top" class="fyk text-xl" colspan="2" >
                                {{ $fedMore->federation_id }}
                                &gt;
                                {{ $fedMore->field_label }}
                            </td>
                            <td valign="top">{{ ($fedMore->trashed()) ? __("Deleted") : __("Active") }}</td>
                        </tr>
                        <tr class="border">
                            <td valign="top" class="" >&nbsp;</td>
                            <td valign="top" class="fyk text-right" > federation_id: </td>
                            <td valign="top" class="fyk text-xl" > "{{ $fedMore->federation_id }}" </td>
                            <td valign="top" class="" >&nbsp;</td>
                        </tr>
                        <tr class="border">
                            <td valign="top" class="" >&nbsp;</td>
                            <td valign="top" class="fyk text-right" > referenced: </td>
                            <td valign="top" class="fyk text-xl" > "{{ $fedMore->referenced }}" </td>
                            <td valign="top" class="" >&nbsp;</td>
                        </tr>
                        <tr class="border">
                            <td valign="top" class="" >&nbsp;</td>
                            <td valign="top" class="fyk text-right" > field_name: </td>
                            <td valign="top" class="fyk text-xl" > "{{ $fedMore->field_name }}" </td>
                            <td valign="top" class="" >&nbsp;</td>
                        </tr>
                        <tr class="border">
                            <td valign="top" class="" >&nbsp;</td>
                            <td valign="top" class="fyk text-right" > field_default_value: </td>
                            <td valign="top" class="fyk text-xl" > "{{ $fedMore->field_default_value }}" </td>
                            <td valign="top" class="" >&nbsp;</td>
                        </tr>
                        <tr class="border">
                            <td valign="top" class="" >&nbsp;</td>
                            <td valign="top" class="fyk text-right" > suggest: </td>
                            <td valign="top" class="fyk text-xl" > "{{ $fedMore->field_suggest }}" </td>
                            <td valign="top" class="" >&nbsp;</td>
                        </tr>
                        <tr class="border">
                            <td valign="top" class="" >&nbsp;</td>
                            <td valign="top" class="fyk text-right" > Laravel validation rules: </td>
                            <td valign="top" class="fyk text-xl" > "{{ $fedMore->field_validation_rules }}" </td>
                            <td valign="top" class="" >&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="small">&nbsp;</td>
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
