<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
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
        // Ensure the user is authenticated and has verified their email
        if (!$request->user() || !$request->user()->hasVerifiedEmail()) {
            // If not, redirect to the email verification notice route
            return redirect()->route('verification.notice');
        }

        // Otherwise, proceed with the request
        return $next($request);
    }
}
