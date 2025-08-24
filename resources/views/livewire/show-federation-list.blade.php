<div>
    <a href="{{ route('add-federation')}}" 
        class="float-end font-medium rounded-md px-4 py-2"
        >Add a new Federation</a>
    <hr />
    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div> 
    @endif
    
    @if( $federation_list )
    <ul>
        @foreach($federation_list as $federation)
        <li class="my-2 p-4 font-medium">
            <strong class="fyk text-xl">{{$federation->name}}</strong><br />
            {{$federation->code}} | web: {{$federation->website}}
            <a  href="/federation/modify/{{$federation->id}}"
                class="font-medium rounded-md px-4 py-2"
                >[ {{ __('Modify') }} ]</a>
        </li>
        @endforeach        
    </ul>
    @else
    <hr />
    <p>{{ __('Empty federation list') }}</p>
    @endif
</div>
