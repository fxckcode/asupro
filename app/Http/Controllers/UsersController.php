<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->rol == 'administrador') {
            $users = User::all();
            return response()->json($users, 200);
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
            $request->validate([
                'nombre' => 'required|string',
                'email' => 'required|string',
                'password' => 'required|string',
                'direccion' => 'string',
                'codigo_postal' => 'integer',
                'barrio' => 'string',
                'municipio' => 'string',
                'telefono' => 'integer',
                'rol' => 'integer'
            ]);
        
            $user = Auth::user();

            if ($user->rol == 'administrador') {
                User::create([
                    'nombre' => $request->nombre,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'direccion' => $request->direccion,
                    'codigo_postal' => $request->codigo_postal,
                    'barrio' => $request->barrio,
                    'municipio' => $request->municipio,
                    'telefono' => $request->telefono,
                    'rol' => $request->rol ?? 1
                ]);
    
                return response()->json([
                    'mensaje' => 'usuario creado con exito'
                ], 201);
            } else {
                return response()->json([
                    'mensaje' => 'Usuario no autorizado'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Ah ocurrido un error al crear el usuario',
                $e
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', '=', $id)->first();
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'nombre' => 'string',
                'email' => 'email|unique:users,email',
                'direccion' => 'string',
                'codigo_postal' => 'integer',
                'barrio' => 'string',
                'municipio' => 'string',
                'telefono' => 'integer',
                'rol' => 'integer'
            ]);

            User::where('id', '=', $id)->update($request->all());

            return response()->json([
                'mensaje' => 'usuario actualizado con exito'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ah ocurrido un error al actualizar el usuario'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Auth::user();

            if ($user->rol == 'administrador') {
                User::where('id', '=', $id)->delete();
                return response()->json([
                    'mensaje' => 'Producto eliminado con exito'
                ], 200);
            } else {
                return response()->json([
                    'mensaje' => 'Usuario no autorizado'
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Ah ocurrido un error al eliminar el usuario'
            ]);
        }
    }
}
