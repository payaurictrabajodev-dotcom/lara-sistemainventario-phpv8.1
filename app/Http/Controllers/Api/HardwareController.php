<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hardware;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    /**
     * Listar todo el hardware
     */
    public function index()
    {
        $hardware = Hardware::with('tipoHardware')->get();

        return response()->json([
            'hardware' => $hardware,
        ]);
    }

    /**
     * Crear un nuevo hardware
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_periferico' => 'required|string|max:255',
            'tipo_hardware_id' => 'nullable|exists:tipos_hardware,id',
            'marca' => 'nullable|string',
            'modelo' => 'nullable|string',
            'especificaciones' => 'nullable|string',
            'codigo_inventario' => 'nullable|string|unique:hardware,codigo_inventario',
            'numero_serie' => 'nullable|string',
        ]);

        $hardware = Hardware::create($request->all());
        $hardware->load('tipoHardware');

        return response()->json([
            'mensaje' => 'Hardware creado exitosamente',
            'hardware' => $hardware,
        ], 201);
    }

    /**
     * Mostrar un hardware específico
     */
    public function show($id)
    {
        $hardware = Hardware::findOrFail($id);

        return response()->json([
            'hardware' => $hardware,
        ]);
    }

    /**
     * Actualizar un hardware
     */
    public function update(Request $request, $id)
    {
        $hardware = Hardware::findOrFail($id);

        $request->validate([
            'nombre_periferico' => 'required|string|max:255',
            'tipo_hardware_id' => 'nullable|exists:tipos_hardware,id',
            'marca' => 'nullable|string',
            'modelo' => 'nullable|string',
            'especificaciones' => 'nullable|string',
            'numero_serie' => 'nullable|string',
        ]);

        $hardware->update($request->all());
        $hardware->load('tipoHardware');

        return response()->json([
            'mensaje' => 'Hardware actualizado exitosamente',
            'hardware' => $hardware,
        ]);
    }

    /**
     * Eliminar un hardware
     */
    public function destroy($id)
    {
        $hardware = Hardware::findOrFail($id);
        $hardware->delete();

        return response()->json([
            'mensaje' => 'Hardware eliminado exitosamente',
        ]);
    }
}
