<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserActivity
{
    public function handle($request, Closure $next)
    {
        if(Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(5);
            Cache::put('user-online-' . Auth::id(), true, $expiresAt);
        }
        return $next($request);
    }
}