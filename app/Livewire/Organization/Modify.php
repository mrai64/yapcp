<?php
/**
 * Organization\Modify
 */
namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Organization;
use Livewire\Attributes\Validate;

class Modify extends Component
{
    public Organization $organization;
    // uuid
    public string $country_code;
    public string $name;
    public string $email;
    public string $website;
    // created_at
    // updated_at
    // deleted_at

    /**
     * Validation rules
     */
    public function rules()
    {
        return [
            // TODO Country::idValidate( string ) : bool
            // https://laravel.com/docs/12.x/validation#available-validation-rules
            'country_code' => 'required|string|uppercase|min:3|max:3',
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

    /**
     * Be prepared
     */
    public function mount(string $id) // as 'id' in route()
    {
        $org = New Organization();
        $this->organization = $org->findOrFail($id);
        // id uuid
        $this->country_code = $this->organization->country_code;
        $this->name         = $this->organization->name;
        $this->email        = $this->organization->email;
        $this->website      = $this->organization->website;
        // created_at
        // updated_at
        // deleted_at
    }

    public function render()
    {
        return view('livewire.organization.modify');
    }
}
