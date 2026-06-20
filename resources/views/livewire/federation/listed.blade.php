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
            'allFederationsSet' => Federation::query()
                ->with(['country'])
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
        <x-header-link-app 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-header-link-app 
            txt="Add New Federation" 
            url="{{ route('federation.add') }}" />
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
                            <dt class="fyk text-2xl font-bold text-indigo-700">
                                {{ $federation->country?->flag_code }} {{ $federation->country?->country }} 
                                <br />
                                {{ $federation->name_en }}
                            </dt>

                            <dd class="mt-2">
                                {{ __('Official website') }}: <br/>
                                {{ ($federation->website) ? $federation->website : 'N\A'}}
                            </dd>

                            <dd class="mt-2">
                                {{ __('Contact Info') }}: <br/>
                                {{ $federation->contact_info ? $federation->contact_info : 'N\A' }}
                            </dd>

                            <dd class="mt-2">
                                {{ __('Language code') }}: <br/>
                                {{ ($federation->local_lang) ? $federation->local_lang : 'N\A'}}
                            </dd>

                            <dd class="mt-2">
                                {{ __('Local Name') }}: <br/>
                                <span lang="{{$federation->local_lang}}">
                                    {{ ($federation->name_local) ? $federation->name_local : 'N\A'}}
                                </span>
                            </dd>

                            <dd class="mt-2">
                                {{ __('Timezone') }}: <br/>
                                {{ ($federation->timezone_id) ? $federation->timezone_id : 'N\A'}}
                            </dd>

                            <dd class="mt-2">
                                <x-inline-link-app 
                                    txt="Update" 
                                    url="{{ route('federation.modify', ['federation' => $federation ]) }}" />
                                <x-inline-link-app 
                                    txt="‼️ Remove ‼️" 
                                    url="{{ route('federation.remove', ['federation' => $federation ]) }}" />
                                <x-inline-link-app 
                                    txt="Federation Sections" 
                                    url="{{ route('federation-section.listed', ['federation' => $federation ]) }}" />
                            </dd>

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
