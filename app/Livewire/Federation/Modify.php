<?php

/**
 * 2025-07-28 add $id (readonly) for federation-section and other child tables
 * 2025-08-30 add country_id, contact
 * 2025-09-20 enlarge 6 > 10 code field
 * 2025-10-16 refactor for new federation table
 */

namespace App\Livewire\Federation;

use App\Models\Country;
use App\Models\Federation;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Modify extends Component
{
    public $federation;

    public $id;

    #[Validate('required|string|max:255')]
    public $name_en = '';

    #[Validate('string|url|max:255')]
    public $website = '';

    #[Validate('required|string|uppercase|min:3|exists:countries,id')]
    public $country_id;

    #[Validate('string')]
    public $contact_info;

    // readonly
    public $countries;

    /**
     * 1. Before the show
     */
    public function mount(string $fid) // $fid as 'fid' in route()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' fid'.$fid);
        $this->federation = Federation::where('id', $fid)->get()[0];
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' found:'.json_encode($this->federation));

        $this->id = $fid;
        $this->name_en = $this->federation['name_en'];
        $this->website = $this->federation['website'];
        $this->country_id = $this->federation['country_id'];
        $this->contact_info = $this->federation['contact_info'];
        $this->countries = Country::country_list_by_country();

    }

    /**
     * 2. Show it
     */
    public function render()
    {

        return view('livewire.federation.modify');
    }

    /**
     * 3. validation rules
     */

    /**
     * 4. After the show
     */
    public function update_federation()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $validated = $this->validate();

        //
        $this->federation->update($validated);

        // to list
        return redirect()
            ->route('federation-list')
            ->with('success', __('Federation data updated, thanks!'));
    }
}
