<?php

/**
 * Organization definition page
 *
 * Every user can register an organization before build
 * and blueprint any contest.
 *
 * 2025-12-05 review for Country::countriesSorted and Log
 * 2026-04-08 instance replace organization_id
 *
 * @see /resources/views/livewire/organization/add.blade.php
 *
 */

namespace App\Livewire\Organization;

use App\Models\Country;
use App\Models\Organization;
use Livewire\Component;

class Add extends Component
{
    // form fields
    public string $countryId;

    public string $name;

    public string $email;

    public string $organizationWebsite;

    public string $organizationContact;

    // created_at
    // updated_at
    // deleted_at

    public $countries;

    // 1. mount

    /**
     * 2. show
     */
    public function render()
    {
        $this->countries = Country::countriesSorted();

        return view('livewire.organization.add');
    }

    /**
     * 3. validation rules
     */
    public function rules()
    {
        return [
            'countryId' => 'required|string|exists:countries,id',
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255',
            'organizationWebsite' => 'string|url|max:255',
            'organizationContact' => 'string',
        ];
    }

    /**
     * after show
     */
    public function saveNewOrganization()
    {
        // here rules() apply: true or fail
        $validated = $this->validate();

        $organization = Organization::create([
            'country_id' => $validated['countryId'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'website' => $validated['organizationWebsite'],
            'contact' => $validated['organizationContact'],
        ]);

        // done back to list - see web.php
        return redirect()
            ->route('organization.list')
            ->with('success', __('New Organization added to list, enjoy!'));
    }
}
