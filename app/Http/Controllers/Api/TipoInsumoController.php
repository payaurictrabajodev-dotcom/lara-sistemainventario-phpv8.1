<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoInsumo;
use Illuminate\Http\Request;

class TipoInsumoController extends Controller
{
    /**
     * Listar todos los tipos de insumo
     */
    public function index()
    {
        $tipos = TipoInsumo::all();

        return response()->json([
            'tipos_insumo' => $tipos,
        ]);
    }

    /**
     * Crear un nuevo tipo de insumo
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipo = TipoInsumo::create($request->all());

        return response()->json([
            'mensaje' => 'Tipo de insumo creado exitosamente',
            'tipo_insumo' => $tipo,
        ], 201);
    }

    /**
     * Mostrar un tipo de insumo específico
     */
    public function show($id)
    {
        $tipo = TipoInsumo::with('impresoras')->findOrFail($id);

        return response()->json([
            'tipo_insumo' => $tipo,
        ]);
    }

    /**
     * Actualizar un tipo de insumo
     */
    public function update(Request $request, $id)
    {
        $tipo = TipoInsumo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipo->update($request->all());

        return response()->json([
            'mensaje' => 'Tipo de insumo actualizado exitosamente',
            'tipo_insumo' => $tipo,
        ]);
    }

    /**
     * Eliminar un tipo de insumo
     */
    public function destroy($id)
    {
        $tipo = TipoInsumo::findOrFail($id);
        $tipo->delete();

        return response()->json([
            'mensaje' => 'Tipo de insumo eliminado exitosamente',
        ]);
    }
}
