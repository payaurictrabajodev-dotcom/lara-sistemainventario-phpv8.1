<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listar todos los usuarios
     */
    public function index()
    {
        $usuarios = User::with('role')->get();

        return response()->json([
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Crear un nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'nullable|exists:roles,id',
            'es_administrador' => 'nullable|boolean',
        ]);

        $roleId = $request->input('role_id') ?? \Illuminate\Support\Facades\DB::table('roles')->where('nombre', 'usuario')->value('id');

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId,
            'es_administrador' => $request->es_administrador ?? false,
        ]);

        return response()->json([
            'mensaje' => 'Usuario creado exitosamente',
            'usuario' => $usuario,
        ], 201);
    }

    /**
     * Mostrar un usuario específico
     */
    public function show($id)
    {
        $usuario = User::findOrFail($id);

        return response()->json([
            'usuario' => $usuario,
        ]);
    }

    /**
     * Actualizar un usuario
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);


        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'nullable|exists:roles,id',
            'es_administrador' => 'nullable|boolean',
        ]);

        $datos = $request->only(['name', 'email', 'role_id', 'es_administrador']);

        if ($request->filled('password')) {
            $datos['password'] = Hash::make($request->password);
        }

        $usuario->update($datos);

        return response()->json([
            'mensaje' => 'Usuario actualizado exitosamente',
            'usuario' => $usuario,
        ]);
    }

    /**
     * Eliminar un usuario
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return response()->json([
            'mensaje' => 'Usuario eliminado exitosamente',
        ]);
    }

    /**
     * Listar usuarios por rol
     */
    public function porRol($rol)
    {
        $usuarios = User::where('role_id', $rol)->get();

        return response()->json([
            'role_id' => $rol,
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Listar administradores
     */
    public function administradores()
    {
        $usuarios = User::where('es_administrador', true)->get();

        return response()->json([
            'administradores' => $usuarios,
        ]);
    }

    /**
     * Cambiar contraseña del usuario
     */
    public function cambiarContrasena(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'password_actual' => 'required|string',
            'password_nuevo' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->password_actual, $usuario->password)) {
            return response()->json([
                'mensaje' => 'La contraseña actual es incorrecta',
            ], 422);
        }

        $usuario->update([
            'password' => Hash::make($request->password_nuevo),
        ]);

        return response()->json([
            'mensaje' => 'Contraseña actualizada exitosamente',
        ]);
    }
}
