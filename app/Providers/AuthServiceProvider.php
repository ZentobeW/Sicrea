<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Portfolio;
use App\Models\Registration;
use App\Policies\EventPolicy;
use App\Policies\PortfolioPolicy;
use App\Policies\RegistrationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        Registration::class => RegistrationPolicy::class,
        Portfolio::class => PortfolioPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-admin', function ($user) {
            return $user->isAdmin();
        });
    }
}
