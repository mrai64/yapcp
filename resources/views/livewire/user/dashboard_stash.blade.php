                <br />
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('user_role.add.federation') }}">
                        [ {{ __("Add you in a Fed") }} ]
                    </a>
                </div>
                . .
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("Role(s) assigned to you") }}</h3>
                <livewire:user.role.listed />
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("As Contest(s) participant") }}</h3>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('contest.list') }}">
                        [ {{ __("Open Contest List") }} ]
                    </a>
                </div>
            </div>

            @can('access-juror')
            <div class="bg-indigo-50 border-l-4 border-indigo-500 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("As Jury member") }}</h3>
                <livewire:contest.jury.listed />
            </div>
            @endcan

            @can('access-organization')
            <div class="bg-green-50 border-l-4 border-green-500 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("As Organization member") }}</h3>
                <livewire:organization.dashboard />
            </div>
            @endcan

            @can('access-admin')
            <div class="bg-green-50 border-l-4 border-green-500 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("As Admins member") }}</h3>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('admin.dashboard') }}" 
                        class="mt-2 inline-block bg-red-600 text-white px-4 py-2 rounded">
                        [ {{ __("Admin Dashboard") }} ]
                    </a>
                </div>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('federation.add') }}">
                        [ {{ __("Add a new Fed") }} ]
                    </a>
                </div>
                . .
            </div>
            @endcan
