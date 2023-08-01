<?php

namespace App\Http\Middleware;

use App\Models\Horarios;
use Carbon\Carbon;
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
        $horario = Horarios::where('estado', 1)->first();

        $horaInicioFormat = Carbon::createFromFormat('H:i:s', $horario->hora_inicio);
        $horaFinFormat = Carbon::createFromFormat('H:i:s', $horario->hora_fin);
        $horaInicio = $horaInicioFormat->format('G');
        $horaFin = $horaFinFormat->format('G');
        $diaInicio = $horario->dia_inicio;
        $diaFin = $horario->dia_fin;

        $fechaActual = Carbon::now();
        $numeroDiaFormat = $fechaActual->dayOfWeek;

        if ($user->rol == 'administrador') {
            return $next($request);
        }

        if ($user->rol == 'usuario' && $hora >= $horaInicio && $hora <= $horaFin && $numeroDiaFormat >= $diaInicio && $numeroDiaFormat <= $diaFin ) {
            return $next($request);
        } else {
            $request->merge(['estadoHorario' => 'aplazado']);
            return $next($request);
        }
    }
}
