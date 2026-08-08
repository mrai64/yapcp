<?php

/**
 * UserWork Modify 
 *
 * Some fields are modifyable, not all, not even
 *
 */

use App\Models\UserWork;
use App\Models\UserWorkMore;
use Livewire\Volt\Component;

new class extends Component {
    public UserWork $userWork;
    public bool     $isLandscape;
    public int      $width;
    public int      $height;
    public string   $imageUrl;
    // mount()
    // no wth()
    public function mount(UserWork $user_work)
    {
        $this->userWork = $user_work;
        $this->isLandscape = $userWork

    }
}; ?>

<div>
    //
</div>
