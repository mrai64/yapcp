<?php

/**
 * Organization List
 * 
 * all user can add a new (own) organization
 * 
 * only organization members can modify (own) organization records
 * user in admin group can modify all organization records 
 * 
 */

?>

<div>
    <header>
       <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('New Organization') }}
        </h2>
        <p class=""><small>
            {{__('The Organization is a photographic club, or group of people, or even an individual')}}
            {{__('who organize, then manage photographic competitions,')}}
            {{__('optionally under the Patronage of one or more Federations.')}}
        </small></p>
        <p class="fyk text-xl font-medium mb-4">
            <a  href="{{ route('organization.add') }}"
                rel="noopener noreferrer">
            [ {{ __('Add a new, your, Organization') }} ]
            </a>
            <a  href="{{ route('user.dashboard') }}"
                rel="noopener noreferrer">
            [ {{ __('Back to your dashboard') }} ]
            </a>
        </p>
     </header>
    <!-- organization list -->

    <hr class="my-4" />

    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div> 
    @endif

    @if(isset($organization_list) && 
       count($organization_list) > 0)
    <ul class="">   
       @foreach($organization_list as $org)
        <li class="block p-4 mb-4 border rounded-md">
        <strong class="fyk text-xl"> {{$org->country->flag_code}} {{$org->country_id}} / {{$org->name}}<br /></strong> 
        <em>{{__('email')}}:</em> {{$org->email}}<br />
        <em>{{__('website')}}:</em> {{$org->website}}<br />
        <em>{{__('Contact info')}}:</em> {{$org->contact}}<br />
        @if ($isAdmin)
        <!-- organization -->
        <a href="{{route('organization.modify', ['organization' => $org->id ])}}" 
            class="fyk text-xl font-medium rounded-md px-4 py-4">
            [ {{__('Modify')}} ]
        </a>
        <a href="{{route('organization.delete', ['organization' => $org->id ])}}" 
            class="fyk text-xl font-medium rounded-md px-4 py-4">
            [ {{__('Remove')}} ]
        </a>
        @endif
        </li>
       @endforeach
    </ul>
    @else
    <div class="border text-xl rounded-md px-4 py-2">
        {{ __('Empty organization list, insert first') }}
    </div>
    @endif

</div>