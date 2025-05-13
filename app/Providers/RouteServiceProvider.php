<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/masam'; // Adjusted to match our desired home

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            
            // Ensure Fortify routes load if not handled automatically
            // This might not be strictly necessary if FortifyServiceProvider handles it
            // but can help if routes aren't resolving.
            // Consider if routes/auth.php exists or if Fortify::routes() should be called elsewhere
            // if ($this->app->routesAreCached() === false) {
            //     // Potentially load Fortify routes here if needed
            // }
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
        
        // Configure login rate limiting (matches config/fortify.php)
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email') . '|' . $request->ip());
        });

        // Configure two-factor rate limiting (matches config/fortify.php)
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email') . '|' . $request->ip());
        });
    }
} 