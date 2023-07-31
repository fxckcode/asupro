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
        if ($user->rol == 'administrador' || $user->rol == 'usuario') {
            $horarios = Horarios::all();
            return response()->json($horarios, 200);
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
                    'usuario_id' => 'required|integer',
                    'dia_semana' => 'required|integer',
                    'hora_inicio' => 'required|date',
                    'hora_fin' => 'required|date'
                ]);
    
                Horarios::create([
                    'usuario_id' => $request->usuario_id,
                    'dia_semana' => $request->dia_semana,
                    'hora_inicio' => $request->hora_inicio,
                    'hora_fin' => $request->hora_fin
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
                $th
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
