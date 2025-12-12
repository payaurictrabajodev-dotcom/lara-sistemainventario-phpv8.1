<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Software;
use Illuminate\Http\Request;

class SoftwareController extends Controller
{
    /**
     * Listar todo el software
     */
    public function index()
    {
        $software = Software::with('categoriaSoftware')->get();

        return response()->json([
            'software' => $software,
        ]);
    }

    /**
     * Crear un nuevo software
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_programa' => 'required|string|max:255',
            'categoria_software_id' => 'nullable|exists:categorias_software,id',
            'version' => 'nullable|string',
            'licencia' => 'nullable|string',
        ]);

        $software = Software::create($request->all());
        $software->load('categoriaSoftware');

        return response()->json([
            'mensaje' => 'Software creado exitosamente',
            'software' => $software,
        ], 201);
    }

    /**
     * Mostrar un software específico
     */
    public function show($id)
    {
        $software = Software::findOrFail($id);

        return response()->json([
            'software' => $software,
        ]);
    }

    /**
     * Actualizar un software
     */
    public function update(Request $request, $id)
    {
        $software = Software::findOrFail($id);

        $request->validate([
            'nombre_programa' => 'required|string|max:255',
            'categoria_software_id' => 'nullable|exists:categorias_software,id',
            'version' => 'nullable|string',
            'licencia' => 'nullable|string',
        ]);

        $software->update($request->all());
        $software->load('categoriaSoftware');

        return response()->json([
            'mensaje' => 'Software actualizado exitosamente',
            'software' => $software,
        ]);
    }

    /**
     * Eliminar un software
     */
    public function destroy($id)
    {
        $software = Software::findOrFail($id);
        $software->delete();

        return response()->json([
            'mensaje' => 'Software eliminado exitosamente',
        ]);
    }
}
