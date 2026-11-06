<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __("Participants Result Board")}} | {{ $contest->name_en }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonts -->
    <!-- Styles -->
    <link rel="preload" as="style" href="https://yapcp.test/build/assets/app-GW5FGW10.css"/>
    <link rel="modulepreload" as="script" href="https://yapcp.test/build/assets/app-CAiCLEjY.js"/>
    <link rel="stylesheet" href="https://yapcp.test/build/assets/app-GW5FGW10.css" data-navigate-track="reload"/>
    <script type="module" src="https://yapcp.test/build/assets/app-CAiCLEjY.js" data-navigate-track="reload"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans p-8">
    <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-lg p-6 space-y-6">
        
        <!-- Header identico alla vista originale -->
        <header class="border-b pb-4">
            <h2 class="fyk text-2xl font-medium text-gray-900">
                {{ __("Contest Participants Board")}} <br />
                {{ $contest->country?->flag_code }} {{ $contest->country_id }} | {{ $contest->name_en }}
            </h2>
            <h3 class="fyk text-xl text-gray-700 mt-1">
                {{__("by: ")}} {{ $organization->name }}
            </h3>
            <hr class="my-2" />
            <h3 class="text-sm text-gray-500">
                {{ __("Last Update:")}} {{ $generatedAt }} UTC
            </h3>
        </header>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="fyk text-xl border border-gray-300 p-2">{{("Author")}}</th>
@foreach ($contestSections as $section)
                        <th class="fyk text-xl border border-gray-300 p-2 text-center" colspan="2">
                            {{ __("Section - Theme")}} <br />
                            {{ $section->code }} - {{ $section->name_en }}
                        </th>
@endforeach
                    </tr>
                </thead>
                <tbody>
@forelse ($contestParticipants as $contestParticipant)
@php 
$contact = $contestParticipant->userContact; 
@endphp
                        <tr class="border-b hover:bg-gray-50">
                            <td class="border border-gray-300 p-2 align-top">
                                <div class="font-medium">{{ $contact?->last_name }}, {{ $contact?->first_name }}</div>
                                <div class="text-sm text-gray-600">
                                    {{ $contact?->country?->flag_code }}
                                    {{ $contact?->country_id }}
                                    {{ $contact?->city }}
                                    {{ $contact?->region }}
                                </div>
                            </td>
@foreach ($contestSections as $section)
@php
$worksKey = 'section_' . $section->code . '_works_count';
$admitKey = 'section_' . $section->code . '_admit_count';
@endphp
                                <td class="border border-gray-300 p-2 text-center align-top bg-blue-50/50">
                                    <span class="text-xs text-gray-500 block">{{__("Works")}}</span>
                                    <span class="font-semibold">{{ $contestParticipant->$worksKey ?? 0 }}</span>
                                </td>
                                <td class="border border-gray-300 p-2 text-center align-top bg-green-50/50">
                                    <span class="text-xs text-gray-500 block">{{__("Admitted")}}</span>
                                    <span class="font-semibold text-green-700">{{ $contestParticipant->$admitKey ?? 0 }}</span>
                                </td>
@endforeach
                        </tr>
@empty
                        <tr>
                            <td colspan="{{ (count($contestSections) * 2) + 1 }}" class="border border-gray-300 p-6 text-center text-gray-500 text-xl">
                                {{__("Sorry, no participant found.")}}
                            </td>
                        </tr>
@endforelse
                </tbody>
            </table>
        </div>

        <div class="text-sm text-gray-600">
            @if ($isAfterRevelations)
                {{__("Admit counters are updated to Jury choices.")}}
            @else
            <span class="text-red-600 font-semibold">
                {{__("Admit counters are forced to zero upto 'revelation day'.")}}
            </span>
            @endif
        </div>
    </div>
</body>
</html>