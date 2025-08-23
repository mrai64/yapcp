<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Federation;

class ShowFederationList extends Component
{
    public $federation_list = '';

    public function render()
    {
        $this->federation_list = Federation::all();
        return view('livewire.show-federation-list');
    }

}
