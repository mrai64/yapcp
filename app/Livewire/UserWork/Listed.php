<?php

namespace App\Livewire\Work;

use App\Models\UserContact;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Listed extends Component
{
    public $userId = null;

    public $userContact = null;

    public $country = [];

    public $userWorkList = [];

    public $odd; // alternated background rows

    /**
     * 1. Before the show
     */
    public function mount()
    {
        $this->userId = Auth::id();

        $this->userContact = UserContact::where('id', $this->userId)->first();

        $this->country = $this->userContact->country;

        $this->userWorkList = Work::whereNull('deleted_at')
            ->where('user_id', $this->userContact['id'])
            ->orderBy('title_en')
            ->get();

        $this->odd = true;
    }

    /**
     * 2. The show
     */
    public function render()
    {
        return view('livewire.work.listed');
    }
}
