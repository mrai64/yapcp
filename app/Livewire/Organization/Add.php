<?php
/**
 * Organization CRUD: Create
 * - uuid
 * - country_code
 * 
 */
namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Organization;

class Add extends Component
{
    // uuid
    public string $country_code;
    public string $name;
    public string $email;
    public string $website;
    // created_at
    // updated_at
    // deleted_at

    public function save() 
    {
        // here rules() apply: true or fail
        $validated = $this->validate();
        // here we go!
        $org = New Organization();
        $org->create( $validated );
        // done back to list see web.php
        return redirect()
          ->route('organization-list')
          ->with('success', __('New Organization added to list, enjoy!') );
    }

    public function rules()
    {
        return [
            // TODO Country::idValidate( string ) : bool
            'country_code' => 'required|string|min:3|max:3',
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255',
            'website' => 'string|url|max:255',
        ];
    }
    
    public function render()
    {
        return view('livewire.organization.add');
    }
}
