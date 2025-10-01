<?php
/**
 * in User dashboard
 */

?>

<div >
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div>
    @endif

    <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
        <a href="{{ route('add-user-role-organization') }}">
        [ {{ __("Add a role in existing Organization") }} ]
        </a>
    </div>
    <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
        <a href="{{ route('add-organization') }}">
            [ {{ __("Add Your Organization") }} ]
        </a>
    </div>
    <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
        <a href="{{ route('add-user-role-federation') }}">
            [ {{ __("Add a role in existing Federation") }} ]
        </a>
    </div>
    <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
        <a href="{{ route('add-federation') }}">
            [ {{ __("Add Your Federation") }} ]
        </a>
    </div>

    <hr />
    @if (isset($user_role_list) && (count($user_role_list) > 0))
    <ul>
        @foreach($user_role_list as $role)
        <li class="my-2 p-4 font-medium">
            <strong class="fyk text-xl">{{$role['role']}} </strong>
            <br />

            @if ($role['organization'])
            <strong class="fyk text-xl">
                Organization: {{$role['organization']}}
            </strong>
            <br />
            <span class="small">
                {{$role['start']}} ------- {{$role['end']}}
            </span>
            <br />
            <div class="inline-flex h-16 w-auto sm:px-3 lg:px-4">
            <a  href="/dashboard/role/organization/{{$role['organization_id']}}/modify"
                class="font-medium rounded-md py-2"
            >[ {{ __('Modify Role') }} ]</a>
            </div>
            <div class="inline-flex h-16 w-auto sm:px-3 lg:px-4">
            <a  href="/dashboard/role/organization/{{$role['organization_id']}}/close"
                class="font-medium rounded-md py-2"
            >[ {{ __('Closing Role') }} ]</a>
            </div>
            <div class="inline-flex h-16 w-auto sm:px-3 lg:px-4">
            <a  href="{{ route('organization-dashboard', ['id' => $role['organization_id'] ]) }}"
                class="font-medium rounded-md py-2"
                >[ {{ __('Organization dashboard') }} ]</a>
            </div>
            @endif

            @if ($role['federation'])
            <strong class="fyk text-xl">
                Federation: {{$role['federation']}}
            </strong>
            <br />
            <span class="small">
                {{$role['start']}} ------- {{$role['end']}}
            </span>
            <br />
            <div class="inline-flex h-16 w-auto sm:px-3 lg:px-4">
            <a  href="/dashboard/role/federation/{{$role['federation_id']}}/modify"
                class="font-medium rounded-md py-2"
            >[ {{ __('Modify Role') }} ]</a>
            </div>
            <div class="inline-flex h-16 w-auto sm:px-3 lg:px-4">
            <a  href="/dashboard/role/federation/{{$role['federation_id']}}/closing"
                class="font-medium rounded-md py-2"
                >[ {{ __('Closing Role (today)') }} ]</a>
            </div>
            <div class="inline-flex h-16 w-auto sm:px-3 lg:px-4">
            <a  href="{{ route('modify-federation', ['fid' => $role['federation_id'] ]) }}"
                class="font-medium rounded-md py-2"
                >[ {{ __('Federation dashboard') }} ]</a>
            </div>
            @endif

            @if ($role['contest'])
            <strong class="fyk text-xl">
                Contest: {{$role['contest']}}
            </strong>
            <br />
            <span class="small">
                {{$role['start']}} ------- {{$role['end']}}
            </span>
            <br />
            <div class="inline-flex h-16 w-auto sm:px-3 lg:px-4">
                <a  href="/dashboard/role/contest/{{$role['contest_id']}}/modify"
                class="font-medium rounded-md py-2"
                >[ {{ __('Modify Role') }} ]</a>
            </div>
            <div class="inline-flex h-16 w-auto sm:px-3 lg:px-4">
                <a  href="/dashboard/role/contest/{{$role['contest_id']}}/closing"
                class="font-medium rounded-md py-2"
                >[ {{ __('Closing Role') }} ]</a>
            </div>
            <div class="inline-flex h-16 w-auto sm:px-3 lg:px-4">
                <a  href="{{ route('modify-contest', ['cid' => $role['contest_id'] ]) }}"
                class="font-medium rounded-md py-2"
                >[ {{ __('Contest dashboard') }} ]</a>
            </div>
            @endif

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