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
        <style>.fyk {font-family: 'Yanone Kaffeesatz', sans-serif;}</style>
    </head>
    <body class="antialiased font-sans">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <img id="background" class="absolute -left-20 top-0 max-w-[877px]" src="https://laravel.com/assets/img/welcome/background.svg" />
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <!-- yaPCP logo -->
<svg  class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]"
width="60px" height="60px" viewBox="0 0 500 500" version="1.1" 
xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;">
    <g transform="matrix(1,0,0,1,-2.45002,9.47227)">
        <rect x="110.286" y="211.484" width="93.431" height="117.679" style="fill:none;stroke:#FF2D20;stroke-width:12px;"/>
        <g transform="matrix(1,0,0,1.51828,94,-170.599)">
            <rect x="110.286" y="211.484" width="93.431" height="117.679" style="fill:none;stroke:#FF2D20;stroke-width:12px;"/>
        </g>
        <g transform="matrix(1,0,0,1,148.478,-17.2075)">
            <g transform="matrix(128,0,0,128,64.6412,147.76)">
                <path d="M0.487,-0L0.086,-0L0.086,-0.079L0.25,-0.079L0.25,-0.545L0.097,-0.462L0.066,-0.534L0.269,-0.641L0.344,-0.641L0.344,-0.079L0.487,-0.079L0.487,-0Z" fill="currentColor" style="fill-rule:nonzero;"/>
            </g>
        </g>
        <g transform="matrix(1,0,0,1,58.4779,44.7925)">
            <g transform="matrix(128,0,0,128,64.6412,147.76)">
                <path d="M0.492,-0L0.072,-0L0.072,-0.076L0.237,-0.24C0.264,-0.267 0.286,-0.29 0.303,-0.31C0.32,-0.329 0.333,-0.347 0.342,-0.363C0.352,-0.379 0.358,-0.394 0.361,-0.409C0.365,-0.423 0.366,-0.438 0.366,-0.455C0.366,-0.471 0.364,-0.486 0.36,-0.5C0.356,-0.514 0.349,-0.526 0.34,-0.537C0.332,-0.548 0.32,-0.556 0.306,-0.563C0.292,-0.569 0.275,-0.572 0.256,-0.572C0.229,-0.572 0.204,-0.566 0.182,-0.554C0.16,-0.542 0.14,-0.526 0.121,-0.507L0.074,-0.563C0.098,-0.588 0.126,-0.609 0.157,-0.624C0.189,-0.639 0.225,-0.647 0.267,-0.647C0.295,-0.647 0.321,-0.643 0.344,-0.634C0.368,-0.626 0.388,-0.614 0.405,-0.598C0.422,-0.582 0.435,-0.562 0.444,-0.539C0.453,-0.516 0.458,-0.49 0.458,-0.461C0.458,-0.437 0.455,-0.414 0.448,-0.393C0.442,-0.372 0.432,-0.351 0.419,-0.331C0.406,-0.31 0.389,-0.289 0.369,-0.267C0.349,-0.244 0.325,-0.22 0.298,-0.194L0.182,-0.081L0.492,-0.081L0.492,-0Z" fill="currentColor" style="fill-rule:nonzero;"/>
            </g>
        </g>
        <g transform="matrix(1,0,0,1,64.9801,302.668)">
            <g transform="matrix(96,0,0,96,64.6412,125.682)">
                <path d="M0.509,-0.435C0.509,-0.402 0.503,-0.371 0.492,-0.343C0.481,-0.315 0.465,-0.291 0.443,-0.27C0.421,-0.25 0.394,-0.234 0.361,-0.222C0.329,-0.211 0.291,-0.205 0.248,-0.205L0.187,-0.205L0.187,-0L0.066,-0L0.066,-0.638L0.253,-0.638C0.294,-0.638 0.331,-0.634 0.363,-0.625C0.394,-0.616 0.421,-0.603 0.443,-0.585C0.464,-0.568 0.481,-0.547 0.492,-0.522C0.503,-0.497 0.509,-0.468 0.509,-0.435ZM0.383,-0.427C0.383,-0.444 0.38,-0.459 0.375,-0.473C0.369,-0.487 0.361,-0.499 0.35,-0.508C0.339,-0.518 0.326,-0.526 0.309,-0.531C0.292,-0.536 0.273,-0.539 0.25,-0.539L0.187,-0.539L0.187,-0.305L0.254,-0.305C0.275,-0.305 0.293,-0.308 0.309,-0.313C0.325,-0.319 0.338,-0.327 0.349,-0.338C0.36,-0.349 0.369,-0.361 0.374,-0.376C0.38,-0.391 0.383,-0.408 0.383,-0.427Z" fill="currentColor" style="fill-rule:nonzero;"/>
            </g>
        </g>
        <g transform="matrix(1,0,0,1,155.98,302.668)">
            <g transform="matrix(96,0,0,96,64.6412,125.682)">
                <path d="M0.49,-0.025C0.462,-0.014 0.434,-0.005 0.408,0C0.381,0.006 0.354,0.009 0.325,0.009C0.279,0.009 0.239,0.002 0.203,-0.011C0.168,-0.025 0.138,-0.045 0.114,-0.072C0.09,-0.098 0.071,-0.132 0.059,-0.171C0.046,-0.211 0.04,-0.257 0.04,-0.309C0.04,-0.363 0.047,-0.411 0.061,-0.452C0.074,-0.494 0.094,-0.53 0.119,-0.558C0.145,-0.587 0.175,-0.609 0.212,-0.624C0.248,-0.639 0.289,-0.647 0.334,-0.647C0.349,-0.647 0.362,-0.647 0.375,-0.646C0.388,-0.645 0.401,-0.644 0.413,-0.642C0.425,-0.641 0.438,-0.638 0.451,-0.635C0.463,-0.632 0.477,-0.629 0.49,-0.624L0.49,-0.505C0.463,-0.518 0.436,-0.527 0.411,-0.533C0.386,-0.538 0.363,-0.541 0.343,-0.541C0.313,-0.541 0.287,-0.536 0.265,-0.525C0.244,-0.514 0.226,-0.498 0.212,-0.479C0.198,-0.459 0.188,-0.436 0.182,-0.408C0.175,-0.381 0.172,-0.351 0.172,-0.319C0.172,-0.284 0.175,-0.253 0.182,-0.226C0.189,-0.199 0.199,-0.176 0.213,-0.157C0.227,-0.138 0.245,-0.124 0.267,-0.114C0.288,-0.104 0.314,-0.099 0.344,-0.099C0.355,-0.099 0.367,-0.1 0.379,-0.102C0.392,-0.104 0.404,-0.107 0.417,-0.111C0.43,-0.114 0.443,-0.118 0.455,-0.123C0.468,-0.128 0.479,-0.132 0.49,-0.137L0.49,-0.025Z" fill="currentColor" style="fill-rule:nonzero;"/>
            </g>
        </g>
        <g transform="matrix(1,0,0,1,254.98,302.668)">
            <g transform="matrix(96,0,0,96,64.6412,125.682)">
                <path d="M0.509,-0.435C0.509,-0.402 0.503,-0.371 0.492,-0.343C0.481,-0.315 0.465,-0.291 0.443,-0.27C0.421,-0.25 0.394,-0.234 0.361,-0.222C0.329,-0.211 0.291,-0.205 0.248,-0.205L0.187,-0.205L0.187,-0L0.066,-0L0.066,-0.638L0.253,-0.638C0.294,-0.638 0.331,-0.634 0.363,-0.625C0.394,-0.616 0.421,-0.603 0.443,-0.585C0.464,-0.568 0.481,-0.547 0.492,-0.522C0.503,-0.497 0.509,-0.468 0.509,-0.435ZM0.383,-0.427C0.383,-0.444 0.38,-0.459 0.375,-0.473C0.369,-0.487 0.361,-0.499 0.35,-0.508C0.339,-0.518 0.326,-0.526 0.309,-0.531C0.292,-0.536 0.273,-0.539 0.25,-0.539L0.187,-0.539L0.187,-0.305L0.254,-0.305C0.275,-0.305 0.293,-0.308 0.309,-0.313C0.325,-0.319 0.338,-0.327 0.349,-0.338C0.36,-0.349 0.369,-0.361 0.374,-0.376C0.38,-0.391 0.383,-0.408 0.383,-0.427Z" fill="currentColor" style="fill-rule:nonzero;"/>
            </g>
        </g>
        <g transform="matrix(1,0,0,1,248.478,83.7925)">
            <g transform="matrix(128,0,0,128,64.6412,147.76)">
                <path d="M0.48,-0.194C0.48,-0.166 0.474,-0.14 0.463,-0.115C0.451,-0.09 0.434,-0.069 0.412,-0.051C0.389,-0.032 0.36,-0.018 0.326,-0.007C0.291,0.003 0.251,0.009 0.205,0.009C0.18,0.009 0.157,0.008 0.137,0.006C0.117,0.005 0.098,0.003 0.08,-0L0.08,-0.076C0.1,-0.073 0.122,-0.07 0.144,-0.068C0.167,-0.066 0.189,-0.065 0.213,-0.065C0.245,-0.065 0.272,-0.068 0.295,-0.073C0.317,-0.079 0.336,-0.087 0.35,-0.098C0.364,-0.109 0.375,-0.122 0.381,-0.137C0.388,-0.153 0.391,-0.17 0.391,-0.189C0.391,-0.207 0.387,-0.222 0.379,-0.235C0.372,-0.248 0.361,-0.259 0.346,-0.268C0.332,-0.276 0.315,-0.283 0.296,-0.287C0.276,-0.292 0.254,-0.294 0.231,-0.294L0.158,-0.294L0.158,-0.364L0.232,-0.364C0.251,-0.364 0.269,-0.366 0.284,-0.371C0.3,-0.376 0.314,-0.384 0.325,-0.393C0.336,-0.403 0.345,-0.414 0.351,-0.428C0.357,-0.442 0.36,-0.458 0.36,-0.475C0.36,-0.509 0.349,-0.534 0.329,-0.55C0.308,-0.565 0.277,-0.573 0.237,-0.573C0.215,-0.573 0.193,-0.571 0.17,-0.567C0.148,-0.563 0.123,-0.556 0.097,-0.548L0.097,-0.622C0.108,-0.626 0.12,-0.629 0.133,-0.633C0.145,-0.636 0.158,-0.638 0.17,-0.64C0.183,-0.642 0.195,-0.644 0.208,-0.645C0.22,-0.646 0.232,-0.647 0.243,-0.647C0.277,-0.647 0.307,-0.643 0.333,-0.636C0.358,-0.629 0.38,-0.618 0.397,-0.604C0.414,-0.591 0.427,-0.574 0.436,-0.555C0.445,-0.535 0.449,-0.513 0.449,-0.489C0.449,-0.452 0.44,-0.422 0.421,-0.397C0.402,-0.372 0.377,-0.353 0.344,-0.338C0.361,-0.335 0.377,-0.33 0.393,-0.322C0.409,-0.314 0.424,-0.304 0.437,-0.292C0.45,-0.28 0.46,-0.266 0.468,-0.249C0.476,-0.232 0.48,-0.214 0.48,-0.194Z" fill="currentColor" style="fill-rule:nonzero;"/>
            </g>
        </g>
        <g transform="matrix(1,0,0,0.6727,190,107.735)">
            <rect x="110.286" y="211.484" width="93.431" height="117.679" style="fill:none;stroke:#FF2D20;stroke-width:12px;"/>
        </g>
    </g>
