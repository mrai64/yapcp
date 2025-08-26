<div>
    <a href="{{ route('add-federation')}}" 
        class="float-end font-medium rounded-md py-2"
        >[ {{__('Add a new Federation')}} ]</a>
    <hr />
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div> 
    @endif

    @if(isset($federation_list) && 
        count($federation_list) > 0 )
    <ul>
        @foreach($federation_list as $federation)
        <li class="my-2 p-4 font-medium">
            <strong class="fyk text-xl">{{$federation->name}}</strong><br />
            {{$federation->code}} | web: {{$federation->website}}
            <a  href="/federation/modify/{{$federation->id}}"
                class="font-medium rounded-md px-4 py-2"
                >[ {{ __('Modify') }} ]</a>
            <a  href="/federation/remove/{{$federation->id}}"
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
