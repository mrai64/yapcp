<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('user-contact-modify') }}">
                    {{ __("Update your personal Contact info") }}
                    </a>
                </div>
            </div>
        </div>
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('photo-box-list') }}">
                    {{ __("Your Uffizi' Gallery") }}
                    </a>
                </div>
            </div>
        </div>
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('organization-list') }}">
                    {{ __("Organization List") }}
                    </a>
                </div>
            </div>
        </div>
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('federation-list') }}">
                    {{ __("Federation List") }}
                    </a>
                </div>
            </div>
        </div>
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('federation-list') }}">
                    {{ __("Contest List to participate") }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <!-- for {{ Auth::id() }} -->
            <livewire:user.role.listed />
        </div>
    </div>

</x-app-layout>
