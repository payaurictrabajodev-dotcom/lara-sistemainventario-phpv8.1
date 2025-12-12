<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoImpresora;
use Illuminate\Http\Request;

class TipoImpresoraController extends Controller
{
    /**
     * Listar todos los tipos de impresora
     */
    public function index()
    {
        $tipos = TipoImpresora::all();

        return response()->json([
            'tipos_impresora' => $tipos,
        ]);
    }

    /**
     * Crear un nuevo tipo de impresora
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipo = TipoImpresora::create($request->all());

        return response()->json([
            'mensaje' => 'Tipo de impresora creado exitosamente',
            'tipo_impresora' => $tipo,
        ], 201);
    }

    /**
     * Mostrar un tipo de impresora específico
     */
    public function show($id)
    {
        $tipo = TipoImpresora::with('impresoras')->findOrFail($id);

        return response()->json([
            'tipo_impresora' => $tipo,
        ]);
    }

    /**
     * Actualizar un tipo de impresora
     */
    public function update(Request $request, $id)
    {
        $tipo = TipoImpresora::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $tipo->update($request->all());

        return response()->json([
            'mensaje' => 'Tipo de impresora actualizado exitosamente',
            'tipo_impresora' => $tipo,
        ]);
    }

    /**
     * Eliminar un tipo de impresora
     */
    public function destroy($id)
    {
        $tipo = TipoImpresora::findOrFail($id);
        $tipo->delete();

        return response()->json([
            'mensaje' => 'Tipo de impresora eliminado exitosamente',
        ]);
    }
}
