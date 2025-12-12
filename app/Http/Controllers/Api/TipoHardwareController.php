<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoHardware;
use Illuminate\Http\Request;

class TipoHardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TipoHardware::orderBy('nombre')->get();
        return response()->json($tipos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:tipos_hardware,nombre',
            'categoria' => 'nullable|string|max:255',
        ]);

        $tipo = TipoHardware::create($validated);

        return response()->json([
            'message' => 'Tipo de hardware creado exitosamente',
            'data' => $tipo
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tipo = TipoHardware::findOrFail($id);
        return response()->json($tipo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tipo = TipoHardware::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:tipos_hardware,nombre,' . $id,
            'categoria' => 'nullable|string|max:255',
        ]);

        $tipo->update($validated);

        return response()->json([
            'message' => 'Tipo de hardware actualizado exitosamente',
            'data' => $tipo
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tipo = TipoHardware::findOrFail($id);

        // Verificar si tiene hardware asociado
        if ($tipo->hardware()->count() > 0) {
            return response()->json([
                'message' => 'No se puede eliminar el tipo porque tiene hardware asociado'
            ], 422);
        }

        $tipo->delete();

        return response()->json([
            'message' => 'Tipo de hardware eliminado exitosamente'
        ]);
    }
}
