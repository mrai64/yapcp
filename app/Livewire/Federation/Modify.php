<?php
/**
 * 2025-07-28 add $id (readonly) for federation-section and other child tables
 * 2025-08-30 add country_id, contact
 */
namespace App\Livewire\Federation;

use Livewire\Component;
use App\Models\Federation;
use App\Models\Country;
use Livewire\Attributes\Validate;

class Modify extends Component
{
    public Federation $federation;

    // readonly
    public $id;

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|max:6')]
    public $code = '';

    #[Validate('string|url|max:255')]
    public $website = '';

    #[Validate('required|string|uppercase|min:3|exists:countries,id')]
    public $country_id;

    #[Validate('string')]
    public $contact;

    //readonly
    public $countries;

    /**
     * Before the show
     */
    public function mount(int $id) // $id as 'id' in route()
    {
        // $this->federation = Federation::findOrFail($id);
        $fed = New Federation();
        $this->federation = $fed->findOrFail($id);

        $this->id         = $this->federation->id;
        $this->name       = $this->federation->name;
        $this->code       = $this->federation->code;
        $this->website    = $this->federation->website;
        $this->country_id = $this->federation->country_id;
        $this->contact    = $this->federation->contact;
    }

    /**
     * Show it
     */
    public function render()
    {
        $country = New Country();
        $this->countries = $country->allByCountry();

        return view('livewire.federation.modify');
    }

    /**
     * After the show
     */
    public function update()
    {
        $this->validate();
        //
        $this->federation->name       = $this->name;
        $this->federation->code       = $this->code;
        $this->federation->website    = $this->website;
        $this->federation->country_id = $this->country_id;
        $this->federation->contact    = $this->contact;

        $this->federation->update(
            $this->all()
        );
        // to list
        return redirect()
            ->route('federation-list')
            ->with('success', __('Federation data updated, thanks!') );

    }


}
