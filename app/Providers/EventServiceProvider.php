// app/Providers/EventServiceProvider.php

protected $observers = [
    \App\Models\Organization::class   => [\App\Observers\OrganizationObserver::class],
    \App\Models\UserContact::class    => [\App\Observers\UserContactObserver::class],
    \App\Models\User::class           => [\App\Observers\UserObserver::class],
];
