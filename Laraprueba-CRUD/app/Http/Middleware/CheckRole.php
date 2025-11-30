<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        // Check role
        switch ($role) {
            case 'administrador':
                if (!$user->isAdministrador()) {
                    abort(403, 'Acceso denegado. Solo administradores pueden acceder a esta sección.');
                }
                break;

            case 'voluntario':
                if (!$user->isVoluntario() && !$user->isAdministrador()) {
                    abort(403, 'Acceso denegado.');
                }
                break;

            default:
                abort(403, 'Rol no válido.');
        }

        return $next($request);
    }
}
