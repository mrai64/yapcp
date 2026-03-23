<x-app-layout>
    <x-slot name="header">
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
            {{ __("But when they made contest they must be also 'in' Organization list.") }}
            <br />
            {{ __("Note: Shortcode is key to find Federation.") }}
            {{ __("so if you must insert a shortcode already present add them a colon : and country_code to made it unique,") }}
            {{ __("i.e. Argentina and Andorra are both FAF, use FAF:AND and FAF:ARG.") }}
        </p>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if (session('success'))
        <hr />
        <div class="float-end font-medium rounded-md px-4 py-2">
            {{ session('success') }}
        </div> 
        @endif

        <p class="fyk text-xl font-medium mb-4">
            <a href="{{ route('federation.add')}}" 
                class="float-end font-medium rounded-md py-2"
                >[ {{__('Add a new Federation')}} ]</a>
        </p>

        @if(isset($federationSet) && count($federationSet) > 0 )
        <ul>
            @foreach($federationSet as $federation)
            <li class="my-2 p-4 font-medium">
                <strong class="fyk text-xl">{{$federation->name_en}}</strong><br />
                {{$federation->code}} | Country: {{$federation->country_id}} | web: {{$federation->website}}
                <a  href="{{ route('federation.modify', ['federation' => $federation]) }}"
                    class="font-medium rounded-md px-4 py-2"
                    >[ {{ __('Modify') }} ]</a>
                <a  href="{{ route('federation.delete', ['federation' => $federation]) }}"
                    class="font-medium rounded-md px-4 py-2"
                    >[ {{ __('Remove') }} ]</a>
            </li>
            @endforeach
        </ul>
        @else
        <div class="border text-xl rounded-md px-4 py-2">
            {{ __('Empty Federations list') }}
        </div>
        @endif
        </div>
    </div> 
</x-app-layout>