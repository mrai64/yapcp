<?php

namespace App\Livewire\Federation;

use Livewire\Component;
use App\Models\Federation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Listed extends Component
{
    public $federation_list;
    /**
     * 1. before the show
     */
    public function mount() // no parm
    {
        Log::info(__FUNCTION__.':'.__LINE__);
        $this->federation_list = Federation::whereNull('deleted_at')
        ->orderBy('name')
        ->get();
        Log::info(__FUNCTION__.':'.__LINE__.' found: '. $this->federation_list);
    }
    /**
     * 2. show and stop
    */
    public function render()
    {
        Log::info(__FUNCTION__.':'.__LINE__);
        return view('livewire.federation.listed');
    }
}
