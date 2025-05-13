<?php

namespace App\Http\Middleware;

use App\Models\Vitrin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class ResolveSubdomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $subdomain = $request->route('slug');

        // Check if subdomain is reserved
        if ($this->isReservedSubdomain($subdomain)) {
            return redirect()->route('home');
        }

        // Try to get vitrin from Redis cache first
        $vitrin = Redis::get("vitrin:{$subdomain}");
        
        if (!$vitrin) {
            $vitrin = Vitrin::where('subdomain', $subdomain)
                ->where('is_active', true)
                ->first();
                
            if ($vitrin) {
                // Cache in Redis for 1 hour
                Redis::setex("vitrin:{$subdomain}", 3600, serialize($vitrin));
            }
        } else {
            $vitrin = unserialize($vitrin);
        }

        if (!$vitrin) {
            return response()->view('errors.404', [], 404);
        }

        // Add vitrin to request
        $request->merge(['vitrin' => $vitrin]);

        return $next($request);
    }

    protected function isReservedSubdomain(string $subdomain): bool
    {
        $reserved = [
            'www',
            'app',
            'admin',
            'api',
            'mail',
            'ftp',
            'smtp',
            'pop',
            'imap',
            'test',
            'dev',
            'staging',
            'prod',
            'beta',
            'alpha',
        ];

        return in_array($subdomain, $reserved);
    }
} 