<?php

namespace App\Livewire\Federation;

use Livewire\Component;
use App\Models\Federation;

class Listed extends Component
{
    public $federation_list = [];

    public function render()
    {
        $this->federation_list = Federation::all();
        // TODO order by name
        // TODO order by country_code, name
        return view('livewire.federation.listed');
    }
}
