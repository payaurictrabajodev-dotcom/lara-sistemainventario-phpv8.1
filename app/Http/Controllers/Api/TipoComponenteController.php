<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoComponente;
use Illuminate\Http\Request;

class TipoComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TipoComponente::all();
        return response()->json(['tipos_componente' => $tipos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $tipo = TipoComponente::create($request->all());

        return response()->json([
            'mensaje' => 'Tipo de componente creado exitosamente',
            'tipo_componente' => $tipo,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tipo = TipoComponente::findOrFail($id);
        return response()->json(['tipo_componente' => $tipo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tipo = TipoComponente::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $tipo->update($request->all());

        return response()->json([
            'mensaje' => 'Tipo de componente actualizado exitosamente',
            'tipo_componente' => $tipo,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tipo = TipoComponente::findOrFail($id);
        $tipo->delete();

        return response()->json(['mensaje' => 'Tipo de componente eliminado exitosamente']);
    }
}
