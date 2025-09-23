<div>
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div> 
    @endif

    <div class="py-6">
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('user-contact-modify') }}">
                    {{ __("Add a role in existing Organization") }}
                    </a>
                </div>
            </div>
        </div>
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('user-contact-modify') }}">
                    {{ __("Add a role in existing Federation") }}
                    </a>
                </div>
            </div>
        </div>
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('user-contact-modify') }}">
                    {{ __("Add a role in existing Contest") }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <hr />
    @if (isset($user_role_list) && (count($user_role_list) > 0))
    <ul>
        @foreach($user_role_list as $role)
        <li class="my-2 p-4 font-medium">
            <strong class="fyk text-xl">
                {{$role['role']}}
            </strong>
            <br />
            @if ($role['organization'])
            <strong class="fyk text-xl">
                Organization {{$role['organization']}}
            </strong>
            <span class="px-4">&nbsp;|</span>
            <a  href="/dashboard/role/organization/{{$role['organization_id']}}/modify"
                class="font-medium rounded-md px-4 py-2"
            >[ {{ __('Modify') }} ]</a>
            <a  href="/dashboard/role/organization/{{$role['organization_id']}}/closing"
                class="font-medium rounded-md px-4 py-2"
                >[ {{ __('Closing') }} ]</a>
            <a  href="{{ route('dashboard-organization', ['id' => $role['organization_id'] ]) }}"
                class="font-medium rounded-md px-4 py-2"
                >[ {{ __('Organization dashboard') }} ]</a>
            @endif
            @if ($role['federation'])
            <strong class="fyk text-xl">
                Federation {{$role['federation']}}
            </strong>
            <span class="px-4">&nbsp;|</span>
            <a  href="/dashboard/role/federation/{{$role['federation_id']}}/modify"
                class="font-medium rounded-md px-4 py-2"
            >[ {{ __('Modify') }} ]</a>
            <a  href="/dashboard/role/federation/{{$role['federation_id']}}/closing"
                class="font-medium rounded-md px-4 py-2"
                >[ {{ __('Closing') }} ]</a>
            @endif
            @if ($role['contest'])
            <strong class="fyk text-xl">
                Contest {{$role['contest']}}
            </strong>
            <span class="px-4">&nbsp;|</span>
            <a  href="/dashboard/role/contest/{{$role['contest_id']}}/modify"
                class="font-medium rounded-md px-4 py-2"
            >[ {{ __('Modify') }} ]</a>
            <a  href="/dashboard/role/contest/{{$role['contest_id']}}/closing"
                class="font-medium rounded-md px-4 py-2"
                >[ {{ __('Closing') }} ]</a>
            @endif
            <br />
            <span class="small">
                from: {{$role['start']}} upto: {{$role['end']}}
            </span>
        </li>
        @endforeach
    </ul>
    <div class="border text-sm rounded-md px-4 py-2">
        {{ __('Please: for any variation, maintain updated your Roles data.') }}
    </div>
    @else
    <div class="border text-xl rounded-md px-4 py-2">
        {{ __('No role found in any organization, federation, contest, but you can add one, in case.') }}
    </div>
    @endif
</div>