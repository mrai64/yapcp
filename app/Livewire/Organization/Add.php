<?php

/**
 * Organization definition page
 *
 * 2025-12-05 review for Country::countriesSorted and Log
 */

namespace App\Livewire\Organization;

use App\Models\Country;
use App\Models\Organization;
use Livewire\Component;

class Add extends Component
{
    // uuid
    public string $country_id;

    public string $name;

    public string $email;

    public string $website;

    // created_at
    // updated_at
    // deleted_at
    public $countries;

    /**
     * before show
     */
    public function render()
    {
        $this->countries = Country::countriesSorted();

        return view('livewire.organization.add');
    }

    /**
     * after show
     */
    public function rules()
    {
        return [
            'country_id' => 'required|string|exists:countries,id',
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255',
            'website' => 'string|url|max:255',
        ];
    }

    /**
     * after show
     */
    public function save()
    {
        // here rules() apply: true or fail
        $validated = $this->validate();

        // here we go!
        $org = new Organization();
        $org->create($validated);

        // done back to list - see web.php
        return redirect()
            ->route('organization-list')
            ->with('success', __('New Organization added to list, enjoy!'));
    }
}
