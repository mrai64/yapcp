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
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;

class Add extends Component
{
    public string $id = '';
    public string $name_en = '';
    public string $website = '';
    public string $country_id = '';
    public string $contact_info = '';

    public $countries;

    /**
     * 1. Before the show
     * 2. Show
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' called');
        $country = new Country();
        $this->countries = $country->allByCountry();
        
        return view('livewire.federation.add');
    }
    /** 
     * 3. list of validation rules
     * 
    */
    public function rules()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' called');
        return [
            'id' => 'required|string|uppercase|min:3|max:10|unique:federations,id',
            'name_en' => 'required|string|min:3|max:255',
            'country_id' => 'required|string|uppercase|min:3|exists:countries,id',
            'website' => 'string|active_url|max:255',
            'contact_info' => 'string',
        ];
    }
    /**
     * 4. Receive form data then back w/error or
     * redirect to list
    */
    public function save_federation()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' called');
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' in');
        $validated = $this->validate();
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' validated:'.json_encode($validated) );
        
        $fed = Federation::create($validated);
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' validated:'.json_encode($fed) );
        
        return redirect()
          ->route('federation-list')
          ->with('success', __('New Federation added to list, enjoy!') );
    }
}
