<?php

/**
 * mockup - that module must be builded
 *
 * pick data
 * expose and ask confirm
 * at confirm delete record then return to Contest Section list
 * or contest main card
 *
 */

namespace App\Livewire\Contest\Section;

use Livewire\Component;

class Remove extends Component
{
    public function render()
    {
        return view('livewire.contest.section.remove');
    }
}
