<!-- welcome component used in user dashboard -->
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
            <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                <div class="flex lg:justify-start fyk text-2xl ">&nbsp;</div>
                <div class="flex lg:justify-center lg:col-start-2">
                    <!-- yaPCP logo -->
                    <x-application-logo class="size-20 lg:size-24 text-white lg:text-[#FF2D20]" />
                    <!--/yaPCP logo -->
                </div>
            </header>

            <main class="mt-6 max-w-l mx-auto lg:mt-16 lg:max-w-4xl min-h-screen h-full">
                @can('access-admin')
                <p class="h-6">&nbsp;</p>
                <p class="fyk text-2xl text-center my-6">
                    <a href="{{ route('admin.dashboard') }}">
                        🧙‍♂️ {{ __("Admin Dashboard") }} 🧙‍♂️
                    </a>
                </p>
                @endcan

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

                <hr />

                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <x-yapcp.inline-link 
                        txt="Your Contact Info" 
                        url="{{ route('user-contact.modify1') }}" />
                    <x-yapcp.inline-link 
                        txt="Email, password" 
                        url="{{ route('user.profile') }}" />
                    <x-yapcp.inline-link 
                        txt="Your Uffizi Gallery" 
                        url="{{ route('user.gallery') }}" />
                    <x-yapcp.inline-link 
                        txt="Open Contest List" 
                        url="{{ route('contest.list') }}" />
                    <br />
                    <x-yapcp.inline-link 
                        txt="Organization List" 
                        url="{{ route('organization.list') }}" />
                    <x-yapcp.inline-link 
                        txt="Add a new Org" 
                        url="{{ route('organization.add') }}" />
                    <x-yapcp.inline-link 
                        txt="Add YOU in an Org" 
                        url="{{ route('user-role.add.organization') }}" />
                    <br />
                    <x-yapcp.inline-link 
                        txt="Federation List" 
                        url="{{ route('federation.list') }}" />
                    <x-yapcp.inline-link 
                        txt="Add a new Fed" 
                        url="{{ route('federation.add') }}" />
                    <x-yapcp.inline-link 
                        txt="Add YOU in a Fed" 
                        url="{{ route('user-role.add.federation') }}" />
                    <br style="clear:both;" />
                    <p class="small">
                        {{ __("Your personal data will be used when you want to register") }}
                        {{ __("for the next photo contest, or to contact you if you are") }}
                        {{ __("chosen as judges of a contest.") }}
                    </p>
                    <br />
                    <hr class="my-4" />

                    <!-- user roles in... -->
                    <section name="user_roles" >
                        <livewire:user.role.listed />
                    </section>

                    <!-- juror in contest... -->
                    <section name="user_roles" class="mb-4 sm:px-6 lg:px-8 py-12">
                        <livewire:contest.jury.listed />
                    </section>
                </div>
            </main>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>