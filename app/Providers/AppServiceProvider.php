<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\RateLimiter as FacadesRateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

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
        
        Gate::before(function (User $user) {
            if ($user->hasRole('Admin')) {
                return true;
            }
        });

        
        Gate::define('upload-bom', function (User $user) {
            return $user->hasRole('Store Manager');
        });

        Gate::define('view-inventory', function (User $user) {
            return $user->hasAnyRole(['Engineer', 'Purchase Dept', 'Store Manager']);
        });

        Gate::define('view-bom', function (User $user) {
            return $user->hasAnyRole(['Engineer', 'Purchase Dept', 'Store Manager']);
        });

        Gate::define('manage-purchase-intents', function (User $user) {
            return $user->hasRole('Purchase Dept');
        });

        Gate::define('view-allocations', function (User $user) {
            return $user->hasAnyRole(['Engineer', 'Purchase Dept']);
        });


     
        FacadesRateLimiter::for('email-outbound', function (object $job) {
            return Limit::perSecond(3);
        });
    }
}
