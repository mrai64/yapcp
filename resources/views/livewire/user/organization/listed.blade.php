<?php

/**
 * User Organization List
 *
 * Order by country and organization name
 *
 */

use App\Models\Organization;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    // mount() no
    // render() no
    // with() yes
    /**
     * list exclude all names like .admin 
     * but also .organization .federation and so on
     *
     * ascii('/') > ascii('.') 
     * @return array
     */
    public function with(): array
    {
        return [
            'allOrganizationSet' => Organization::query()
                ->with(['country'])
                ->where('name', '>', '/')
                ->orderBy('country_id', 'asc')
                ->orderBy('name', 'asc')
                ->paginate(10),
        ];
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Organizations") }}
        </h2>
        <p class="small">
            {{ __("Ordered by country_id, then organization name") }}
        </p>
        <hr class="mb-4 mt-4" />
        <x-header-link-app 
            txt="Back to dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-header-link-app 
            txt="Add a new Organization" 
            url="{{ route('user.organization.add') }}" />
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

                @if ($allOrganizationSet->isEmpty())
                <!-- empty set -->
                    <h3 class="fyk text-2xl font-medium text-gray-900">
                        {{ __("There are no Organizations in platform, at now. Add one?") }}
                    </h3>
                @else
                <!-- not empty / use dl dt dd instead of table tr td -->
                <dl class="space-y-6">
                    @foreach($allOrganizationSet as $organization)
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-500 hover:border-indigo-300 transition-colors relative">
                            <dt class="fyk text-2xl font-bold text-indigo-700">
                                {{ $organization->country?->flag_code }} {{ $organization->country?->country }} 
                                <br />
                                {{ $organization->name }}
                            </dt>

                            <dd class="mt-2">
                                {{ __('Contact') }}: <br/>
                                {{ ($organization->contact) ? $organization->contact : 'N\A'}}
                            </dd>

                            <dd class="mt-2 text-gray-600 flex items-center">
                                {{ __('email') }}: {{ $organization->email }}
                            </dd>

                            <dd class="mt-2 text-sm text-gray-500 italic flex items-center">
                                {{ __('website') }}: 
                                <a href="{{ $organization->website }}" target="_blank" >
                                    {{ $organization->website }}
                                </a>
                            </dd>
                            <dd class="mt-2 text-sm text-gray-500 italic flex items-center">
                                <x-inline-link-app
                                    txt="Update"
                                    url="{{ route('user.organization.add') }}" />
                                <x-inline-link-app
                                    txt="Remove"
                                    url="{{ route('user.organization.add') }}" />
                            </dd>

                        </div>
                    @endforeach
                </dl>
                @endif
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
