<?php

namespace App\Livewire;

use Livewire\Component;

class Federation extends Component
{
    // public $country_code = '';
    public $code = ''; 
    public $name = '';
    public $website = '';

    public function render()
    {
        return view('livewire.federation');
    }

    public function changeName(string $newName)
    {
        $this->name = $newName;
    }


}
