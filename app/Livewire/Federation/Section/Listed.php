<?php

/**
 * Federation Section Lst
 * federation_section
 * child of: federation
 *
 * 2025-10-16 federations and federation_sections refactorize
 */

namespace App\Livewire\Federation\Section;

use App\Models\Federation;
use App\Models\FederationSection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Listed extends Component
{
    public $federation;

    public $section;

    /**
     * 1. Before the show
     */
    public function mount(string $fid) // same name in route()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $this->federation = Federation::where('id', $fid)->first();
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' federation:'.json_encode($this->federation));

        $this->section = FederationSection::where('federation_id', $fid)
            ->orderBy('code')
            ->get();
    }

    /**
     * 2. Show
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');

        return view('livewire.federation.section.listed');
    }
}
