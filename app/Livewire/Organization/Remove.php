<?php

/**
 * Organization\Remove
 */

namespace App\Livewire\Organization;

use App\Models\Country;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Remove extends Component
{
    public Organization $organization;

    public string $id; // not int id but uuid

    public string $country_id;

    public string $name;

    public string $email;

    public string $website;
    // created_at
    // updated_at
    // deleted_at

    public string $country;

    public function mount(Organization $organization) // organization as in route()
    {
        $this->organization = $organization;
        $this->id = $organization->id; // uuid
        $this->country_id = $organization->country_id;
        $this->name = $organization->name;
        $this->email = $organization->email;
        $this->website = $organization->website;

        $country = Country::find($this->country_id);
        $this->country = $country->flag_code . " | " . $country->country;
    }

    public function render()
    {
        return view('livewire.organization.remove');
    }

    /**
     * At last (soft)Delete
     */
    public function deleteOrganization()
    {
        $this->organization->delete();

        // back to list
        return redirect()
            ->route('organization.list')
            ->with('success', __('Organization data safely removed, thanks!'));
    }
}
