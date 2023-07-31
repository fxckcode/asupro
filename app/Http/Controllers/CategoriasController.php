<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categorias::all();
        return response()->json($categorias, 200);
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
                Categorias::create([
                    'nombre' => $request->nombre
                ]);

                return response()->json([
                    'mensaje' => 'Categoria creada con exito'
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
        $categoria = Categorias::where('id', '=', $id)->first();
        return response()->json($categoria, 200);
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
                $categoria = Categorias::where('id', '=', $id)->get();
                $categoria->nombre = $request->nombre;
                $categoria->save();

                return response()->json([
                    $categoria
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
            Categorias::where('id', '=', $id)->delete();
            return response()->json([
                'mensaje' => 'Categoria eliminada con exito'
            ], 200);
        } else {
            return response()->json([
                'mensaje' => 'Usuario no autorizado'
            ]);
        }
    }
}
