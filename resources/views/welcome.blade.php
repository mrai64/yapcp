<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>yaPCP</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=yanone-kaffeesatz:400" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
.fyk {font-family: 'Yanone Kaffeesatz', sans-serif;}
.bg-blue {
  --tw-bg-opacity: 1;
  background-color:rgb(0 0 245 / var(--tw-bg-opacity, 1))
}
        </style>
    </head>
    <body class="antialiased font-sans">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-start fyk text-xl ">yaPCP</div>
                        <div class="flex lg:justify-center lg:col-start-2">
                            <!-- yaPCP logo -->
                            <x-application-logo class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]" width="60px" height="60px" />
                            <!--/yaPCP logo -->
                        </div>
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </header>

                    <main class="mt-6">
                        <p class="mb-4">Welcome to Photo Contest Platform, our mission is help you to have 
                            a comfortable way to participate or organize Photo Contest everywhere you are.<br>
                            As participants we offer you a work depot and the feature to subscribe some
                            contest with few click possible: 1ts contest choice, 2nd works choice, 
                            and there is no third to do.<br>
                            As photo contest organizer we will offer you a comfortable platform from the beginning,
                            helping you to build a rule contest following national and international 
                            photo organization (i.e. FIAP) contest rules.
                        </p>
                        <h2 class="fyk text-2xl text-center my-6">
                            <a href="{{ route('contest-list') }}">
                                {{ __('Open Contest List') }}
                            </a>
                        </h2>
                        <br />
                        <br />
                        <h2 class="fyk text-2xl text-center my-6">
                            <a href="{{ route('organization-list') }}">
                                {{ __('Organization List') }}
                            </a>
                        </h2>
                        <br />
                        <br />
                        <h2 class="fyk text-2xl text-center my-6">
                            <a href="{{ route('federation-list') }}">
                                {{ __('Federation List') }}
                            </a>
                        </h2>

                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        yaPCP v{{ App\Models\User::version }}
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
