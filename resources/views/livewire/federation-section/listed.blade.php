<?php

/**
 * Federation Section Listed
 * 
 */

use App\Models\Federation;
use App\Models\FederationSection;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
	use WithPagination;

	public Federation $federation;

	public $sectionSet;

	// mount() yes
	// with()  yes
	public function mount(Federation $federation)
	{
		$this->federation = $federation;
		$this->sectionSet = FederationSection::query()
			->where('federation_id', $this->federation->id)
			->where('federation_id', $this->federation->id)
			->orderBy('code')
			->get();
		$this->isAdmin = Auth::user()->isAdmin();
	}

}; ?>

<div>
	<x-slot name="header">
		<h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
			{{ $federation->name_en }}
			<br />
			{{ __('Federation Sections List' ) }}der
		</h2>
		<p class="small">
			{{ __("When an Organization design it´s Contest should choiche")}}
			{{ __("to be sponsored by that federation, so these")}}
			{{ __("section n themes are based on official docs")}}
			{{ __("released an published by")}}
			<br>
			{{ $federation->name_en }}
		</p>
		<hr class="mb-4 mt-4" />
		<x-yapcp.header-link 
			txt="Back to User dashboard" 
			url="{{ route('user.dashboard') }}" />
		<x-yapcp.header-link 
			txt="Federation list" 
			url="{{ route('federation.listed') }}" />
		@if ($this->isAdmin)
		<x-yapcp.header-link 
			txt="Add a Federation Section" 
			url="{{ route('federation-section.add', ['federation' => $this->federation]) }}" />
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

				@if ($sectionSet->count())
				<dl class="space-y-6">
						@foreach ($sectionSet as $section)
						<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-500 hover:border-indigo-300 transition-colors relative">
								<dt class="fyk text-2xl font-bold text-indigo-700">
										{{ $section->code }}
										_
										{{ $section->name_en }}
								</dt>

								@if ($this->isAdmin)
								<dd class="px-5">
                  <x-yapcp.inline-link 
                      txt="Update" 
                      url="{{ route('federation-section.modify', ['federation_section' => $section]) }}" />
                  <x-yapcp.inline-link 
                      txt="‼️ Remove" 
                      url="{{ route('federation-section.delete', ['federation_section' => $section]) }}" />
								</dd>
								@endif

								<dd class="px-5 mt-2">
										{{ __('Synopsis') }}
										<br />
										{{ $section->synopsis ?? 'N\A' }}
										<br />
								</dd>
								<dd class="px-5 mt-2">
										{{ __('Synopsis') }}
										<br />
										{{ $section->synopsis ?? 'N\A' }}
										<br />
								</dd>

								<dd class="px-5">
										{{ __('List of file extension') }}:
										{{ $section->file_formats }}
								</dd>
								<dd class="px-5">
										{{ __('List of file extension') }}:
										{{ $section->file_formats }}
								</dd>

								<dd class="px-5">
										{{ __('Min / max # works') }}: 
										{{ __('min') }}: {{ $section->min_works }}
										{{ __('to')  }}
										{{ __('max') }}: {{ $section->max_works }}
								</dd>
								<dd class="px-5">
										{{ __('Min / max # works') }}: 
										{{ __('min') }}: {{ $section->min_works }}
										{{ __('to')  }}
										{{ __('max') }}: {{ $section->max_works }}
								</dd>

								<dd class="px-5">
										{{ __('Max px') }}: 
										{{ __(':shortsize for short side, and :longsize for long side', ['shortsize' => $section->short_size_max, 'longsize' => $section->long_size_max, ] ) }}
								</dd>
								<dd class="px-5">
										{{ __('Max px') }}: 
										{{ __(':shortsize for short side, and :longsize for long side', ['shortsize' => $section->short_size_max, 'longsize' => $section->long_size_max, ] ) }}
								</dd>

                <dd class="px-5">
                    {{ $section->monochromatic_required ? '✅ YES' : '❌ NO' }}
                    | 
                    {{ __('Monochrome only') }}
                </dd>

                <dd class="px-5">
                    {{ $section->raw_required ? '✅ YES' : '❌ NO' }}
                    | 
                    {{ __('RAW when asked') }}
                </dd>

                <dd class="px-5">
                    {{ $section->unique_prize ? '✅ YES' : '❌ NO' }}
                    | 
                    {{ __('Not cumulabile prizes in section') }} 
                </dd>
            </div>
            @endforeach
        </dl>
        @else
				<p class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
					{{ $federation->name_en }}
					<br />
					{{ __('No section n themes registered for that.' ) }}
				</p>
				@endif
			</div>
		</div>
	</div>
	<!-- -->
	<x-footer-app />
</div>
