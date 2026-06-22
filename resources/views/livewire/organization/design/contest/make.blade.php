<?php

/**
 * Organization design contest - Step 0
 * build contest for organization_id
 * then pass to modify1
 */

use App\Models\Contest;
use App\Models\Organization;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public function mount(Organization $organization)
    {
        $userContact = Auth::user()->contact;
        $contest = Contest::create([
                // id
                'country_id' => $organization->country_id,
                'name_en' => '',
                // lang_local
                // name_local
                'organization_id' => $organization->id,
                // 'is_circuit' => 'N'
                // circuit_id => null
                'federation_list' => '',
                'contest_mark' => '',
                'contact_info' => '',
                'award_ceremony_info' => '',
                'fee_info' => '',
                // vote_rule
                // url_1_rule
                // url_2_concurrent_list
                // url_3_admit_n_award_list
                // url_4_catalogue
                'timezone_id'        => $userContact->timezone_id,
                'day_1_opening'      => CarbonImmutable::now()->addYear(),
                'day_2_closing'      => CarbonImmutable::now()->addYear()->addMonths(3),
                'day_3_jury_opening' => CarbonImmutable::now()->addYear()->addMonths(3)->addDays(15),
                'day_4_jury_closing' => CarbonImmutable::now()->addYear()->addMonths(4),
                'day_5_revelations'  => CarbonImmutable::now()->addYear()->addMonths(4)->addWeek(),
                'day_6_awards'       => CarbonImmutable::now()->addYear()->addMonths(4)->addWeeks(3),
                'day_7_catalogues'   => CarbonImmutable::now()->addYear()->addMonths(5),
                'day_8_closing'      => CarbonImmutable::now()->addYear()->addMonths(6),
            ]);

        return redirect()
            ->route('organization.design.contest.modify1', ['contest' => $contest])
            ->with('success', __("Start Modify your Contest"));
    }

}; ?>

<div>
    //
</div>
