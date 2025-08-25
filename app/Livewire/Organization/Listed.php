<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Organization;

class Listed extends Component
{
    public $organization_list = null;

    public function render()
    {
        $this->organization_list = Organization::ListedByCountryCodeName();
        return view('livewire.organization.listed');
    }
}
