<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Check if locale is set in session
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        } else {
            // Default to English
            app()->setLocale('en');
        }

        return $next($request);
    }
}
