<?php

/**
 * 2025-07-28 add $id (readonly) for federation-section and other child tables
 * 2025-08-30 add country_id, contact
 * 2025-09-20 enlarge 6 > 10 code field
 * 2025-10-16 refactor for new federation table
 * 2026-03-13 add Authorize - FederationPolicies
 *
 * @see /resources/views/livewire/federation/modify.blade.php
 *
 */

namespace App\Livewire\Federation;

use App\Models\Country;
use App\Models\Federation;
use App\Models\Timezone;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Modify extends Component
{
    public Federation $federation;

    public string $federationId;

    public string $federationNameEn = '';

    public string $website = '';

    public string $countryId;

    public string $timezoneId;

    public string $federationContact = '';

    // readonly
    public $countries;

    public $timezoneSet;

    /**
     * 1. Before the show
     */
    public function mount(Federation $federation) // as in route()
    {
        // authorize in FederationPolicy //
        // $userToCheck = User::find(Auth::id());
        // $this->authorize('update', $userToCheck);
        //
        Log::info('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called w/fid' . $federation->id);
        $this->federation = $federation; // was: Federation::where('id', $fid)->get()[0];
        Log::info('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' found:' . json_encode($this->federation));

        $this->federationId      = $federation->id;
        $this->federationNameEn  = $federation->name_en;
        $this->website           = $federation->website;
        $this->countryId         = $federation->country_id;
        $this->federationContact = $federation->contact_info;
        $this->timezoneId        = $federation->timezone_id ?? 'Europe/Rome';

        $this->countries         = Country::countriesSorted();
        $timezoneSet             = Timezone::all()->pluck(['id']);
        $this->timezoneSet       = collect($timezoneSet)->sortBy('id')->toArray();
    }

    /**
     * 2. Show it
     */
    public function render()
    {
        return view('livewire.federation.modify');
    }

    /**
     * 3. validation rules
     */
    public function rules() {
        return [
            'federationId' => [
                Rule::unique('federations', 'id')->ignore($this->federationId, 'id')
            ],
            'federationNameEn' => 'required|string|max:255',
            'website' => 'string|url|max:255',
            'countryId' => 'required|exists:countries,id',
            'timezoneId' => 'required|exists:timezones,id',
            'federationContact' => 'string',
        ];
    }

    /**
     * 4. After the show
     */
    public function updateFederation()
    {
        // authorize in FederationPolicy //
        // $userToCheck = User::find(Auth::id());
        // $this->authorize('update', $userToCheck);
        //
        Log::info('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' called');
        $validated = $this->validate();

        //
        $this->federation->update([
            'id'           => $validated['federationId'],
            'name_en'      => $validated['federationNameEn'],
            'website'      => $validated['website'],
            'country_id'   => $validated['countryId'],
            'timezone_id'  => $validated['timezoneId'],
            'contact_info' => $validated['federationContact'],
        ]);

        // to list
        return redirect()
            ->route('federation.list')
            ->with('success', __('Federation data updated, thanks!'));
    }
}
