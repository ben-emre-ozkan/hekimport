<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request; // <-- Ensure this import exists

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Default fallback for any other unauthenticated web requests
            return route('login'); 
        }
        return null; // Return null for JSON requests
    }
} 