<?php

/**
 * Organization Contest Design / Contest general detail
 */

use App\Models\Contest;
use App\Models\Organization;
use Carbon\CarbonImmutable;
use Livewire\Volt\Component;

new class extends Component {
    public Contest         $contest;
    public Organization    $organization;
    public CarbonImmutable $today;

    public function mount(Contest $contest)
    {
        $this->contest =      $contest;
        $this->organization = $contest->organization;
        $this->today =        CarbonImmutable::now();
    }
}; ?>

<div>
    <h3 class="fyk text-2xl font-medium text-gray-900">
        {{ __('General info') }}
    </h3>
        <hr class="mb-4" />

    <p class="fyk text-xl">
        {{ __("We, :name, are announcing a photographic contest named", ['name' => $organization->name]) }}
    </p>
    <p class="fyk text-2xl font-medium text-gray-900">
        {{ $contest->name_en }}
    </p>
    <p>
        {{ __("open for all photographer, Amateur and Pro from :day_1 to :day_2. ", ['day_1' => $contest->day_1_opening, 'day_2' => $contest->day_2_closing ]) }}
        <br >
        <em class="prose small">
            {{ __("Note: Date n time 00:00 23:59 are based on our -Organization- timezone, which is: :timezone.", ['timezone' => $contest->timezone_id ]) }}
        </em>
    </p>
    <div class="text-2xl">&nbsp;</div>
    <h3 class="fyk text-2xl font-medium text-gray-900">
        {{ __("Calendar") }}
    </h3>
    <table class="data-table-container w-auto">
        <tbody>
            <tr class="border">
                <td class="fyk text-2xl font-medium text-gray-900 w-60" scope="row" valign="top">
                    {{ __("Participation Opening") }}
                </td>
                <td class="fyk text-2xl font-medium text-end text-gray-900 w-auto" scope="row" valign="top">
                    {{ $contest->day_1_opening->format('D j F Y') }}
                </td>
            </tr>
            <tr class="border">
                <td class="fyk text-2xl font-medium text-gray-900 w-60" scope="row" valign="top">
                    {{ __("Participation Deadline") }}
                </td>
                <td class="fyk text-2xl font-medium text-end text-gray-900 w-auto" scope="row" valign="top">
                    {{ $contest->day_2_closing->format('D j F Y') }}
                </td>
            </tr>
            <tr class="border">
                <td class="fyk text-2xl font-medium text-gray-900 w-60" scope="row" valign="top">
                    {{ __("Jury Ending date") }}
                </td>
                <td class="fyk text-2xl font-medium text-end text-gray-900 w-auto" scope="row" valign="top">
                    {{ $contest->day_4_jury_closing->format('D j F Y') }}
                </td>
            </tr>
            <tr class="border">
                <td class="fyk text-2xl font-medium text-gray-900 w-60" scope="row" valign="top">
                    {{ __("Participant Results") }}
                </td>
                <td class="fyk text-2xl font-medium text-end text-gray-900 w-auto" scope="row" valign="top">
                    {{ $contest->day_5_revelations->format('D j F Y') }}
                </td>
            </tr>
            <tr class="border">
            <td class="fyk text-2xl font-medium text-gray-900 w-60" scope="row" valign="top">
                    {{ __("Awards Ceremony") }}
                </td>
                <td class="fyk text-2xl font-medium text-end text-gray-900 w-auto" scope="row" valign="top">
                    {{ $contest->day_6_awards->format('D j F Y') }}
                </td>
            </tr>
            <tr class="border">
                <td class="fyk text-2xl font-medium text-gray-900 w-60" scope="row" valign="top">
                    {{ __("Catalogues online publication") }}
                </td>
                <td class="fyk text-2xl font-medium text-end text-gray-900 w-auto" scope="row" valign="top">
                    {{ $contest->day_7_catalogues->format('D j F Y') }}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="text-2xl">&nbsp;</div>
    <h3 class="fyk text-2xl font-medium text-gray-900">
        {{ __("Infos on Web") }}
    </h3>
    <p class="fyk text-xl mt-4">
        <ul>
            <li class="">
                <x-yapcp.inline-link 
                    txt="Contest Rules" 
                    url="{{ $contest->url_1_rule }}" /> ↗️
            </li>
            <li class="">
                <x-yapcp.inline-link 
                    txt="Participant Board" 
                    url="{{ ($contest->day_1_opening <= $today) ? $contest->url_2_concurrent_list : '#' }}" /> ↗️
            </li>
            <li class="">
                <x-yapcp.inline-link 
                    txt="Results Board" 
                    url="{{ ($contest->day_5_revelations <= $today) ? $contest->url_3_admit_n_award_list : '#' }}" /> ↗️
            </li>
            <li class="">
                <x-yapcp.inline-link 
                    txt="Online Catalogues" 
                    url="{{ ($contest->day_7_catalogues <= $today) ? $contest->url_4_catalogue : '#' }}" /> ↗️
            </li>
        </ul>
    </p>
    <div class="text-2xl">&nbsp;</div>
    <h3 class="fyk text-2xl font-medium text-gray-900">
        {{ __("Organization Contacts") }}
    </h3>
    <pre class="fyk text-xl">{{ $contest->contact_info }}</pre>
</div>
