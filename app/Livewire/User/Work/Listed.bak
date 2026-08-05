<?php

namespace App\Livewire\User\Work;

use App\Models\UserContact;
use App\Models\UserWork;
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

        $this->userWorkList = UserWork::where('user_id', $this->userContact['id'])
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
