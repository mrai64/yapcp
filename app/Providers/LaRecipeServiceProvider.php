/**
 * Register the LaRecipe gate.
 *
 * This gate determines who can access LaRecipe in non-local environments.
 *
 * @return void
 */
protected function gate()
{
    Gate::define('viewLaRecipe', function ($user = null) {
        // 1. local dev - even
        if (app()->environment('local')) {
            return true;
        }
        // 2. not /docs/dev/ - even
        if (! request()->is('docs/dev*')) {
            return true;
        }

        // 3. /docs/dev* out of local - only RSVP
        return $user && in_array($user->email, [
            'massimo.rainato@athesis77.it',
        ]);
    });
}