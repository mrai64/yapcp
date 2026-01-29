<?php

/**
 * 2025-10-11 Add first gates 'contest-participants-update'
 * 2025-11-26 Add 'juror-only' gate
 * 2026-01-29 Add 'version' in footer 
 */

namespace App\Providers;

use App\Policies\ContestPaymentChangePolicy;
use App\Policies\JurorOnlyPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
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
        // for version: yyyy-m-nnn in footer
        View::composer('*', function ($view) {
            $version = '0.0.0';
            // storage/app/private
            if (Storage::disk('local')->exists('version.json')) {
                $registered = json_decode(Storage::disk('local')->get('version.json'), true );
                $version = $registered['full'] ?? '0.0.0';
            }

            $view->with('appVersion', $version);
        });

        // Gate Policy
        Gate::define('contest-participants-update', [ContestPaymentChangePolicy::class, 'update']);
        Gate::define('jury-panels', [JurorOnlyPolicy::class, 'grant_access']);
    }
}
