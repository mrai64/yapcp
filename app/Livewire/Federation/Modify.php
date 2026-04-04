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
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Modify extends Component
{
    public Federation $federation;

    // readonly
    public string $id;

    #[Validate('required|string|max:255')]
    public string $federationNameEn = '';

    #[Validate('string|url|max:255')]
    public string $website = '';

    #[Validate('required|string|uppercase|min:3|exists:countries,id')]
    public string $countryId;

    #[Validate('string')]
    public string $federationContact = '';

    // readonly
    public $countries;

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

        $this->id                = $federation->id;
        $this->federationNameEn  = $federation->name_en;
        $this->website           = $federation->website;
        $this->countryId         = $federation->country_id;
        $this->federationContact = $federation->contact_info;

        $this->countries         = Country::countriesSorted();
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
     * see definition - no need rules()
     */

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
            'id'         => $this->id,
            'name_en'    => $validated['federationNameEn'],
            'website'    => $validated['website'],
            'country_id' => $validated['countryId'],
            'contact_info' => $validated['federationContact'],
        ]);

        // to list
        return redirect()
            ->route('federation.list')
            ->with('success', __('Federation data updated, thanks!'));
    }
}
