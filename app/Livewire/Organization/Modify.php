<?php

/**
 * Organization Definition Modify
 *
 * 2025-12-05 review for Country::countriesSorted and Log
 * 2026-03-26 changed mount input from id to organization
 *
 * @see /resources/views/livewire/organization/modify.blade.php
 *
 */

namespace App\Livewire\Organization;

use App\Models\Country;
use App\Models\Organization;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Modify extends Component
{
    public Organization $organization;

    // uuid
    public string $id;

    public string $countryId;

    public string $name;

    public string $email;

    public string $website;

    public string $contact;

    // created_at
    // updated_at
    // deleted_at

    // readonly
    public $countries;

    /**
     * 1. Before the show
     */
    public function mount(Organization $organization) // route
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . 'l :' . __LINE__ . ' called');
        $this->id            = $organization->id;
        $this->organization  = $organization;
        $this->countryId     = $this->organization->country_id;
        $this->name          = $this->organization->name;
        $this->email         = $this->organization->email;
        $this->website       = $this->organization->website ?? '';
        $this->contact       = $this->organization->contact ?? '';

        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . 'l :' . __LINE__ . ' out:' . json_encode($this));
        // created_at
        // updated_at
        // deleted_at
    }

    /**
     * 2. Show must go
     */
    public function render()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . 'l :' . __LINE__ . ' called');
        $this->countries = Country::countriesSorted();

        return view('livewire.organization.modify');
    }

    /**
     * 3. Validation rules
     */
    public function rules()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . 'l :' . __LINE__ . ' called');

        return [
            'countryId' => 'required|string|uppercase|min:3|exists:countries,id',
            'name'      => 'required|string|min:3|max:255',
            'email'     => 'required|string|email|max:255|unique:organization,email',
            'website'   => 'string|url|max:255|unique:organization,website',
            'contact'   => 'string|max:1000',
        ];
    }

    /**
     * 4. At last, Update
     */
    public function updateOrganization()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . 'l :' . __LINE__ . ' called');
        $validated = $this->validate();

        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . 'l :' . __LINE__ . ' validate:' . json_encode($validated));
        $this->organization->update([
        //  'id'           => $this->organization->id,
            'country_id'   => $validated['countryId'],
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'website'      => $validated['website'],
            'contact'      => $validated['contact'],
        ]);

        // to list
        return redirect()
            ->route('organization.list')
            ->with('success', __('Organization data updated, thanks!'));
    }
}
