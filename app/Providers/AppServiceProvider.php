<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

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
        Schema::defaultStringLength(191);

        Panel::configureUsing(function (Panel $panel) {
            $panel
                ->default()
                ->id('masa')
                ->path('masa')
                ->login()
                ->brandName('🦷 HEKİMPORT')
                ->colors([
                    'primary' => Color::hex('#00c8b3'),
                    'secondary' => Color::hex('#0099e5'),
                    'gray' => Color::Slate,
                ])
                ->font('Inter')
                ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
                ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
                ->middleware([
                    EncryptCookies::class,
                    AddQueuedCookiesToResponse::class,
                    StartSession::class,
                    AuthenticateSession::class,
                    ShareErrorsFromSession::class,
                    VerifyCsrfToken::class,
                    SubstituteBindings::class,
                ]);
        });
    }
}
