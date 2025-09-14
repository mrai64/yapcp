<?php
/**
 * Organization\Modify
 */
namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Organization;
use App\Models\Country;
use Livewire\Attributes\Validate;

class Modify extends Component
{
    public Organization $organization;

    // uuid
    public string $country_id;
    public string $name;
    public string $email;
    public string $website;
    // created_at
    // updated_at
    // deleted_at

    // readonly 
    public $countries;

    /**
     * Be prepared
     */
    public function mount(string $id) // as 'id' in route()
    {
        $org = new Organization();
        $this->organization = $org->findOrFail($id);
        // id uuid
        $this->country_id = $this->organization->country_id;
        $this->name         = $this->organization->name;
        $this->email        = $this->organization->email;
        $this->website      = $this->organization->website;
        // created_at
        // updated_at
        // deleted_at
    }

    /**
     * Show must go
     */
    public function render()
    {
        $country = new Country();
        $this->countries = $country->allByCountry();

        return view('livewire.organization.modify');
    }

    /**
     * Validation rules
     */
    public function rules()
    {
        return [
            // 'country_id' => 'required|string|uppercase|min:3|max:3',
            'country_id' => 'required|string|uppercase|min:3|exists:countries,id',
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255',
            'website' => 'string|url|max:255',
        ];
    }

    /**
     * At last, Update?
     */
    public function update()
    {
        $this->validate();
        $this->organization->update(
            $this->all()
        );
        // to list 
        return redirect()
            ->route('organization-list')
            ->with('success', __('Organization data updated, thanks!') );
    }
}
