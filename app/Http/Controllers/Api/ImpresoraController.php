<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Impresora;
use Illuminate\Http\Request;

class ImpresoraController extends Controller
{
    /**
     * Listar todas las impresoras
     */
    public function index()
    {
        $impresoras = Impresora::with(['unidadOrganizacional', 'tipoImpresora', 'tipoInsumo', 'usuario', 'responsable'])->get();

        return response()->json([
            'impresoras' => $impresoras,
        ]);
    }

    /**
     * Crear una nueva impresora
     */
    public function store(Request $request)
    {
        $request->validate([
            'unidad_organizacional_id' => 'nullable|exists:unidades_organizacionales,id',
            'codigo_patrimonial' => 'nullable|string|unique:impresoras',
            'tipo_impresora_id' => 'required|exists:tipos_impresora,id',
            'tipo_insumo_id' => 'nullable|exists:tipos_insumo,id',
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'numero_serie' => 'required|string',
            'direccion_ip' => 'nullable|string',
            'estado' => 'nullable|string',
            'responsable_id' => 'nullable|exists:responsables,id',
            'observaciones' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['usuario_id'] = auth()->id();

        $impresora = Impresora::create($data);

        return response()->json([
            'mensaje' => 'Impresora creada exitosamente',
            'impresora' => $impresora->load(['unidadOrganizacional', 'tipoImpresora', 'tipoInsumo', 'usuario', 'responsable']),
        ], 201);
    }

    /**
     * Mostrar una impresora específica
     */
    public function show($id)
    {
        $impresora = Impresora::with(['unidadOrganizacional', 'tipoImpresora', 'tipoInsumo', 'usuario', 'responsable'])->findOrFail($id);

        return response()->json([
            'impresora' => $impresora,
        ]);
    }

    /**
     * Actualizar una impresora
     */
    public function update(Request $request, $id)
    {
        $impresora = Impresora::findOrFail($id);

        $request->validate([
            'unidad_organizacional_id' => 'nullable|exists:unidades_organizacionales,id',
            'codigo_patrimonial' => 'nullable|string|unique:impresoras,codigo_patrimonial,' . $id,
            'tipo_impresora_id' => 'required|exists:tipos_impresora,id',
            'tipo_insumo_id' => 'nullable|exists:tipos_insumo,id',
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'numero_serie' => 'required|string',
            'direccion_ip' => 'nullable|string',
            'estado' => 'nullable|string',
            'responsable_id' => 'nullable|exists:responsables,id',
            'observaciones' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['usuario_id'] = auth()->id();

        $impresora->update($data);

        return response()->json([
            'mensaje' => 'Impresora actualizada exitosamente',
            'impresora' => $impresora->load(['unidadOrganizacional', 'tipoImpresora', 'tipoInsumo', 'usuario', 'responsable']),
        ]);
    }

    /**
     * Eliminar una impresora
     */
    public function destroy($id)
    {
        $impresora = Impresora::findOrFail($id);
        $impresora->delete();

        return response()->json([
            'mensaje' => 'Impresora eliminada exitosamente',
        ]);
    }
}
