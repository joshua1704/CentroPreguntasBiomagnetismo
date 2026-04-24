<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('admin_login') || $request->routeIs('admin_logout')) {
            return $next ($request);
        }
        
        if(auth()->check() && auth()->user()->must_change_password && !$request->is('change_password')) {
            return redirect()->route('admin_change_password');
        }
        return $next($request);
    }
}
