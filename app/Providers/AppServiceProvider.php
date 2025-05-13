<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\PermissionRegistrar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Explicitly register permission bindings for tests
        $this->app->singleton(PermissionRegistrar::class, function ($app) {
            return new PermissionRegistrar($app);
        });
        
        // Register middleware alias explicitly to avoid binding resolution issues in tests
        $this->app->bind('role', \Spatie\Permission\Middlewares\RoleMiddleware::class);
        $this->app->bind('permission', \Spatie\Permission\Middlewares\PermissionMiddleware::class);
        $this->app->bind('role_or_permission', \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Model::preventLazyLoading(!app()->isProduction());

        // Register all permission-related middleware for explicit resolution
        $router = $this->app['router'];
        $router->aliasMiddleware('role', \Spatie\Permission\Middlewares\RoleMiddleware::class);
        $router->aliasMiddleware('permission', \Spatie\Permission\Middlewares\PermissionMiddleware::class);
        $router->aliasMiddleware('role_or_permission', \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class);
    }
}
