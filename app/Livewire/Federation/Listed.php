<?php

namespace App\Livewire\Federation;

use Livewire\Component;
use App\Models\Federation;
use Illuminate\Support\Facades\DB;

class Listed extends Component
{
    public $federation_list;

    public function render()
    {
        // $this->federation_list = Federation::all();
        $fed = new Federation();
        $this->federation_list = DB::table( Federation::table_name )
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
        return view('livewire.federation.listed');
    }
}
