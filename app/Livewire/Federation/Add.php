<?php
/**
 * 2025-08-30 update w/new columns country_id, contact, add Country
 * 2025-09-20 moved function in other order
 * 
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
     * 1. Before the show
     * 
     */
    public function render()
    {
        $country = new Country();
        $this->countries = $country->allByCountry();

        return view('livewire.federation.add');
    }
    /** 
     * 2. list of validation rules
     * 
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'code' => 'required|string|min:3|max:10',
            'website' => 'string|url|max:255',
            'country_id' => 'required|string|uppercase|min:3|exists:countries,id',
            'contact' => 'string',
        ];
    }
    /**
     * 3. Receive form data then back w/error or
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
}
