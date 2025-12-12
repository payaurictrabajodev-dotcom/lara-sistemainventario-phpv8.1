<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Componente;
use Illuminate\Http\Request;

class ComponenteController extends Controller
{
    public function index()
    {
        $componentes = Componente::with(['unidadOrganizacional', 'tipoComponente'])->get();
        return response()->json(['componentes' => $componentes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo_patrimonial' => 'required|string|unique:componentes',
            'nombre' => 'required|string',
            'tipo_componente_id' => 'nullable|exists:tipos_componente,id',
            'marca' => 'nullable|string',
            'modelo' => 'nullable|string',
            'especificaciones' => 'nullable|string',
            'numero_serie' => 'nullable|string',
            'estado' => 'nullable|string',
            'unidad_organizacional_id' => 'nullable|exists:unidades_organizacionales,id',
            'responsable_id' => 'nullable|exists:responsables,id',
            'observaciones' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['usuario_id'] = auth()->id();

        $componente = Componente::create($data);

        return response()->json([
            'mensaje' => 'Componente creado exitosamente',
            'componente' => $componente->load(['unidadOrganizacional', 'tipoComponente']),
        ], 201);
    }

    public function show($id)
    {
        $componente = Componente::with(['unidadOrganizacional', 'equipos'])->findOrFail($id);
        return response()->json(['componente' => $componente]);
    }

    public function update(Request $request, $id)
    {
        $componente = Componente::findOrFail($id);

        $request->validate([
            'codigo_patrimonial' => 'required|string|unique:componentes,codigo_patrimonial,' . $id,
            'nombre' => 'required|string',
            'tipo_componente_id' => 'nullable|exists:tipos_componente,id',
            'marca' => 'nullable|string',
            'modelo' => 'nullable|string',
            'especificaciones' => 'nullable|string',
            'numero_serie' => 'nullable|string',
            'estado' => 'nullable|string',
            'unidad_organizacional_id' => 'nullable|exists:unidades_organizacionales,id',
            'responsable_id' => 'nullable|exists:responsables,id',
            'observaciones' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['usuario_id'] = auth()->id();

        $componente->update($data);

        return response()->json([
            'mensaje' => 'Componente actualizado exitosamente',
            'componente' => $componente->load(['unidadOrganizacional', 'tipoComponente']),
        ]);
    }

    public function destroy($id)
    {
        $componente = Componente::findOrFail($id);
        $componente->delete();

        return response()->json(['mensaje' => 'Componente eliminado exitosamente']);
    }
}
