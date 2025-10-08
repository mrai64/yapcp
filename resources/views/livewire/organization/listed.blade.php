<div>
    <a  href="{{ route('add-organization') }}" 
        class="float-end font-medium rounded-md mb-4 py-2"
        >
        [ {{ __('Add a new Organization') }} ]
    </a>

    <hr class="my-4" />

    @if (session('success'))
    <div class="float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div> 
    @endif

    @if(isset($organization_list) && 
       count($organization_list) > 0)
    <ul class="">   
       <?php $first_bool = true; ?>
       @foreach($organization_list as $org)
        <li class="block p-4 mb-4 border rounded-md">
        <strong class="fyk text-xl">{{$org->name}} / {{$org->country_id}}<br /></strong> 
        <em>{{__('email')}}:</em> {{$org->email}}<br />
        <em>{{__('website')}}:</em> {{$org->website}}<br />
        <small><em>{{__('uuid')}}: {{$org->id}}</em></small>
        <a href="{{route('organization-dashboard', ['id' => $org->id ])}}" 
        class="font-medium rounded-md px-4 py-4">
            [ {{__('Dashboard')}} ]
        </a>
        <a href="{{route('modify-organization', ['id' => $org->id ])}}" 
            class="font-medium rounded-md px-4 py-4">
            [ {{__('Modify')}} ]
        </a>
        <a href="/organization/remove/{{$org->id}}" 
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