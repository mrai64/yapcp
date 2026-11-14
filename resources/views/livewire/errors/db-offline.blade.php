<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name') ?? 'Page Title' }}</title>
<!-- add -->
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=yanone-kaffeesatz:400" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
<!--/add -->
</head>
<!--/add -->
<body class="antialiased font-sans">
        <div class="bg-gray-50 text-black/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-start h-20 fyk text-2xl">{{ config('app.name') }}</div>
                        <div class="flex lg:justify-center lg:col-start-2">
                            <x-application-logo class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]" width="60px" height="60px" /> 
                        </div>
                    </header>

                    <main class="mt-6">
                        <div>
                            <div name="header">
                                <h2 class="fyk text-2xl font-medium text-red-600">
                                    {{ __('Errors n Warn') }}
                                </h2>
                                <hr class="mb-4" />
                                <x-yapcp.header-link 
                                    txt="Back to dashboard" 
                                    url="{{ route('user.dashboard') }}" />
                                |</div>
                            <div class="py-12">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                                        <h2 class="fyk text-2xl font-medium text-red-600 text-center w-full">
                                            {{ __('The archive / data base manager is down') }}
                                        </h2>
                                        <p class="fyk text-2xl text-blue-500 text-center w-full">
                                            {{ __("Start it, or solve the problem, then restart") }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- -->
                            <x-footer-app />
                        </div>
                    </main>
                    
                </div>
            </div>
        </div>
    </body>
</html>
