<?php
/**
 * 2025-10-16 table refactor
 */
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
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' called');
        $this->federation_list = Federation::listed_by_country_id_name();
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' out:'. json_encode($this->federation_list));
    }
    /**
     * 2. show and stop
    */
    public function render()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' called');
        return view('livewire.federation.listed');
    }
}
