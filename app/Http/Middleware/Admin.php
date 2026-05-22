<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->role_id == 5) {
            return $next($request);
        }
        return abort(403, 'Alleen administrators hebben toegang tot deze pagina!');
    }
}
