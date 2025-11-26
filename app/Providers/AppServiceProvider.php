<?php
/**
 * 2025-10-11 Add first gates 'contest-participants-update'
 * 2025-11-26 Add 'juror-only' gate
 * 
 */
namespace App\Providers;

use App\Policies\ContestPaymentChangePolicy;
use App\Policies\JurorOnlyPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Gate::define('contest-participants-update', [ContestPaymentChangePolicy::class, 'update']);
        Gate::define('jury-panels', [JurorOnlyPolicy::class, 'grant_access']);
    }
}
