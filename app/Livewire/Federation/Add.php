<?php
/**
 * 2025-08-30 update w/new columns country_id, contact, add Country
 */
namespace App\Livewire\Federation;

use Livewire\Component;
use App\Models\Federation;
use App\Models\Country;
use Livewire\Attributes\Validate;

class Add extends Component
{
    public string $code = '';
    public string $name = '';
    public string $website = '';
    public string $country_id = '';
    public string $contact = '';

    public $countries;
    
    /**
     * Receive form data then back w/error or
     * redirect to list
     */
    public function save()
    {
        $validated = $this->validate();
        // Federation::create($validated);
        $fed = new Federation();
        $fed->create($validated);

        return redirect()
          ->route('federation-list')
          ->with('success', __('New Federation added to list, enjoy!') );
    }

    /** 
     * list of validation rules
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'code' => 'required|string|min:3|max:6',
            'website' => 'string|url|max:255',
            'country_id' => 'required|string|uppercase|min:3|exists:countries,id',
            'contact' => 'string',
        ];
    }

    public function render()
    {
        $country = new Country();
        $this->countries = $country->allByCountry();

        return view('livewire.federation.add');
    }
}
