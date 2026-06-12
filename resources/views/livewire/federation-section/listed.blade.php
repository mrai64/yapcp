<?php

/**
 * List 'federation section' fields for federation
 *
 */
use App\Models\Federation;
use App\Models\FederationSection;
use Illuminate\Support\Facades\Log;
use function Livewire\Volt\state;
use function Livewire\Volt\mount;

state([
    'federation',
    'sectionsSet' => []
]);

mount(function (Federation $federation): void {
    $this->federation = $federation;
    Log::debug('Volt: ' . __FILE__ . ' f:' . __FUNCTION__ . ' called for: ' . $this->federation->id );
    $this->sectionsSet = FederationSection::where('federation_id', $federation->id)
        ->orderBy('code', 'asc')
        ->get();
    Log::debug('Volt: ' . __FILE__ . ' f:' . __FUNCTION__ . ' sectionsSet: ' . json_encode($this->sectionsSet) );
});

?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Coded Section for Federation") }}:
            {{ $federation->id }}
            | {{ $federation->name_en }}
        </h2>
        <p class="small">
            {{ __("Federation(s) wrote Contest Regulatory doc(s), that must be followed by sponsored Contest Organizations.")}}
            {{ __("Then, when your Organization choose to follow any Federation Auspices / Patronage / Sponsorship")}}
            {{ __("that list help them to follow right way when build a contest blueprint.")}}
            <br />
            {{ __("When, for the competition, you choose the sponsorship of more than one federation,")}}
            {{ __("you will have to apply, for the overlapping rules, the more restrictive one.")}}
            <br />
            {{ __("When you see some difference with Federation official rules, please contact platform management for a for a fast alignment.")}} </small>
        </p>
        <hr />
        <p class="fyk text-xl mb-4">
            [ 
            <a href="{{ route('federation.list') }}" 
                rel="noopener noreferrer">
                &larr; 
                {{ __('Back to Federation list') }} 
            </a>
            ]
            . .
            [ 
            <a href="{{ route('federation-section.add', ['federation' => $federation ]) }}" 
                rel="noopener noreferrer">
                + 
                {{ __('Add New Federation Section') }} 
            </a>
            ]
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
            <div class="float-end font-medium rounded-md px-4 py-2">
                {{ session('success') }}
            </div> 
            <hr />
            @endif

        </div>

        @if ($sectionsSet->isEmpty())
        <div class="border text-xl rounded-md px-4 py-6 text-center text-gray-500">
            {{ __('No section defined for this federation. Add first now.') }}
        </div>
        @else
        <div class="table-responsive max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <table class="table table-primary table-striped w-full"        >
                <thead>
                    <tr>
                        <th scope="col">
                            {{ __('Code') }}
                        </th>
                        <th scope="col">
                            {{ __('Description') }}
                        </th>
                        <th scope="col">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @foreach ($sectionsSet as $sec)
                    <tr class="border my-2 py-2">
                        <td scope="row">
                            {{ $sec->code }}
                        </td>
                        <td >
                            {{ $sec->name_en }}
                            <br />
                            {{ $sec->rule_definition }}
                        </td>
                        <td nowrap>
                            <a href="{{ route('federation-section.modify', ['federation_section' => $sec] ) }}">
                                [ {{ __("Modify") }} ]
                            </a>
                            <br />
                            <a href="{{ route('federation-section.delete', ['federation_section' => $sec] ) }}">
                                [ {{ __("Remove") }} ]
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div><!-- section list table -->
        @endif
        <x-footer-app />
    </div>
</div>