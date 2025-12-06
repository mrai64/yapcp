<?php

/**
 * Header for contest pages
 * require a section_id to recover contest_id
 * then ...
 *
 * For Contest definition
 * input: uuid, should be a contest_id xor section_id
 */

namespace App\Livewire\Contest;

use App\Models\ContestSection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DefineHeader extends Component
{
    public $section_id;

    public $contest_id;

    public $section;

    public function mount(string $sid) // livewire param
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $this->section_id = $sid;
        $this->section = ContestSection::where('id', $sid)->first();
        $this->contest_id = $this->section->contest_id;

    }

    public function render()
    {
        return view('livewire.contest.define-header');
    }
}
