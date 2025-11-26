<?php
/**
 *
 */
namespace App\Livewire\Juror;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SingleDia extends Component
{

    public string $dias;

    public function mount(string $imgdias) // livewire input
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called w/input:' . $imgdias);
        $this->dias = ( $imgdias );
    }

    public function placeholder()
    {
        return "\n".'<div style="float:left;width:300px !important;height:300px !important;background-color:#f0f0f0;border:10px solid #ccc;display:flex;justify-content: center;align-items: center;box-shadow: 0 0 10px rgba(0,0,0,0.2);margin-top:.5rem;margin-right:.5rem;"> Loading </div>';
    }

    public function render()
    {
        return view('livewire.juror.single-dia');
    }
}
