<?php
/**
 * federation/section 
 * child of: federation 
 */
namespace App\Livewire\Federation\Section;
use App\Models\Federation;
use App\Models\FederationSection;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class Listed extends Component
{
    public $federation;

    public $section;

    /**
     * 
     */
    public function mount(int $fid) // same name in route()
    {
        $f = New Federation();
        $this->federation = $f->findOrFail($fid);

        $this->section = DB::table( FederationSection::table_name )
            ->whereNull('deleted_at')
            ->where('federation_id', $fid)
            ->orderBy('code')
            ->get();
    }

    public function render()
    {
        return view('livewire.federation.section.listed');
    }
}
