<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoEquipo;
use Illuminate\Http\Request;

class TipoEquipoController extends Controller
{
    /**
     * Listar todos los tipos de equipo
     */
    public function index()
    {
        $tipos = TipoEquipo::all();

        return response()->json([
            'tipos_equipo' => $tipos,
        ]);
    }

    /**
     * Crear un nuevo tipo de equipo
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $tipo = TipoEquipo::create($request->all());

        return response()->json([
            'mensaje' => 'Tipo de equipo creado exitosamente',
            'tipo_equipo' => $tipo,
        ], 201);
    }

    /**
     * Mostrar un tipo de equipo específico
     */
    public function show($id)
    {
        $tipo = TipoEquipo::with('equipos')->findOrFail($id);

        return response()->json([
            'tipo_equipo' => $tipo,
        ]);
    }

    /**
     * Actualizar un tipo de equipo
     */
    public function update(Request $request, $id)
    {
        $tipo = TipoEquipo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $tipo->update($request->all());

        return response()->json([
            'mensaje' => 'Tipo de equipo actualizado exitosamente',
            'tipo_equipo' => $tipo,
        ]);
    }

    /**
     * Eliminar un tipo de equipo
     */
    public function destroy($id)
    {
        $tipo = TipoEquipo::findOrFail($id);
        $tipo->delete();

        return response()->json([
            'mensaje' => 'Tipo de equipo eliminado exitosamente',
        ]);
    }
}
