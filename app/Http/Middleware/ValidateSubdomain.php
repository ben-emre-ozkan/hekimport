<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSubdomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $subdomain = explode('.', $request->getHost())[0];
        
        // Check if subdomain is valid
        if (!preg_match('/^[a-zA-Z0-9]{3,50}$/', $subdomain)) {
            abort(404);
        }
        
        // Check if subdomain is not reserved
        $reserved = ['admin', 'app', 'www'];
        if (in_array($subdomain, $reserved)) {
            abort(404);
        }
        
        return $next($request);
    }
} 