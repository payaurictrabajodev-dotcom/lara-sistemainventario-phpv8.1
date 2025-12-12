<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Listar todos los roles
     */
    public function index()
    {
        $roles = Rol::all();

        return response()->json([
            'roles' => $roles,
        ]);
    }

    /**
     * Crear un nuevo rol
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles',
        ]);

        $rol = Rol::create($request->only(['nombre']));

        return response()->json([
            'mensaje' => 'Rol creado exitosamente',
            'rol' => $rol,
        ], 201);
    }

    /**
     * Mostrar un rol específico
     */
    public function show($id)
    {
        $rol = Rol::with('usuarios')->findOrFail($id);

        return response()->json([
            'rol' => $rol,
        ]);
    }

    /**
     * Actualizar un rol
     */
    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $id,
        ]);

        $rol->update($request->only(['nombre']));

        return response()->json([
            'mensaje' => 'Rol actualizado exitosamente',
            'rol' => $rol,
        ]);
    }

    /**
     * Eliminar un rol
     */
    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return response()->json([
            'mensaje' => 'Rol eliminado exitosamente',
        ]);
    }
}
