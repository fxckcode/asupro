<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $request) {
        try {
            $request->validate([
                'nombre' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string'
            ]);

            $user = User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'rol' => 1
            ]);

            $token = $user->createToken('token')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response()->json($response, 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'invalid login',
                'error' => $e
            ]);
        }
    }

    public function login(Request $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'mensaje' => 'inicio de sesión invalido'
            ], 400);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 200);
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'logout success'
        ], 200);
    }
}
