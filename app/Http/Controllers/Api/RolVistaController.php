<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\VistaSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolVistaController extends Controller
{
    /**
     * Obtener todas las vistas del sistema
     */
    public function todasLasVistas()
    {
        $vistas = VistaSistema::with('children')
            ->whereNull('parent_id')
            ->orderBy('orden')
            ->get();

        return response()->json([
            'vistas' => $vistas
        ]);
    }

    /**
     * Obtener vistas asignadas a un rol específico
     */
    public function vistasDelRol($rolId)
    {
        $rol = Rol::with('vistas')->findOrFail($rolId);

        return response()->json([
            'rol' => $rol,
            'vistas' => $rol->vistas
        ]);
    }

    /**
     * Asignar/Actualizar vistas de un rol
     */
    public function asignarVistas(Request $request, $rolId)
    {
        $validator = Validator::make($request->all(), [
            'vistas' => 'required|array',
            'vistas.*' => 'exists:vistas_sistema,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Datos inválidos',
                'detalles' => $validator->errors()
            ], 422);
        }

        $rol = Rol::findOrFail($rolId);

        // Sincronizar vistas (elimina las que no están y agrega las nuevas)
        $rol->vistas()->sync($request->vistas);

        return response()->json([
            'mensaje' => 'Vistas asignadas correctamente',
            'rol' => $rol->load('vistas')
        ]);
    }

    /**
     * Obtener vistas permitidas para el usuario actual
     */
    public function vistasPermitidas()
    {
        $user = auth()->user();

        if (!$user || !$user->role_id) {
            return response()->json([
                'vistas' => []
            ]);
        }

        $rol = Rol::with(['vistas' => function($query) {
            $query->with('children')->whereNull('parent_id')->orderBy('orden');
        }])->find($user->role_id);

        if (!$rol) {
            return response()->json([
                'vistas' => []
            ]);
        }

        return response()->json([
            'vistas' => $rol->vistas
        ]);
    }
}
