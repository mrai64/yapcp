<?php

/**
 * User, you are juror in these contest
 *
 * CLASS: app/Livewire/Contest/Jury/Listed . php
 * VIEW:  resources/views/livewire/contest/jury/listed . blade . php
 *
 * Create n show the list "where user is named as juror in"
 */

namespace App\Livewire\Contest\Jury;

use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Listed extends Component
{
    // input
    public $jurorUserContactId;

    public UserContact $juror;

    public $juries;

    /**
     * 1. Before the show
     */
    public function mount() // no parm as use Auth::id
    {
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' called');

        $this->jurorUserContactId = Auth::id();
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' jurorUserContactId:' . json_encode($this->jurorUserContactId));

        $this->juror = UserContact::where('user_id', $this->jurorUserContactId)->first();
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' juror:' . json_encode($this->juror));

        $this->juries = $this->juror->juries;
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' juries:' . json_encode($this->juries));

    }

    /**
     * 2. Show
     */
    public function render()
    {
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' called');
        if ($this->juries->count() == 0) {
            return view('livewire . contest . jury . listed-none');
        }

        return view('livewire . contest . jury . listed');
    }
}
