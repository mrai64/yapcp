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
            'userContactMores' => Auth::user()->userContactMores()
                ->orderBy('federation_id')
                ->orderBy('field_name')
                ->get(),
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
            {{ __("Excluding password, here are listed all your personal information")}}
            {{ __("that should be used to fill your apply form to a contest,") }}
            {{ __("or fill a jury minute. You can change it anytime.") }}
            <br />
            {{ __("Some infos are an 'extra' asked from federations for sponsored contest, i.e. card id.")}}
        </p>
        <hr class="mt-4 mb-4" />
        <br />
        <x-yapcp.header-link 
            txt="Back to dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-yapcp.header-link
            txt="Update Contact infos"
            url="{{ route('user.contact.modify1', ['user_contact' => $userContact]) }}" />
        <x-yapcp.header-link
            txt="Update password, enable 2FA"
            url="{{ route('profile.show') }}" />

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
                        <dd class="mt-1 text-lg text-gray-900">{{ $userContact->lang_code ?: 'N\A' }}</dd>
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

                    @if($userContactMores->isNotEmpty())
                        <br class="clear:both;" />
                        <hr class="mt-4 mb-4" />
                        <br class="clear:both;" />
                        <div class="sm:col-span-2">
                            <dt class="fyk text-2xl font-medium text-gray-900">{{ __("'Federation more' fields") }}</dt>
                        </div>
                        <br class="clear:both;" />
                        @foreach ($userContactMores->groupBy('federation_id') as $fedId => $fields)
                            <div class="sm:col-span-2 mt-4">
                                <h3 class="fyk text-lg font-semibold text-gray-700 uppercase border-l-4 border-indigo-500 pl-3">{{ $fedId }}</h3>
                            </div>
                            @foreach ($fields as $field)
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ $field->field_name }}</dt>
                                    <dd class="mt-1 text-lg text-gray-900">{{ $field->field_value ?: 'N\A' }}</dd>
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </dl>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
