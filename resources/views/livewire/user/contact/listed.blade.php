<div>
    <h2 class="fyk text-3xl mb-4">{{ __("👤 Your Information")}}</h2>
    <p class="small">{{ __("Info required from contest")}}</p>

    <!- simulate DD DT with table structure -->
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
                <td>{{ $country->flag_code ?? 'N\A'}}</td>
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
