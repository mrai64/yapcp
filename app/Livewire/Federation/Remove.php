<?php

/**
 * Learning Laravel that panel show a readonly form
 * and last validate it's only a pro-forma
 *
 * 2025-08-30 Only show in read-only, add country_id and contact
 * 2025-01-16 refactorize for PSR-12
 * 2026-03-23 refactor for use of FederationPolicy
 *
 * @see blade /resources/views/livewire/federation/remove.blade.php
 *
 */

namespace App\Livewire\Federation;

use App\Models\Country;
use App\Models\Federation;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Remove extends Component
{
    public Federation $federation;

    #[Validate('required|string|uppercase|max:10')]
    public string $id;

    public $name = '';

    public $code = '';

    public $website = '';

    public $countryId = '';

    public $country;

    public $contact = '';

    public function mount(Federation $federation)
    {
        $this->federation = $federation;

        $this->name      = $this->federation->name_en;
        $this->id        = $this->federation->id;
        $this->code      = $this->federation->id;
        $this->website   = $this->federation->website;
        $this->countryId = $this->federation->country_id;
        $this->contact   = $this->federation->contact_info;
        $this->country   = Country::where('id', $this->countryId)->first();

        // TODO avoid delete Federation in most case
        // TODO because there are Contest with Federation Sponsor
        // TODO running, planned or closed less than a year-ago
        //
        // use a bool flag for chose between a "Turn U" | "Deletable"
        // button
    }

    public function render()
    {
        return view('livewire.federation.remove');
    }

    // rules()

    //
    public function deleteFederation()
    {
        $this->validate();
        $fed = new Federation();
        $fed->findOrFail($this->id)->delete();

        // to list
        return redirect()
            ->route('federation.list')
            ->with('success', __('Federation data safely removed, thanks!'));
    }

}
