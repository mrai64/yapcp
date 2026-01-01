<div>
    <h2 class="fyk text-3xl mb-4">{{ __("👤 Your Information")}}</h2>
    <p class="small">{{ __("Info required to apply for contest")}}</p>

    <!- simulate DD DT with table structure -->
    <table class="data-table-container w-full">
        <thead>
            <tr>
                <th scope="col" colspan="2" class="data-table-field">Field</td>
                <th scope="col" class="data-table-value">value</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3"><strong class="fyk text-xl mp-4">{{ __("You are...")}}</strong></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("First Name") }}</td>
                <td>{{ $user_contact->first_name }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Last Name") }}</td>
                <td>{{ $user_contact->last_name }}</td>
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
                <td>{{ $user_contact->address ?? 'N\A'}}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("address line 2") }}</td>
                <td>{{ $user_contact->address_line2 ?? 'N\A'}}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("address City") }}</td>
                <td>{{ $user_contact->city ?? 'N\A'}}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Region code") }}</td>
                <td>{{ $user_contact->region ?? 'N\A'}}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("ZIP") }}</td>
                <td>{{ $user_contact->address_line2 ?? 'N\A'}}</td>
            </tr>
            <tr>
                <td colspan="3">SHOULD be contacted...</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Your preferred lang code than 'en'") }}</td>
                <td>{{ $user_contact['lang_local'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Timezone") }}</td>
                <td>{{ $user_contact['timezone'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Whatsapp sms") }}</td>
                <td>{{ $user_contact['whatsapp'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("International sms cellular") }}</td>
                <td>{{ $user_contact['cellular'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Email Address") }}</td>
                <td>{{ $user_contact['email'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Personal website") }}</td>
                <td>{{ $user_contact['website'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td colspan="3">Your self presentation...</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Social fb page") }}</td>
                <td>{{ $user_contact['facebook'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Social eX twitter ") }}</td>
                <td>{{ $user_contact['x_twitter'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>{{ __("Social insta ") }}</td>
                <td>{{ $user_contact['instagram'] ?? 'N\A' }}</td>
            </tr>
            <tr>
                <td colspan="3">{{ __("Specific Federation required infos") }}</td>
            </tr>
        </tbody>
    </table>
</div>
