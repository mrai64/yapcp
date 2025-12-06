<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
use Livewire\Component;

class Listed extends Component
{
    public $organization_list = null;

    public function render()
    {
        $this->organization_list = Organization::listed_by_country_id_name();

        return view('livewire.organization.listed');
    }
}
