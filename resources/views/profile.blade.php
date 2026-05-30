<x-app-layout>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Update user n password') }}
        </h2>
        <hr />
        <p class="fyk text-xl font-medium mb-4">
            {{ __("In that place you can update only platform access infos.") }}
            {{ __("Instead, if you need to change your contact infos, use that link:") }}
            <br />
            <a  href="{{ route('user-contact.modify1') }}"
                rel="noopener noreferrer">
            [ {{ __('Your contact infos') }} ]
            </a>
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
