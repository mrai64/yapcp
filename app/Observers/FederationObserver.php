<?php

namespace App\Observers;

use App\Jobs\CascadeDeleteFederationJob;
use App\Models\Federation;
use Illuminate\Support\Facades\Log;

class FederationObserver
{
    /**
     * Handle the Federation "created" event.
     */
    public function created(Federation $federation): void
    {
        //
    }

    /**
     * Handle the Federation "updated" event.
     */
    public function updated(Federation $federation): void
    {
        //
    }

    /**
     * Handle the Federation "deleted" event.
     */
    public function deleted(Federation $federation): void
    {
        Log::info("FederationObserver: Metodo deleted attivato per la federazione " . $federation->id);
        CascadeDeleteFederationJob::dispatch($federation);
    }

    /**
     * Handle the Federation "restored" event.
     */
    public function restored(Federation $federation): void
    {
        //
    }

    /**
     * Handle the Federation "force deleted" event.
     */
    public function forceDeleted(Federation $federation): void
    {
        //
    }
}
