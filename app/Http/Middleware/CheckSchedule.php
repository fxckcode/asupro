<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSchedule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        date_default_timezone_set('America/Bogota');
        $hora = date('G');
        $user = Auth::user();

        if ($user->rol == 'administrador') {
            return $next($request);
        }

        if ($user->rol == 'usuario' && $hora >= 7 && $hora <= 18) {
            return $next($request);
        }

        echo $hora;

        return response()->json([
            'error' => 'No puede iniciar sesión en este momento. Intente de nuevo entre las 7 AM y las 6 PM.',
            'hora' => $hora
        ], 403);
    }
}
