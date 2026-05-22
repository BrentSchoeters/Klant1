<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Trainer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2 || auth()->user()->role_id == 5) {
            return $next($request);
        }
        return abort(403, 'Alleen trainers hebben toegang tot deze pagina!');
    }
}
