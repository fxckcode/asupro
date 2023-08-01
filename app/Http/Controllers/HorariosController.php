<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horarios;
use Illuminate\Support\Facades\Auth;

class HorariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $user = Auth::user();
        if ($user->rol == 'administrador') {
            $horarios = Horarios::all();
            return response()->json($horarios, 200);
        } else {
            return response()->json([
                'mensaje' => 'Usuario no autorizado'
            ], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            // Solo el administrador puede crear horarios
            if ($user->rol == 'administrador') {
                $request->validate([
                    'dia_inicio' => 'required|integer',
                    'dia_fin' => 'required|integer',
                    'hora_inicio' => 'required|date',
                    'hora_fin' => 'required|date',
                    'estado' => 'required|integer'
                ]);

                // Comprueba si ya existe un horario activo
                $horario_activo = Horarios::where('estado', 1)->first();

                // Si existe un horario activo, desactiva el estado del nuevo horario
                $estado = $horario_activo ? 2 : $request->estado;
    
                Horarios::create([
                    'dia_inicio' => $request->dia_inicio,
                    'dia_fin' => $request->dia_fin,
                    'hora_inicio' => $request->hora_inicio,
                    'hora_fin' => $request->hora_fin,
                    'estado' => $estado
                ]);
    
                return response()->json([
                    'message' => 'Horario creado con exito'
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Usuario no autorizado'
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al crear el horario',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        if ($user->rol == 'administrador') {
            $horarios = Horarios::where('id', '=', $id)->first();
            return response()->json($horarios, 200);
        } else {
            return response()->json([
                'message' => 'Usuario no autorizado'
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = Auth::user();
            if ($user->rol == 'administrador') {
                $request->validate([
                    'dia_inicio' => 'required|integer',
                    'dia_fin' => 'required|integer',
                    'hora_inicio' => 'required|date',
                    'hora_fin' => 'required|date',
                    'estado' => 'required|integer'
                ]);
                
                // Si el estado del horario a actualizar es activo
                if ($request->estado == 1) {
                    // Desactiva todos los otros horarios activos
                    Horarios::where('estado', 1)->update(['estado' => 0]);
                }
    
                Horarios::where('id', '=', $id)->update($request->all());
    
                return response()->json([
                    'message' => 'Horario actualizado con exito'
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Usuario no autorizado'
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al crear el horario',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        if ($user->rol == 'administrador') {
            Horarios::where('id', '=', $id)->delete();
            return response()->json([
                'message' => 'Horario eliminado con exito'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Usuario no autorizado'
            ], 401);
        }
    }
}
