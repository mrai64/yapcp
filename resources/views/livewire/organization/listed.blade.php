<?php

/**
 * organization  list - for all
 * 
 * Order by country and organization name
 * 
 */

use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component {
    use WithPagination;

    // mount() no
    // render() no
    // with() yes
    public function with(): array
    {
        return [
            'allOrganizationSet' => Organization::query()
                ->with(['country'])
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
                
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
