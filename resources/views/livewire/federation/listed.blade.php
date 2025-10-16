<?php
/**
 * 2025-10-16 changed table
 * 
 */

?>

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Federation List') }}
        </h2>
        <p class="small mb-4">
            {{ __("If the organizations manage the competitions, ") }}
            {{ __("the federations are the ones who set the rules and sponsor ") }}
            {{ __("national and international competitions. ") }}
            <br />
            {{ __("It's their job to define how to ensure successful preparation, ") }}
            {{ __("successful management, and a successful conclusion to each competition.") }}
            <br />
            {{ __("But as contest organizators they must be also 'in' Organization list.") }}
        </p>
    </header>
    <a href="{{ route('add-federation')}}" 
        class="float-end font-medium rounded-md py-2"
        >[ {{__('Add a new Federation')}} ]</a>
    <hr />
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div> 
    @endif

    @if(isset($federation_list) && count($federation_list) > 0 )
    <ul>
        @foreach($federation_list as $federation)
        <li class="my-2 p-4 font-medium">
            <strong class="fyk text-xl">{{$federation->name_en}}</strong><br />
            {{$federation->code}} | Country: {{$federation->country_id}} | web: {{$federation->website}}
            <a  href="{{ route('modify-federation', ['fid' => $federation->id]) }}"
                class="font-medium rounded-md px-4 py-2"
                >[ {{ __('Modify') }} ]</a>
            <a  href="{{ route('delete-federation', ['fid' => $federation->id]) }}"
                class="font-medium rounded-md px-4 py-2"
                >[ {{ __('Remove') }} ]</a>
        </li>
        @endforeach        
    </ul>
    @else
    <div class="border text-xl rounded-md px-4 py-2">
        {{ __('Empty federation list') }}
    </div>
    @endif
</div>