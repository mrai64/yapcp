<?php

/**
 * UserContact record show
 *
 */

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    // 
    public function with(): array
    {
        return [
            'userContact' => Auth::user()->contact,
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("👤 Your Information")}}
        </h2>
        <hr />
        <p class="small mb-4">
            {{ __("Excluding email and password, here are listed all your personal information")}}
            {{ __("that are used to fill your ev participation to contest,") }}
            {{ __("or fill jury minute, and you can change it anytime.") }}
            <br />
            {{ __("Some infos are required 'extra' from federations for sponsored contest,")}}
            {{ __("and are reported below.")}}
        </p>
        <hr class="mt-4 mb-4" />
        <br />
        <x-header-link-app 
            txt="Back to dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-header-link-app 
            txt="Update (1st of 5th)" 
            url="#" />

    </x-slot>
    <!-- -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
            <div class="float-end font-medium rounded-md px-4 py-2">
                {{ session('success') }}
            </div> 
            <hr />
            @endif

            <!-- -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('First Name') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900 font-semibold">{{ $userContact->first_name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Last Name') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900 font-semibold">{{ $userContact->last_name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Country') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">
                            {{ $userContact->country?->flag_code }} {{ $userContact->country?->name ?? $userContact->country_id }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Email') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->email ?: 'N\A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Cellular (with intl code)') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->cellular ?: 'N\A' }}</dd>
                    </div>
                    <br class="clear:both;" />
                    <hr class="mt-4 mb-4" />
                    <br class="clear:both;" />
                    <div class="sm:col-span-1">
                        <dt class="fyk text-2xl font-medium text-gray-900">{{ __('Language n timezone ') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">&nbsp;</dd>
                    </div>
                    <br class="clear:both;" />
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Lang code') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->lang_local ?: 'N\A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Timezone code') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->timezone_id ?: 'N\A' }}</dd>
                    </div>
                    <hr class="mt-4 mb-4" />
                    <br class="clear:both;" />
                    <div class="sm:col-span-1">
                        <dt class="fyk text-2xl font-medium text-gray-900">{{ __('International Postal address') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">&nbsp;</dd>
                    </div>
                    <br class="clear:both;" />
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Address line') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->address ?: 'N\A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Address line 2') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->address_line2 ?: 'N\A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('City') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->city ?: 'N\A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Region / State') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->region ?: 'N\A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('ZIP') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->postal_code ?: 'N\A' }}</dd>
                    </div>
                    <br class="clear:both;" />
                    <hr class="mt-4 mb-4" />
                    <br class="clear:both;" />
                    <div class="sm:col-span-1">
                        <dt class="fyk text-2xl font-medium text-gray-900">{{ __('On social n web') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">&nbsp;</dd>
                    </div>
                    <br class="clear:both;" />
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Personal website') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->website ?: 'N\A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Insta') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->instagram ?: 'N\A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('F') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->facebook ?: 'N\A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Whatsapp code') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->whatsapp ?: 'N\A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">{{ __('X') }}</dt>
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->x_twitter ?: 'N\A' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
