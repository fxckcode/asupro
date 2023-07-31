<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Productos::join('unidad_medida as um', 'um.id', '=', 'productos.unidad_medida_id')
                                ->join('categorias as c', 'c.id', '=', 'productos.categoria_id')
                                ->select('productos.*', 'um.nombre as unidad_medida_id', 'c.nombre as categoria_id')
                                ->get();
        return response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string',
                'marca' => 'string',
                'precio' => 'required|integer',
                'unidad_medida_id' => 'required|integer',
                'categoria_id' => 'required|integer',
                'stock' => 'integer'
            ]);

            $user = Auth::user();

            if ($user->rol == 'administrador') {
                Productos::create([
                    'nombre' => $request->nombre,
                    'marca' => $request->marca,
                    'precio' => $request->precio,
                    'unidad_medida_id' => $request->unidad_medida_id,
                    'categoria_id' => $request->categoria_id,
                    'stock' => $request->stock
                ]);

                return response()->json([
                    'mensaje' => 'Producto creado con exito'
                ], 201);
            } else {
                return response()->json([
                    'mensaje' => 'Usuario no autorizado'
                ], 401);
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
        $producto = Productos::join('unidad_medida as um', 'um.id', '=', 'productos.unidad_medida_id')
        ->join('categorias as c', 'c.id', '=', 'productos.categoria_id')
        ->select('productos.*', 'um.nombre as unidad_medida_id', 'c.nombre as categoria_id')
        ->where('productos.id', '=', $id)->first();
        return response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'nombre' => 'required|string',
                'marca' => 'string',
                'precio' => 'required|integer',
                'unidad_medida_id' => 'required|integer',
                'categoria_id' => 'required|integer',
                'stock' => 'integer'
            ]);

            $user = Auth::user();

            if ($user->rol == 'administrador') {
                Productos::update($request->all());

                return response()->json([
                    'mensaje' => 'Producto actualizado con exito'
                ], 201);
            } else {
                return response()->json([
                    'mensaje' => 'Usuario no autorizado'
                ], 401);
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
            Productos::where('id', '=', $id)->delete();
            return response()->json([
                'mensaje' => 'Producto eliminado con exito'
            ], 200);
        } else {
            return response()->json([
                'mensaje' => 'Usuario no autorizado'
            ]);
        }
    }

    public function getProductsByCategorie(string $id) {
        $productos = Productos::join('unidad_medida as um', 'um.id', '=', 'productos.unidad_medida_id')
        ->join('categorias as c', 'c.id', '=', 'productos.categoria_id')
        ->select('productos.*', 'um.nombre as unidad_medida_id', 'c.nombre as categoria_id')
        ->where('productos.categoria_id', '=', $id)->get();
        return response()->json($productos, 200);
    } 

    public function getProductsByUnidadMedida(string $id) {
        $productos = Productos::join('unidad_medida as um', 'um.id', '=', 'productos.unidad_medida_id')
        ->join('categorias as c', 'c.id', '=', 'productos.categoria_id')
        ->select('productos.*', 'um.nombre as unidad_medida_id', 'c.nombre as categoria_id')
        ->where('productos.unidad_medida_id', '=', $id)->get();
        return response()->json($productos, 200);
    }
}
