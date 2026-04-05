<?php

/**
 * Federation Section Lst
 * federation_section
 * child of: federation
 *
 * 2025-10-16 federations and federation_sections refactorize
 *
 * @see /resources/views/livewire/federation/section/listed.blade.php
 *
 *
 */

namespace App\Livewire\Federation\Section;

use App\Models\Federation;
use App\Models\FederationSection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Listed extends Component
{
    public Federation $federation;

    public $section;

    /**
     * 1. Before the show
     */
    public function mount(Federation $federation)
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $this->federation = $federation;
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__
            . ' federation:' . json_encode($this->federation));

    }

    /**
     * 2. Show
     */
    public function render()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $this->section = FederationSection::where('federation_id', $this->federation->id)
        ->orderBy('code')
        ->get();
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' section:' . json_encode($this->section));
        //
        return view('livewire.federation.section.listed');
    }
    // no other
}
