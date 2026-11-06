<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRol
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$rolesPermitidos): Response
    {
        $user = $request->user();
        $rolUser = $user->rol?->tipo_rol;


        if(!in_array($rolUser, $rolesPermitidos, true)){
            abort(403, 'No tienes permiso para acceder a esta sección');
        }
        return $next($request);
    }
}
