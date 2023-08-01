<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->rol == 'administrador') {
            $pedidos = Pedidos::all();
            return response()->json($pedidos, 200);
        } else {
            return response()->json([
                'mensaje' => 'usuario no autorizado'
            ], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'usuario_id' => 'required|integer',
                'producto_id' => 'required|integer',
                'cantidad' => 'required|integer',
                'direccion' => 'required|string',
                'telefono' => 'integer'
            ]);

            if ($request->estadoHorario == 'aplazado') {
                Pedidos::create([
                    'usuario_id' => 'required|integer',
                    'producto_id' => 'required|integer',
                    'cantidad' => 'required|integer',
                    'direccion' => 'required|string',
                    'telefono' => 'integer',
                    'estado' => 3
                ]);

                return response()->json([
                    'mensaje' => 'Pedido realizado, pero aplazado hasta el siguiente día'
                ], 201);
            } else {
                Pedidos::create([
                    'usuario_id' => 'required|integer',
                    'producto_id' => 'required|integer',
                    'cantidad' => 'required|integer',
                    'direccion' => 'required|string',
                    'telefono' => 'integer',
                    'estado' => 2
                ]);

                return response()->json([
                    'mensaje' => 'Pedido realizado'
                ], 201);
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'usuario_id' => 'required|integer',
                'producto_id' => 'required|integer',
                'cantidad' => 'required|integer',
                'direccion' => 'required|string',
                'telefono' => 'integer'
            ]);

            Pedidos::where('id', '=', $id)->update($request->all());

            return response()->json([
                'mensaje' => 'Pedido actualizado con exito'
            ], 201);
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
        //
    }
}
