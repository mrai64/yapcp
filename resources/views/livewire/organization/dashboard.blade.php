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
        <h3 class="mb-4 w-full sm:px-6 lg:px-8">
            <a href="{{ route('organization.list') }}">
                [ {{ __('Back to Organization list') }} ]
            </a> 
            . .
            <a href="{{ route('user.dashboard') }}">
                [ {{ __('Back to Personal Dashboard') }} ]
            </a>
        </h3>
    </div>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- contest list -->
        <section name="contestSet" class="mb-4 w-full sm:px-6 lg:px-8">
            <p class="fyk font-semibold text-2xl text-gray-800 leading-tight">
                {{ __("Contest list") }}
            </p>
            <a href="{{ route('organization.contest.add', ['organization' => $organization] )}}" 
                class="float-end font-medium rounded-md py-2"
                >
                [ {{ __('Add a new Contest')}} ]
            </a>
            <hr />
            @if (count($contestSet) > 0)
            <ul>
                @foreach($contestSet as $contest)
                <li class="mb-2 p-4 border rounded-md">
                    <strong class="fyk text-2xl">{{$contest->name_en}}</strong><br />
                    <a href="{{ route('organization.contest.modify', ['contest' => $contest ]) }}">
                        [ {{ __("Contest Definition Dashboard") }} ]
                    </a>
                    <a href="{{ route('contest.dashboard', ['contest' => $contest ]) }}">
                        [ {{ __("Contest Live Dashboard") }} ]
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
        </section>
        
        <!-- member list -->
        <section name="member_list" class="mt-6 w-full sm:px-6 lg:px-8">
            <p class="fyk font-semibold text-2xl text-gray-800 leading-tight">
                {{ __("Members list") }}
            </p>
            <ul>
                @foreach($organizationMembersRolesSet as $userRole)
                <li class="fyk mb-4 p-4 border rounded-md">
                    <strong class="fyk text-xl">
                        {{$userRole->userContact->country_id }}
                        {{$userRole->userContact->first_name}}{{$userRole->userContact->last_name }},
                        {{$userRole->role}}</strong>
                </li>
                @endforeach
            </ul>
            <hr />
            <small>{{__("Every Organization Member, to be in the list, must have to register in platform as individual, then set herself/himself membership to Organization.")}}</small>
        </section>
    </div>
</div>
