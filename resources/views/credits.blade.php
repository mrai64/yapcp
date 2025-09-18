<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CREDITS</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=yanone-kaffeesatz:400" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-start fyk text-xl ">yaPCP CREDITS</div>
                        <div class="flex lg:justify-center lg:col-start-2">
                            <!-- yaPCP logo -->
                            <x-application-logo class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]" width="60px" height="60px" />
                            <!--/yaPCP logo -->
                        </div>
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </header>

                    <main class="mt-6 max-w-xl mx-auto">
                        <p class="mb-4">The project was build from scratch by Massimo Rainato, 
                            using php and based on Laravel 12.<br />
                            MIT License consent use of sw to build a proprietary sw,
                            i hope that platform became profitable with a lot of contest with a very
                            low-fee based on participants (yes, it's a BIG dream, i know).<br />
                            My work is my work and i put under copyright also when source-published in github platform.
                        </p>
                        <p class="mb-4">Credits are in progress, as Glocal app any language translation
                            to facilitate participation from over all the photographic world are welcomed.<br/>
                            Next i plan to open a github repository for translation, you should
                            fork, made your file and create a pull request.<br />
                        </p>
                        <div class="fyk text-2xl ">Languages translators</div>
                        <ul>
                            <li>Italian < Massimo Rainato - mrai64 massimo.rainato@gmail.com </li>
                        </ul>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        v{{ App\Models\User::version }}
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
