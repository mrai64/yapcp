<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Organization;

class Listed extends Component
{
    public $organization_list = null;

    public function render()
    {
        $this->organization_list = Organization::listed_by_country_id_name();
        return view('livewire.organization.listed');
    }
}
