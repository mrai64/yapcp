<?php 
/**
 * user contact model - show individual values
 *
 * @see /app/livewire/user/contact/show.blade.php
 *
 */

?> 

<div>
    <header>
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
        <p class="fyk text-xl font-medium mb-4">
            <a  href="{{ route('user-contact.modify1', ['uid' => $userContact->id] ) }}"
                rel="noopener noreferrer">
            [ {{ __('Modify your personal infos') }} ]
            </a>
        </p>
    </header>
    <!-- simulate DD DT with table structure -->
    <table class="data-table-container w-full">
        <thead>
            <tr>
                <th scope="col" colspan="2" class="data-table-field">{{__("Field")}}</td>
                <th scope="col" class="data-table-value">{{__("value")}}</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3"><strong class="fyk text-xl mp-4">{{ __("You are...")}}</strong></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("First Name") }}</td>
                <td>{{ $userContact->first_name }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Last Name") }}</td>
                <td>{{ $userContact->last_name }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("From") }}</td>
                <td>{{ $userContact->country->flag_code ?? 'N\A'}} {{ $userContact->country->country }}</td>
            </tr>
            <tr>
                <td colspan="3">International Postal Address</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("address line 1") }}</td>
                <td>{{ $userContact->address ?? 'N\A'}}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("address line 2") }}</td>
                <td>{{ $userContact->address_line2 ?? 'N\A'}}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("address City") }}</td>
                <td>{{ $userContact->city ?? 'N\A'}}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Region code") }}</td>
                <td>{{ $userContact->region ?? 'N\A'}}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("ZIP") }}</td>
                <td>{{ $userContact->address_line2 ?? 'N\A'}}</td>
            </tr>
            <tr>
                <td colspan="3">SHOULD be contacted...</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Your preferred lang code than 'en'") }}</td>
                <td>{{ $userContact['lang_local'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Timezone") }}</td>
                <td>{{ $userContact['timezone'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Whatsapp sms") }}</td>
                <td>{{ $userContact['whatsapp'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("International sms cellular") }}</td>
                <td>{{ $userContact['cellular'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Email Address") }}</td>
                <td>{{ $userContact['email'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Personal website") }}</td>
                <td>{{ $userContact['website'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td colspan="3">Your self presentation...</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Social fb page") }}</td>
                <td>{{ $userContact['facebook'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Social eX twitter ") }}</td>
                <td>{{ $userContact['x_twitter'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Social insta ") }}</td>
                <td>{{ $userContact['instagram'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td colspan="3">{{ __("Specific Federation required infos") }}</td>
            </tr>
        </tbody>
    </table>
</div>
