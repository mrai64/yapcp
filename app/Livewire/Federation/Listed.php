<?php

namespace App\Livewire\Federation;

use Livewire\Component;
use App\Models\Federation;

class Listed extends Component
{
    public $federations_list = [];

    public function render()
    {
        $this->federations_list = Federation::all();
        // TODO order by name
        // TODO order by country_code, name
        return view('livewire.federation.listed');
    }
}
