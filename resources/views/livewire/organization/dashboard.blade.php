<?php
/**
 * organization dashboard need some help
 * 
 */

use App\Models\UserContact;

?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Organization Dashboard for/') }}
            {{ $organization->name; }}
        </h2>
    </x-slot>

    <h3 class="mb-4 w-full sm:px-6 lg:px-8"">
        {{"Back to "}}
        <a href="{{ route('organization-list') }}">
        [ {{ __('Organization list') }} ]
        </a>
        . .
        {{"Back to "}}
        <a href="{{ route('organization-dashboard', ['id' => $id ]) }}">
        [ {{ __('Organization dashboard') }} ]
        </a>
    </h3>

    <!-- contest list -->
    <section name="contest_list" class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <p class="fyk text-xl">Contest list</p>
            @if (count($contest_list) > 0)
            <ul>
                @foreach($contest_list as $contest)
                <li class="my-2 p-4">
                    <strong class="fyk text-2xl">{{$contest->name_en}}</strong>
                    <a href="{{ route('modify-contest', ['cid' => $contest->id ]) }}">
                        [ {{ _("Contest Dashboard") }} ]
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
            <hr />
            <a href="{{ route('contest-add', ['oid' => $organization->id] )}}" 
                class="float-end font-medium rounded-md py-2"
                >[ {{__('Add a new Contest')}} ]</a>
            <hr />
        </div>
    </section>

    <!-- member list -->
    <section name="member_list" class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <p class="fyk text-xl">
            Member list
            </p>
            <ul>
                @foreach($user_role_list as $user_role)
                <li class="fyk my-2 p-4">
                    <strong class="fyk text-xl">{{ UserContact::get_first_last_name( $user_role->user_id ) }}, {{$user_role->role}}</strong>
                </li>
                @endforeach
            </ul>
            <hr />
            <small>{{__("Every Organization Member to be in the list must have to register in platform as individual, then set her/him membership to Organization")}}</small>
        </div>
    </section>

</x-app-layout>