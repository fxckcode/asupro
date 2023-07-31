<?php

namespace App\Http\Controllers;

use App\Models\UnidadMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnidadMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unidades_medida = UnidadMedida::all();
        return response()->json($unidades_medida, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string'
            ]);

            $user = Auth::user();

            if ($user->rol == 'administrador') {
                UnidadMedida::create([
                    'nombre' => $request->nombre
                ]);

                return response()->json([
                    'mensaje' => 'unidad de medida creada con exito'
                ], 201);
            } else {
                return response()->json([
                    'mensaje' => 'Usuario no autorizado'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Se ha presentado un error'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unidadad_medida = UnidadMedida::where('id', '=', $id)->first();
        return response()->json($unidadad_medida, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'nombre' => 'required|string'
            ]);

            $user = Auth::user();

            if ($user->rol == 'administrador') {
                $unidadad_medida = UnidadMedida::where('id', '=', $id)->get();
                $unidadad_medida->nombre = $request->nombre;
                $unidadad_medida->save();

                return response()->json([
                    $unidadad_medida
                ], 201);
            } else {
                return response()->json([
                    'mensaje' => 'Usuario no autorizado'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Se ha presentado un error'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        if ($user->rol == 'administrador') {
            UnidadMedida::where('id', '=', $id)->delete();
            return response()->json([
                'mensaje' => 'Unidad de medida eliminada con exito'
            ], 200);
        } else {
            return response()->json([
                'mensaje' => 'Usuario no autorizado'
            ]);
        }
    }
}
