<?php

/**
 * Federation listed
 * 
 */

use App\Models\Federation;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    // mount() no
    // with() yes
    public function with()
    {
        return [
            'isAdmin' => Auth::user()->isAdmin(),
            'allFederationsSet' => Federation::query()
                ->with(['country'])
                ->withCount([
                    'contests as active_contests_count' => function ($q) {
                        $today = now()->startOfDay();
                        $q->whereDate('day_1_opening', '<=', $today)
                          ->whereDate('day_8_closing', '>=', $today);
                    }
                ])
                ->orderBy('country_id', 'asc')
                ->orderBy('name_en', 'asc')
                ->paginate(10),
        ];
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ __('Federations' ) }}
        </h2>
        <p class="small">
            {{ __("Ordered by country_id, then federation name.") }}
            <br />
            {{ __("Below the federations are the sections and themes defined by the federations, which are binding only for competitions sponsored by the federations.") }}
        </p>
        <hr class="mb-4 mt-4" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
        @if ($isAdmin)
        <x-yapcp.header-link 
            txt="Add New Federation" 
            url="{{ route('federation.add') }}" />
        @endif
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

                @if ($allFederationsSet->isEmpty())
                <h3 class="fyk text-2xl font-medium text-gray-900">
                    {{ __("There are no Federation in platform, at now. Check the manual to run Federation*Seeker or add first manually.") }}
                </h3>
                @else
                <dl class="space-y-6">
                    @foreach ($allFederationsSet as $federation)
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-500 hover:border-indigo-300 transition-colors relative">

                            <table class="data-table-container w-full">
                                <tbody>
                                    <tr>
                                        <td class="fyk text-2xl font-bold w-60">
                                            {{ $federation->country?->flag_code }} {{ $federation->country?->country }}
                                        </td>
                                        <td class="fyk text-2xl font-bold w-auto">
                                            {{ $federation->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="">
                                            &nbsp;
                                        </td>
                                        <td class="fyk text-2xl font-bold">
                                            {{ $federation->name_en }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-60">
                                            {{ __('Official website') }}:
                                        </td>
                                        <td class="w-auto">
                                            {{ ($federation->website) ? $federation->website : 'N\A'}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-60">
                                            {{ __('Contact Info') }}:
                                        </td>
                                        <td class="w-auto">
                                            {{ $federation->contact_info ? $federation->contact_info : 'N\A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-60">
                                            {{ __('Timezone') }}:
                                        </td>
                                        <td class="w-auto">
                                            {{ ($federation->timezone_id) ? $federation->timezone_id : 'N\A'}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-60">
                                            {{ __('Local Name') }} [ {{ ($federation->local_lang) ? $federation->local_lang : 'N\A'}} ]: 
                                        </td>
                                        <td class="w-auto">
                                            <span lang="{{$federation->local_lang}}">
                                                {{ ($federation->name_local) ? $federation->name_local : 'N\A'}}
                                            </span>
                                        </td>
                                    </tr>
                                    @if ($isAdmin)
                                    <tr>
                                        <td colspan="2">
                                            <x-yapcp.inline-link 
                                                txt="Update" 
                                                url="{{ route('federation.modify', ['federation' => $federation ]) }}" />
                                            @if ($federation->active_contests_count)
                                            <x-yapcp.inline-link 
                                                txt="Disabled Remove for Open contests now" 
                                                url="#" />
                                            @else
                                            <x-yapcp.inline-link 
                                                txt="0 contest open - Removable" 
                                                url="{{ route('federation.remove', ['federation' => $federation ]) }}" />
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="2">
                                            <x-yapcp.inline-link 
                                                txt="Federation Sections" 
                                                url="{{ route('federation-section.listed', ['federation' => $federation ]) }}" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    @endforeach

                    <div class="mt-8">
                        {{ $allFederationsSet->links() }}
                    </div>

                </dl>
                @endif
                <!-- -->

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
