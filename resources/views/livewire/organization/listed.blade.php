<div>
    [ {{ __('Add a new Organization') }} ]
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
       <strong class="fyk text-xl">{{$org->name}} / {{$org->country_code}}<br /></strong> 
       {{__('email')}}   :{{$org->email}}<br />
       {{__('website')}} :{{$org->website}}<br />
       <small>{{__('uuid')}}    :{{$org->id}}</small>
       <a href="/organization/modify/{{$org->id}}" 
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