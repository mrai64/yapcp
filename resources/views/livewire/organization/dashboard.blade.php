<?php
/**
 * Organization Dashboard
 * 
 */

use App\Models\UserContact;

?>

<div>
    <div name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Organization Dashboard for/') }}
            {{ $organization['name'] }}
        </h2>
    </div>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h3 class="mb-4 w-full sm:px-6 lg:px-8"">
            {{"Back to "}}
            <a href="{{ route('organization-list') }}">
            [ {{ __('Organization list') }} ]
            </a>
            . .
            {{"Back to "}}
            <a href="{{ route('dashboard') }}">
            [ {{ __('Personal Dashboard') }} ]
            </a>
        </h3>

        <!-- contest list -->
        <section name="contest_list" class="mb-4 w-full sm:px-6 lg:px-8">
            <p class="fyk font-semibold text-2xl text-gray-800 leading-tight">
                {{ __("Contest list") }}
            </p>
            @if (count($contest_list) > 0)
            <ul>
                @foreach($contest_list as $contest)
                <li class="mb-2 p-4 border rounded-md">
                    <strong class="fyk text-2xl">{{$contest->name_en}}</strong><br />
                    <a href="{{ route('modify-contest', ['cid' => $contest->id ]) }}">
                        [ {{ __("Contest Definition Dashboard") }} ]
                    </a>
                    <a href="{{ route('contest-live-dashboard', ['cid' => $contest->id ]) }}">
                        [ {{ __("Contest Live Dashboard") }} ]
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
            <hr />
            <a href="{{ route('contest-add', ['oid' => $organization->id] )}}" 
                class="float-end font-medium rounded-md py-2"
                >[ {{ __('Add a new Contest')}} ]</a>
            <hr />
        </section>

        <!-- member list -->
        <section name="member_list" class="mt-6 w-full sm:px-6 lg:px-8">
            <p class="fyk font-semibold text-2xl text-gray-800 leading-tight">
                {{ __("Members list") }}
            </p>
            <ul>
                @foreach($user_role_list as $user_role)
                <li class="fyk mb-4 p-4 border rounded-md">
                    <strong class="fyk text-xl">{{ UserContact::get_first_last_name( $user_role->user_id ) }}, {{$user_role->role}}</strong>
                </li>
                @endforeach
            </ul>
            <hr />
            <small>{{__("Every Organization Member, to be in the list, must have to register in platform as individual, then set her/him membership to Organization")}}</small>
        </section>
    </div>
</div>
