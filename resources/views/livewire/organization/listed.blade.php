<?php

/**
 * Organization List
 * 
 * @see /app/Livewire/Organization/Listed.php
 * 
 */

?>

<div>
    <div class="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Organization List') }}
        </h2>
        <p class="small mb-4">
            {{ __("Ordered by country id, then organization name") }}.
        </p>
        <hr class="my-4" />
        <p class="fyk text-xl font-medium mb-4">
            <a href="{{ route('user.organization.add')}}" 
                class="float-end font-medium rounded-md py-2">
                [ {{__('Add a new Organization')}} ]
            </a>
        </p>
        @if (session('success'))
        <hr class="my-4" />
        <div class="float-end font-medium rounded-md px-4 py-2">
            {{ session('success') }}
        </div> 
        @endif
    </div>
    <!-- organization list -->
    @if(isset($organization_list) && count($organization_list) > 0)
    <ul class="">
       @foreach($organization_list as $org)
        <li class="block p-4 mb-4 border rounded-md">
        <strong class="fyk text-xl">{{$org->country_id}} / {{$org->name}}</strong> 
        <br />
        <em>{{__('email')}}:</em> {{$org->email}}<br />
        <em>{{__('website')}}:</em> {{$org->website}}<br />
        <em>{{__('Contact')}}:</em> {!! nl2br( e("\n" . $org->contact)) !!}<br />
        <a href="{{route('organization.dashboard', ['organization' => $org->id ])}}" 
            class="font-medium rounded-md px-4 py-4">
            [ {{__('dashboard')}} ]
        </a>
        <a href="{{route('user.organization.modify', ['organization' => $org->id ])}}" 
            class="font-medium rounded-md px-4 py-4">
            [ {{__('Modify')}} ]
        </a>
        <a href="{{ route('user.organization.delete', ['organization' => $org ]) }}"
            class="font-medium rounded-md px-4 py-4">
            [ {{__('Remove')}} ]
        </a>
       @endforeach
    </ul>
    @else
    <div class="border text-xl rounded-md px-4 py-2">
        {{ __('Empty organization list') }}
    </div>
    @endif

</div>