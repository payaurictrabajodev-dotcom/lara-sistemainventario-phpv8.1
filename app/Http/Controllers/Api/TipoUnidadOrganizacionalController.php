<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoUnidadOrganizacional;
use Illuminate\Http\Request;

class TipoUnidadOrganizacionalController extends Controller
{
    /**
     * Listar todos los tipos de unidad organizacional
     */
    public function index()
    {
        $tipos = TipoUnidadOrganizacional::all();

        return response()->json([
            'tipos_unidad' => $tipos,
        ]);
    }

    /**
     * Crear un nuevo tipo de unidad organizacional
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $tipo = TipoUnidadOrganizacional::create($request->all());

        return response()->json([
            'mensaje' => 'Tipo de unidad organizacional creado exitosamente',
            'tipo_unidad' => $tipo,
        ], 201);
    }

    /**
     * Mostrar un tipo de unidad específico
     */
    public function show($id)
    {
        $tipo = TipoUnidadOrganizacional::with('unidades')->findOrFail($id);

        return response()->json([
            'tipo_unidad' => $tipo,
        ]);
    }

    /**
     * Actualizar un tipo de unidad organizacional
     */
    public function update(Request $request, $id)
    {
        $tipo = TipoUnidadOrganizacional::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $tipo->update($request->all());

        return response()->json([
            'mensaje' => 'Tipo de unidad organizacional actualizado exitosamente',
            'tipo_unidad' => $tipo,
        ]);
    }

    /**
     * Eliminar un tipo de unidad organizacional
     */
    public function destroy($id)
    {
        $tipo = TipoUnidadOrganizacional::findOrFail($id);
        $tipo->delete();

        return response()->json([
            'mensaje' => 'Tipo de unidad organizacional eliminado exitosamente',
        ]);
    }
}
