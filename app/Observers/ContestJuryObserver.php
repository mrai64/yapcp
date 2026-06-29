<?php

namespace App\Observers;

use App\Models\ContestJury;

class ContestJuryObserver
{
    /**
     * Handle the ContestJury "created" event.
     */
    public function created(ContestJury $contestJury): void
    {
        //
    }

    /**
     * Handle the ContestJury "updated" event.
     */
    public function updated(ContestJury $contestJury): void
    {
        //
    }

    /**
     * Handle the ContestJury "deleted" event.
     */
    public function deleted(ContestJury $contestJury): void
    {
        //
    }

    /**
     * Handle the ContestJury "restored" event.
     */
    public function restored(ContestJury $contestJury): void
    {
        //
    }

    /**
     * Handle the ContestJury "force deleted" event.
     */
    public function forceDeleted(ContestJury $contestJury): void
    {
        //
    }
}
