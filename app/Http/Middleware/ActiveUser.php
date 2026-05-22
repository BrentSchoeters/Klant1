<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->active == 1) {
            return $next($request);
        }
        // logout the user from the web guard
        auth('web')->logout();
        // abort the request with a message
        return abort(403, 'Uw account is niet actief. Neem contact op met de administrator.');
    }
}
