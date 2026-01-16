<?php
/**
 * User Roles 
 * in User dashboard
 */

?>

<div>
    @if (isset($userRoleList) && (count($userRoleList) > 0))
    <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight">
        {{ __("Your roles in") }}
    </h2>
    <hr />
    <ul>
        @foreach($userRoleList as $role)
        <li class="my-2 p-4 font-medium">
            <strong class="fyk text-xl">{{$role['role']}} /<br /></strong>

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
    <div class="border rounded-md px-4 py-2">
        {{ __('No role found 4 you in any organization, federation, contest, but you can add one, in case.') }}
        <br />
        <strong>
            {{ __("First, Update your contact info.") }}
        </strong>
        {{ __("Then update your role in organization, or insert organization or add works in your depot") }}
    </div>
    @endif
</div>