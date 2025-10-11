<?php
/**
 * 2025-10-11 Add first gates 'contest-participants-update'
 * 
 */
namespace App\Providers;

use App\Policies\ContestPaymentChangePolicy;
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
    }
}
