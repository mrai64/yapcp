<?php
/**
 * Organization\Modify
 */
namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Organization;
use App\Models\Country;
use Illuminate\Support\Facades\Log;

class Modify extends Component
{
    public Organization $organization;

    // uuid
    public string $id;
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
     * 1. Before the show
     */
    public function mount(string $id) // as 'id' in route()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        // $org = new Organization();
        // $this->organization = $org->findOrFail($id);
        $this->id           = $id;
        $this->organization = Organization::where('id', $id)->get()[0];
        $this->country_id   = $this->organization->country_id;
        $this->name         = $this->organization->name;
        $this->email        = $this->organization->email;
        $this->website      = $this->organization->website;
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.json_encode($this));
        // created_at
        // updated_at
        // deleted_at
    }
    
    /**
     * 2. Show must go
    */
    public function render()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $country = new Country();
        $this->countries = $country->allByCountry();
        
        return view('livewire.organization.modify');
    }
    
    /**
     * 3. Validation rules
    */
    public function rules()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        return [
            // 'country_id' => 'required|string|uppercase|min:3|max:3',
            'country_id' => 'required|string|uppercase|min:3|exists:countries,id',
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255',
            'website' => 'string|url|max:255',
        ];
    }
    
    /**
     * 4. At last, Update?
    */
    public function update_organization()
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $validated = $this->validate();
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' validate:'.json_encode($validated));
        $this->organization->update($validated);
        // to list 
        return redirect()
            ->route('organization-list')
            ->with('success', __('Organization data updated, thanks!') );
    }
}
