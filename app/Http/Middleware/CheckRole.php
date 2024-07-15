<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    // El método handle procesa una solicitud HTTP entrante.
    public function handle($request, Closure $next, ...$roles)
    {
        // Verifica si hay un usuario actualmente autenticado. Si no hay usuario autenticado, redirecciona a la página de login.
        if (!Auth::check()) {
            return redirect('login');
        }

        // Itera sobre cada uno de los roles proporcionados como argumentos al middleware.
        foreach ($roles as $role) {
            // Verifica si el usuario de la solicitud actual tiene el rol actual en la iteración.
            if ($request->user()->hasRole($role)) {
                // Si el usuario tiene el rol, permite que la solicitud continúe al próximo middleware o controlador.
                return $next($request);
            }
        }

        // Si ninguno de los roles coincide, aborta la solicitud con un código de estado HTTP 403 (Prohibido).
        abort(403);
    }
}