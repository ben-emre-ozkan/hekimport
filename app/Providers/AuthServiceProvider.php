<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword; // Import ResetPassword notification
use App\Models\User; // Import User model
use App\Models\Team;
use App\Policies\TeamPolicy;
use App\Models\ForumTopic;
use App\Policies\ForumTopicPolicy;
use App\Models\ForumMessage;
use App\Policies\ForumMessagePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        ForumTopic::class => ForumTopicPolicy::class,
        ForumMessage::class => ForumMessagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Customize the password reset URL
        // TODO: You may need to define a new default password reset URL if this was solely for Filament.
        // For now, we'll comment it out or you can provide a default Laravel one.
        /*
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            // Default Laravel password reset URL
            return url(route('password.reset', [
                'token' => $token,
                'email' => $user->getEmailForPasswordReset(),
            ], false));
        });
        */

        // You might have other Gate definitions here...
    }
} 