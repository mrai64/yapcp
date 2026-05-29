<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>yaPCP</title>

        <!-- Fonts -->
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-start fyk text-3xl ">yaPCP</div>
                        <div class="flex lg:justify-center lg:col-start-2">
                            <!-- yaPCP logo -->
                            <x-application-logo class="h-16 w-auto text-white lg:h-20 lg:text-[#FF2D20]" />
                            <!--/yaPCP logo -->
                        </div>
                    </header>

                    <main class="mt-6 max-w-l mx-auto lg:mt-16 lg:max-w-4xl min-h-screen h-full z-0">
                        @if(!session()->has('welcome_shown'))
                        <!-- one time message -->
                        <p class="mb-4">
                            {!! $terms !!}
                        </p>
                        @php session()->put('welcome_shown', true); @endphp
                        <!--/one time message -->
                        @else
                        <p class="mb-4 text-center text-xl text-muted dark:text-white/70">
                            {{ __('Welcome back to Photo Contest Platform') }}
                        </p>
                        @endif

                        @auth
                        <p class="fyk text-2xl text-center my-6">
                            <a href="{{ route('user.dashboard') }}">
                                {{ __('Your Dashboard') }}
                            </a>
                        </p>

                        @else
                        <p class="h-6">&nbsp;</p>
                        <p class="fyk text-2xl text-center my-6">
                            <a href="{{ route('login') }}">
                                {{ __('Log in') }}
                            </a>
                        </p>
                            @if (Route::has('register'))
                        <p class="h-6">&nbsp;</p>
                        <p class="fyk text-2xl text-center my-6">
                            <a href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        </p>
                            @endif
                        @endauth

                        <p class="h-6">&nbsp;</p>
                        <p class="fyk text-2xl text-center my-6">
                            <a href="{{ route('contest.list') }}">
                                {{ __('The Open Contest List') }}
                            </a>
                        </p>

                        <p class="h-6">&nbsp;</p>
                        <p class="fyk text-2xl text-center my-6">
                            <a href="{{ url('/docs') }}">
                                {{ __('The Manual') }}
                            </a>
                        </p>

                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70 text-muted z-40">
                        &copy; {{ date('Y')}} - {{ config('app.name') }} - version {{ $appVersion }} guest
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
