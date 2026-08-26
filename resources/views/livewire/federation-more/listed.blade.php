<?php

/**
 * FederationMore - List of every Federation "more fields"
 *   required over user_contact_mores, user_work_mores, and
 *   other <table>_mores in future
 *
 */

use App\Models\Federation;
use App\Models\FederationMore;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    //
    public Federation $federation;
    public            $federationMoreSet;
    public bool       $isAdmin;
    //
    public function mount(Federation $federation)
    {
        $this->isAdmin = Auth::user()->isAdmin() ?? false;
        $this->federation = $federation;
        $this->federationMoreSet = FederationMore::where('federation_id', $this->federation->id)
            ->orderBy('referenced')
            ->orderBy('field_label')
            ->get();

    }
    // no rules()

}; ?>

<div>
	<x-slot name="header">
		<h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
			{{ $federation->name_en }}
			<br />
			{{ __('Federation More fields List' ) }}der
		</h2>
		<p class="small">
			{{ __("There is a set of data that is common to all competitions and all federations, and some additional data that each federation requests.")}}
			<br />
			{{ __("These are the fields listed here.")}}
			<br />
			{{ __("To compile these records a basic Laravel knowledge is mandatory.")}}
		</p>
		<hr class="mb-4 mt-4" />
		<x-yapcp.header-link 
			txt="Back to User dashboard" 
			url="{{ route('user.dashboard') }}" />
		<x-yapcp.header-link 
			txt="Federation list" 
			url="{{ route('federation.listed') }}" />
		@if ($isAdmin)
		<x-yapcp.header-link 
			txt="Add a More field" 
			url="{{ route('federation-more.add', ['federation' => $federation]) }}" />
		@endif
	</x-slot>
	
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

			<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
				<!-- success -->
				@if (session('success'))
				<div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
					{{ session('success') }}
				</div>
				@endif

				<!-- errors list -->
				@if ($errors->any())
				<div>
					<ul>
						@foreach ($errors->all() as $error)
						<li class="text-red-600">❌ {{ $error }} 👈</li>
						@endforeach
					</ul>
				</div>
				@endif

				@if ($federationMoreSet->isEmpty())
				<div class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
					{{ __('No "more field" registered for that federation. Add one?' ) }}
				</div>
				@else
				<dl>
					@foreach ($federationMoreSet as $federationMore)
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-500 hover:border-indigo-300 transition-colors relative">
                        <dt class="fyk text-2xl font-bold text-indigo-700">
                            {{ $federationMore->referenced }}
                            / Referenced table
                            <br />
                            {{ $federationMore->field_label }}
                            / Field label
                        </dt>

                        <dd class="mt-2">
                            {{ __('field id') }}: <br/>
                            <span class="font-mono">{{ $federationMore->field_name }}</span>
                            
                        </dd>

                        <dd class="mt-2">
                            {{ __('validation rules') }}: <br/>
                            <span class="font-mono">{{ $federationMore->field_validation_rules }}</span>
                        </dd>

                        <dd class="mt-2">
                            {{ __('default rules') }}: <br/>
                            <span class="font-mono">{{ ($federationMore->field_default_rules) ? ($federationMore->field_default_rules) : '" " (space)' }}</span>
                        </dd>

                        <dd class="mt-2">
                            {{ __('Suggestion phrase') }}: <br/>
                            {{ $federationMore->field_suggest }}
                        </dd>

                        @if ($isAdmin)
                        <x-yapcp.inline-link 
                            txt="Update" 
                            url="#" />
                        <x-yapcp.inline-link 
                            txt="‼️ Remove ‼️" 
                            url="#" />
                        @endif
                    </div>
					@endforeach
				</dl>
				@endif
			</div>
		</div>
	</div>
	<!-- -->
	<x-footer-app />
</div>
