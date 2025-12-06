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

    public $country;

    public function mount(string $id) // id as in route()
    {
        $org = new Organization;
        $this->organization = $org->findOrFail($id);
        $this->id = $this->organization->id; // uuid
        $this->country_id = $this->organization->country_id;
        $this->name = $this->organization->name;
        $this->email = $this->organization->email;
        $this->website = $this->organization->website;

        $this->country = DB::table(Country::table_name)
            ->whereNull('deleted_at')
            ->where('id', $this->country_id)
            ->pluck('id');
    }

    public function render()
    {
        return view('livewire.organization.remove');
    }

    /**
     * Validation rules
     */
    public function rules()
    {
        return [
            // TODO Country::idValidate( string ) : bool
            // https://laravel.com/docs/12.x/validation#available-validation-rules
            'country_id' => 'required|string|uppercase|min:3|max:3',
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255',
            'website' => 'string|url|max:255',
        ];
    }

    /**
     * At last (soft)Delete
     */
    public function delete()
    {
        $this->validate();

        $org = new Organization;
        $org->findOrFail($this->id)->delete();

        // back to list
        return redirect()
            ->route('organization-list')
            ->with('success', __('Organization data safely removed, thanks!'));
    }
}
