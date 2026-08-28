<?php

/**
 * FederationMore - Remove a record
 *
 */

use App\Models\Federation;
use App\Models\FederationMore;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class () extends Component {
    public FederationMore $fedMore;
    public Federation $federation;
    public bool $isAdmin;
    //
    public function mount(FederationMore $federation_more)
    {
        $this->isAdmin = Auth::user()->isAdmin() ?? false;
        $this->fedMore = $federation_more;
        $this->federation = $this->fedMore->federation;
        //
    }
    //
    public function removeFederationMore()
    {
        Log::info('User admin ['. Auth::user()->id . ' ' . Auth::user()->name
            . '] request remove of: '
            . json_encode($this->fedMore));
        //
        $this->fedMore->delete();
        //
        return redirect()
            ->route('federation-more.listed', ['federation' => $this->federation ])
            ->with('success', __('Federation More Field removed. Good Luck!'));
    }

}; ?>

<div>
	<x-slot name="header">
		<h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
			{{ $federation->name_en }}
			<br />
            <span class="text-red-600">
                {{ __('Federation More fields REMOVE' ) }}
            </span>
		</h2>
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

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-500 hover:border-indigo-300 transition-colors relative">
                    <table class="data-table-container w-full">
                        <tbody>
                            <tr>
                                <td class="fyk text-2xl font-bold w-60">
                                    {{ __("Referenced table name") }}
                                </td>
                                <td class="fyk text-2xl font-bold w-auto  text-indigo-700">
                                    {{ $fedMore->referenced }}
                                </td>
                            </tr>
                            <tr>
                                <td class="fyk text-2xl font-bold w-60">
                                    {{ __("Field Label") }}
                                </td>
                                <td class="fyk text-2xl font-bold  text-indigo-700">
                                    {{ $fedMore->field_label }}
                                </td>
                            </tr>
                            <tr>
                                <td class="">
                                    {{ __("Field Id") }}
                                </td>
                                <td class="font-mono">
                                    {{ $fedMore->field_name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="">
                                    {{ __("Validation rules") }}
                                </td>
                                <td class="font-mono">
                                    {{ $fedMore->field_validation_rules }}
                                </td>
                            </tr>
                            <tr>
                                <td class="">
                                    {{ __("Default value") }}
                                </td>
                                <td class="font-mono">
                                    {{ ($fedMore->field_default_value) ? ($fedMore->field_default_value) : '" " (space)' }}                                    </td>
                            </tr>
                            <tr>
                                <td class="">
                                    {{ __("Suggest") }}
                                </td>
                                <td class="font-mono">
                                    {{ $fedMore->field_suggest }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <form wire:submit="removeFederationMore">
                    @csrf
                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('LAST CALL. Are you SURE to delete that?') }}
                    </x-button>
                </form>
			</div>
		</div>
	</div>
	<!-- -->
	<x-footer-app />
</div>
