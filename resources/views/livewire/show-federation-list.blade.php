<div>
    @if( $federation_list )
    <ul>
        @foreach($federation_list as $federation)
        <li class="my-2 p-4 font-medium">
            [{{$federation->id}}] 
            {{$federation->code}}<br />
            <strong class="fyk text-xl">{{$federation->name}}</strong>
        </li>
        @endforeach        
    </ul>
    @endif
</div>
