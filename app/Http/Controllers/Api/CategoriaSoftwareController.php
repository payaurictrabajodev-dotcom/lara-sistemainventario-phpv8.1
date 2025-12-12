<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoriaSoftware;
use Illuminate\Http\Request;

class CategoriaSoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = CategoriaSoftware::orderBy('nombre')->get();
        return response()->json($categorias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias_software,nombre',
            'descripcion' => 'nullable|string',
        ]);

        $categoria = CategoriaSoftware::create($validated);

        return response()->json([
            'message' => 'Categoría de software creada exitosamente',
            'data' => $categoria
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = CategoriaSoftware::findOrFail($id);
        return response()->json($categoria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria = CategoriaSoftware::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias_software,nombre,' . $id,
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($validated);

        return response()->json([
            'message' => 'Categoría de software actualizada exitosamente',
            'data' => $categoria
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = CategoriaSoftware::findOrFail($id);

        // Verificar si tiene software asociado
        if ($categoria->software()->count() > 0) {
            return response()->json([
                'message' => 'No se puede eliminar la categoría porque tiene software asociado'
            ], 422);
        }

        $categoria->delete();

        return response()->json([
            'message' => 'Categoría de software eliminada exitosamente'
        ]);
    }
}
