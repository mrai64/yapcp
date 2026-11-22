<?php

/**
 * Organization Design Contest - Step 0
 * build circuit for group of contest followed by organization_id
 * then pass to modify-name
 * 
 */

use App\Models\Contest;
use App\Models\Organization;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class () extends Component {
    //
    public function mount(Organization $organization)
    {
        $userContact = Auth::user()->contact;
        $circuit = Contest::create([
            // id assigned
            'country_id'           => $organization->country_id,
            'name_en'              => '', // empty but not default
            // 'lang_local'
            'name_local'           => '', // empty but not default
            'organization_id'      => $organization->id,
            'is_circuit'           => true,
            // 'circuit_id'
            'contest_mark'         => '', // file path to logo
            'contact_info'         => '', // without default
            'award_ceremony_info'  => '', // without default
            'fee_info'             => '', // without default
            // 'vote_rule'
            // url_1_rule
            // url_2_concurrent_list
            // url_3_admit_n_award_list
            // url_4_catalogue
            'timezone_id'        => $userContact->timezone_id,
            'day_1_opening'      => CarbonImmutable::now()->addYear()->startOfDay(),
            'day_2_closing'      => CarbonImmutable::now()->addYear()->addMonths(3)->endOfDay(),
            'day_3_jury_opening' => CarbonImmutable::now()->addYear()->addMonths(3)->addDays(15)->startOfDay(),
            'day_4_jury_closing' => CarbonImmutable::now()->addYear()->addMonths(4)->endOfDay(),
            'day_5_revelations'  => CarbonImmutable::now()->addYear()->addMonths(4)->addWeek()->endOfDay(),
            'day_6_awards'       => CarbonImmutable::now()->addYear()->addMonths(4)->addWeeks(3)->endOfDay(),
            'day_7_catalogues'   => CarbonImmutable::now()->addYear()->addMonths(5)->endOfDay(),
            'day_8_closing'      => CarbonImmutable::now()->addYear()->addMonths(6)->endOfDay(),
        ]);

        return redirect()
            ->route('organization.design.circuit.modify-name', ['contest' => $circuit])
            ->with('success', __("Start Modify your Circuit"));
    }
}; ?>

<div>
    // <!-- no web -->
</div>
