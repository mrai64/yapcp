<?php

/**
 * 2025-08-30 Only show in read-only, add country_id and contact
 * 2025-01-16 refactorize for PSR-12
 */

namespace App\Livewire\Federation;

use App\Models\Country;
use App\Models\Federation;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Remove extends Component
{
    public Federation $federation;

    #[Validate('required|int')]
    public $id;

    public $name = '';

    public $code = '';

    public $website = '';

    public $countryId = '';

    public $country;

    public $contact = '';

    public function mount(int $id)
    {
        $this->federation = Federation::findOrFail($id);

        $this->name = $this->federation->name_en;
        $this->code = $this->federation->id;
        $this->website = $this->federation->website;
        $this->countryId = $this->federation->country_id;
        $this->contact = $this->federation->contact_info;
        $this->country = Country::where('id', $this->countryId)->first();
    }

    public function delete()
    {
        $this->validate();
        $fed = new Federation();
        $fed->findOrFail($this->id)->delete();

        // to list
        return redirect()
            ->route('federation-list')
            ->with('success', __('Federation data safely removed, thanks!'));
    }

    public function render()
    {
        return view('livewire.federation.remove');
    }
}
