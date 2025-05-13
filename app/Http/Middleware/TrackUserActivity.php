<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Only update the timestamp if it's been more than 5 minutes since the last update
            // This reduces database writes for active users
            if (!$user->last_active_at || $user->last_active_at->diffInMinutes(Carbon::now()) >= 5) {
                $user->last_active_at = Carbon::now();
                $user->save();
            }
        }
        
        return $next($request);
    }
} 