</svg>
                            <!--/yaPCP logo -->
                        </div>
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </header>

                    <main class="mt-6">
                        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                            <a
                                href="https://laravel.com/docs"
                                id="docs-card"
                                class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >
                                <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch">
                                    <img
                                        src="https://laravel.com/assets/img/welcome/docs-light.svg"
                                        alt="Laravel documentation screenshot"
                                        class="aspect-video h-full w-full flex-1 rounded-[10px] object-top object-cover drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)] dark:hidden"
                                        onerror="
                                            document.getElementById('screenshot-container').classList.add('!hidden');
                                            document.getElementById('docs-card').classList.add('!row-span-1');
                                            document.getElementById('docs-card-content').classList.add('!flex-row');
                                            document.getElementById('background').classList.add('!hidden');
                                        "
                                    />
                                    <img
                                        src="https://laravel.com/assets/img/welcome/docs-dark.svg"
                                        alt="Laravel documentation screenshot"
                                        class="hidden aspect-video h-full w-full flex-1 rounded-[10px] object-top object-cover drop-shadow-[0px_4px_34px_rgba(0,0,0,0.25)] dark:block"
                                    />
                                    <div
                                        class="absolute -bottom-16 -left-16 h-40 w-[calc(100%+8rem)] bg-gradient-to-b from-transparent via-white to-white dark:via-zinc-900 dark:to-zinc-900"
                                    ></div>
                                </div>

                                <div class="relative flex items-center gap-6 lg:items-end">
                                    <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                                        <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
                                            <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path fill="#FF2D20" d="M23 4a1 1 0 0 0-1.447-.894L12.224 7.77a.5.5 0 0 1-.448 0L2.447 3.106A1 1 0 0 0 1 4v13.382a1.99 1.99 0 0 0 1.105 1.79l9.448 4.728c.14.065.293.1.447.1.154-.005.306-.04.447-.105l9.453-4.724a1.99 1.99 0 0 0 1.1-1.789V4ZM3 6.023a.25.25 0 0 1 .362-.223l7.5 3.75a.251.251 0 0 1 .138.223v11.2a.25.25 0 0 1-.362.224l-7.5-3.75a.25.25 0 0 1-.138-.22V6.023Zm18 11.2a.25.25 0 0 1-.138.224l-7.5 3.75a.249.249 0 0 1-.329-.099.249.249 0 0 1-.033-.12V9.772a.251.251 0 0 1 .138-.224l7.5-3.75a.25.25 0 0 1 .362.224v11.2Z"/><path fill="#FF2D20" d="m3.55 1.893 8 4.048a1.008 1.008 0 0 0 .9 0l8-4.048a1 1 0 0 0-.9-1.785l-7.322 3.706a.506.506 0 0 1-.452 0L4.454.108a1 1 0 0 0-.9 1.785H3.55Z"/></svg>
                                        </div>

                                        <div class="pt-3 sm:pt-5 lg:pt-0">
                                            <h2 class="text-xl font-semibold text-black dark:text-white fyk">Documentation</h2>

                                            <p class="mt-4 text-sm/relaxed">
                                                Laravel has wonderful documentation covering every aspect of the framework. Whether you are a newcomer or have prior experience with Laravel, we recommend reading our documentation from beginning to end.
                                            </p>
                                        </div>
                                    </div>

                                    <svg class="size-6 shrink-0 stroke-[#FF2D20]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
                                </div>
                            </a>

                            <a
                                href="https://laracasts.com"
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >
                                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
                                    <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><g fill="#FF2D20"><path d="M24 8.25a.5.5 0 0 0-.5-.5H.5a.5.5 0 0 0-.5.5v12a2.5 2.5 0 0 0 2.5 2.5h19a2.5 2.5 0 0 0 2.5-2.5v-12Zm-7.765 5.868a1.221 1.221 0 0 1 0 2.264l-6.626 2.776A1.153 1.153 0 0 1 8 18.123v-5.746a1.151 1.151 0 0 1 1.609-1.035l6.626 2.776ZM19.564 1.677a.25.25 0 0 0-.177-.427H15.6a.106.106 0 0 0-.072.03l-4.54 4.543a.25.25 0 0 0 .177.427h3.783c.027 0 .054-.01.073-.03l4.543-4.543ZM22.071 1.318a.047.047 0 0 0-.045.013l-4.492 4.492a.249.249 0 0 0 .038.385.25.25 0 0 0 .14.042h5.784a.5.5 0 0 0 .5-.5v-2a2.5 2.5 0 0 0-1.925-2.432ZM13.014 1.677a.25.25 0 0 0-.178-.427H9.101a.106.106 0 0 0-.073.03l-4.54 4.543a.25.25 0 0 0 .177.427H8.4a.106.106 0 0 0 .073-.03l4.54-4.543ZM6.513 1.677a.25.25 0 0 0-.177-.427H2.5A2.5 2.5 0 0 0 0 3.75v2a.5.5 0 0 0 .5.5h1.4a.106.106 0 0 0 .073-.03l4.54-4.543Z"/></g></svg>
                                </div>

                                <div class="pt-3 sm:pt-5">
                                    <h2 class="text-xl font-semibold text-black dark:text-white">Laracasts</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
                                    </p>
                                </div>

                                <svg class="size-6 shrink-0 self-center stroke-[#FF2D20]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
                            </a>

                            <a
                                href="https://laravel-news.com"
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >
                                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
                                    <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><g fill="#FF2D20"><path d="M8.75 4.5H5.5c-.69 0-1.25.56-1.25 1.25v4.75c0 .69.56 1.25 1.25 1.25h3.25c.69 0 1.25-.56 1.25-1.25V5.75c0-.69-.56-1.25-1.25-1.25Z"/><path d="M24 10a3 3 0 0 0-3-3h-2V2.5a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2V20a3.5 3.5 0 0 0 3.5 3.5h17A3.5 3.5 0 0 0 24 20V10ZM3.5 21.5A1.5 1.5 0 0 1 2 20V3a.5.5 0 0 1 .5-.5h14a.5.5 0 0 1 .5.5v17c0 .295.037.588.11.874a.5.5 0 0 1-.484.625L3.5 21.5ZM22 20a1.5 1.5 0 1 1-3 0V9.5a.5.5 0 0 1 .5-.5H21a1 1 0 0 1 1 1v10Z"/><path d="M12.751 6.047h2a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-2A.75.75 0 0 1 12 7.3v-.5a.75.75 0 0 1 .751-.753ZM12.751 10.047h2a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-2A.75.75 0 0 1 12 11.3v-.5a.75.75 0 0 1 .751-.753ZM4.751 14.047h10a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-10A.75.75 0 0 1 4 15.3v-.5a.75.75 0 0 1 .751-.753ZM4.75 18.047h7.5a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-7.5A.75.75 0 0 1 4 19.3v-.5a.75.75 0 0 1 .75-.753Z"/></g></svg>
                                </div>

                                <div class="pt-3 sm:pt-5">
                                    <h2 class="text-xl font-semibold text-black dark:text-white">Laravel News</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Laravel News is a community driven portal and newsletter aggregating all of the latest and most important news in the Laravel ecosystem, including new package releases and tutorials.
                                    </p>
                                </div>

                                <svg class="size-6 shrink-0 self-center stroke-[#FF2D20]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
                            </a>

                            <div class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800">
                                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
                                    <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <g fill="#FF2D20">
                                            <path
                                                d="M16.597 12.635a.247.247 0 0 0-.08-.237 2.234 2.234 0 0 1-.769-1.68c.001-.195.03-.39.084-.578a.25.25 0 0 0-.09-.267 8.8 8.8 0 0 0-4.826-1.66.25.25 0 0 0-.268.181 2.5 2.5 0 0 1-2.4 1.824.045.045 0 0 0-.045.037 12.255 12.255 0 0 0-.093 3.86.251.251 0 0 0 .208.214c2.22.366 4.367 1.08 6.362 2.118a.252.252 0 0 0 .32-.079 10.09 10.09 0 0 0 1.597-3.733ZM13.616 17.968a.25.25 0 0 0-.063-.407A19.697 19.697 0 0 0 8.91 15.98a.25.25 0 0 0-.287.325c.151.455.334.898.548 1.328.437.827.981 1.594 1.619 2.28a.249.249 0 0 0 .32.044 29.13 29.13 0 0 0 2.506-1.99ZM6.303 14.105a.25.25 0 0 0 .265-.274 13.048 13.048 0 0 1 .205-4.045.062.062 0 0 0-.022-.07 2.5 2.5 0 0 1-.777-.982.25.25 0 0 0-.271-.149 11 11 0 0 0-5.6 2.815.255.255 0 0 0-.075.163c-.008.135-.02.27-.02.406.002.8.084 1.598.246 2.381a.25.25 0 0 0 .303.193 19.924 19.924 0 0 1 5.746-.438ZM9.228 20.914a.25.25 0 0 0 .1-.393 11.53 11.53 0 0 1-1.5-2.22 12.238 12.238 0 0 1-.91-2.465.248.248 0 0 0-.22-.187 18.876 18.876 0 0 0-5.69.33.249.249 0 0 0-.179.336c.838 2.142 2.272 4 4.132 5.353a.254.254 0 0 0 .15.048c1.41-.01 2.807-.282 4.117-.802ZM18.93 12.957l-.005-.008a.25.25 0 0 0-.268-.082 2.21 2.21 0 0 1-.41.081.25.25 0 0 0-.217.2c-.582 2.66-2.127 5.35-5.75 7.843a.248.248 0 0 0-.09.299.25.25 0 0 0 .065.091 28.703 28.703 0 0 0 2.662 2.12.246.246 0 0 0 .209.037c2.579-.701 4.85-2.242 6.456-4.378a.25.25 0 0 0 .048-.189 13.51 13.51 0 0 0-2.7-6.014ZM5.702 7.058a.254.254 0 0 0 .2-.165A2.488 2.488 0 0 1 7.98 5.245a.093.093 0 0 0 .078-.062 19.734 19.734 0 0 1 3.055-4.74.25.25 0 0 0-.21-.41 12.009 12.009 0 0 0-10.4 8.558.25.25 0 0 0 .373.281 12.912 12.912 0 0 1 4.826-1.814ZM10.773 22.052a.25.25 0 0 0-.28-.046c-.758.356-1.55.635-2.365.833a.25.25 0 0 0-.022.48c1.252.43 2.568.65 3.893.65.1 0 .2 0 .3-.008a.25.25 0 0 0 .147-.444c-.526-.424-1.1-.917-1.673-1.465ZM18.744 8.436a.249.249 0 0 0 .15.228 2.246 2.246 0 0 1 1.352 2.054c0 .337-.08.67-.23.972a.25.25 0 0 0 .042.28l.007.009a15.016 15.016 0 0 1 2.52 4.6.25.25 0 0 0 .37.132.25.25 0 0 0 .096-.114c.623-1.464.944-3.039.945-4.63a12.005 12.005 0 0 0-5.78-10.258.25.25 0 0 0-.373.274c.547 2.109.85 4.274.901 6.453ZM9.61 5.38a.25.25 0 0 0 .08.31c.34.24.616.561.8.935a.25.25 0 0 0 .3.127.631.631 0 0 1 .206-.034c2.054.078 4.036.772 5.69 1.991a.251.251 0 0 0 .267.024c.046-.024.093-.047.141-.067a.25.25 0 0 0 .151-.23A29.98 29.98 0 0 0 15.957.764a.25.25 0 0 0-.16-.164 11.924 11.924 0 0 0-2.21-.518.252.252 0 0 0-.215.076A22.456 22.456 0 0 0 9.61 5.38Z"
                                            />
                                        </g>
                                    </svg>
                                </div>

                                <div class="pt-3 sm:pt-5">
                                    <h2 class="text-xl font-semibold text-black dark:text-white">Vibrant Ecosystem</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Laravel's robust library of first-party tools and libraries, such as <a href="https://forge.laravel.com" class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white dark:focus-visible:ring-[#FF2D20]">Forge</a>, <a href="https://vapor.laravel.com" class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white">Vapor</a>, <a href="https://nova.laravel.com" class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white">Nova</a>, <a href="https://envoyer.io" class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white">Envoyer</a>, and <a href="https://herd.laravel.com" class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white">Herd</a> help you take your projects to the next level. Pair them with powerful open source libraries like <a href="https://laravel.com/docs/billing" class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white">Cashier</a>, <a href="https://laravel.com/docs/dusk" class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white">Dusk</a>, <a href="https://laravel.com/docs/broadcasting" class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white">Echo</a>, <a href="https://laravel.com/docs/horizon" class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white">Horizon</a>, <a href="https://laravel.com/docs/sanctum" class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white">Sanctum</a>, <a href="https://laravel.com/docs/telescope" class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white">Telescope</a>, and more.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
