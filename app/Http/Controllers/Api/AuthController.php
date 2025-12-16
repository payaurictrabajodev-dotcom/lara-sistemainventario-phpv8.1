<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registro de nuevo usuario
     */
    public function registrar(Request $request)
    {
        $passwordRules = ['required', 'string', 'min:8'];
        if ($request->has('password_confirmation')) {
            $passwordRules[] = 'confirmed';
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => $passwordRules,
            'role_id' => 'nullable|exists:roles,id',
            'rol' => 'nullable', // compatibilidad hacia atrás
            'es_administrador' => 'nullable|boolean',
        ]);

        if ($request->filled('role_id')) {
            $roleId = (int) $request->input('role_id');
        } else {
            $roleId = DB::table('roles')->where('nombre', 'usuario')->value('id');
        }

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId,
            'es_administrador' => $request->es_administrador ?? false,
        ]);

        return response()->json([
            'mensaje' => 'Usuario registrado exitosamente',
            'usuario' => $usuario,
        ], 201);
    }

    /**
     * Login de usuario existente
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $usuario = User::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        $token = $usuario->createToken('auth_token')->plainTextToken;
        Log::info('Login exitoso para el usuario', ['email' => $request->email]);
        return response()->json([
            'mensaje' => 'Login exitoso',
            'usuario' => $usuario,
            'token' => $token,
            'tipo_token' => 'Bearer',
        ]);
    }

    /**
     * Logout (revoca el token actual)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'mensaje' => 'Sesión cerrada exitosamente',
        ]);
    }

    /**
     * Obtener usuario autenticado
     */
    public function usuarioActual(Request $request)
    {
        return response()->json([
            'usuario' => $request->user()->load('role'),
        ]);
    }
}
