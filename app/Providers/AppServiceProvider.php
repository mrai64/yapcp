<?php

/**
 * 2025-10-11 Add first gates 'contest-participants-update'
 * 2025-11-26 Add 'juror-only' gate
 * 2026-01-29 Add 'version' in footer
 */

namespace App\Providers;

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\FederationSection;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserContact;
use App\Observers\FederationObserver;
use App\Observers\OrganizationObserver;
use App\Observers\UserContactObserver;
use App\Observers\UserObserver;
use App\Policies\ContestPaymentChangePolicy;
use App\Policies\JurorOnlyPolicy;
use BinaryTorch\LaRecipe\LaRecipeServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
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
                $registered = json_decode(Storage::disk('local')->get('version.json'), true);
                $version = $registered['full'] ?? '0.0.0';
            }

            $view->with('appVersion', $version);
        });

        // impostazione rate limit - dovrebbe essere anche nel RouteServiceProvider
        RateLimiter::for('welcome-page', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });

        // Forza il binding esplicito per le rotte che usano {organization}
        Route::model('federation', Federation::class);
        Route::model('federation-more', FederationMore::class);
        Route::model('federation-section', FederationSection::class);
        Route::model('organization', Organization::class);

        // Registrazione esplicita della Policy
        Gate::policy(Federation::class, \App\Policies\FederationPolicy::class);
        Gate::policy(FederationMore::class, \App\Policies\FederationMorePolicy::class);
        Gate::policy(FederationSection::class, \App\Policies\FederationSectionPolicy::class);
        Gate::policy(Organization::class, \App\Policies\OrganizationPolicy::class);

        // Gate Policy
        Gate::define('contest-participants-update', [ContestPaymentChangePolicy::class, 'update']);
        Gate::define('jury-panels', [JurorOnlyPolicy::class, 'grantAccess']);
        Gate::define('larecipe-dev-access', [LaRecipeServiceProvider::class, 'gate']);
        Gate::define('access-admin', function (User $user) {
            return $user->isAdmin();
        });
        Gate::define('access-juror', function (User $user) {
            return $user->isJurorInAnyContest();
        });
        Gate::define('access-organization', function (User $user) {
            return $user->isMemberOfAnyOrganization();
        });

        // Observers
        User::observe(UserObserver::class);
        UserContact::observe(UserContactObserver::class);
        Organization::observe(OrganizationObserver::class);
        Federation::observe(FederationObserver::class);
    }
}
