<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EquipoController extends Controller
{
    /**
     * Listar todos los equipos
     */
    public function index()
    {
        $equipos = Equipo::with([
            'unidadOrganizacional',
            'tipoEquipo',
            'usuario',
            'hardware.tipoHardware',
            'software.categoriaSoftware',
            'componentes'
        ])->get();

        return response()->json([
            'equipos' => $equipos,
        ]);
    }

    /**
     * Crear un nuevo equipo
     */
    public function store(Request $request)
    {
        $request->validate([
            'unidad_organizacional_id' => 'nullable|exists:unidades_organizacionales,id',
            'codigo_patrimonial' => 'nullable|string|unique:equipos',
            'codigo_inventario' => 'nullable|string|unique:equipos',
            'responsable_id' => 'nullable|exists:responsables,id',
            'tipo_equipo_id' => 'nullable|exists:tipos_equipo,id',
            'numero_serie' => 'nullable|string',
            'marca' => 'nullable|string',
            'modelo' => 'nullable|string',
            'direccion_ip' => 'nullable|string',
            'fecha_registro' => 'nullable|date',
            'fecha_compra' => 'nullable|date',
            'fecha_fabricacion' => 'nullable|date',
            'estado' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['usuario_id'] = auth()->id();

        $equipo = Equipo::create($data);

        return response()->json([
            'mensaje' => 'Equipo creado exitosamente',
            'equipo' => $equipo->load([
                'unidadOrganizacional',
                'tipoEquipo',
                'usuario',
                'responsable',
                'hardware.tipoHardware',
                'software.categoriaSoftware',
                'componentes'
            ]),
        ], 201);
    }

    /**
     * Mostrar un equipo específico
     */
    public function show($id)
    {
        $equipo = Equipo::with([
            'unidadOrganizacional',
            'tipoEquipo',
            'usuario',
            'hardware.tipoHardware',
            'software.categoriaSoftware',
            'componentes'
        ])->findOrFail($id);

        return response()->json([
            'equipo' => $equipo,
        ]);
    }

    /**
     * Actualizar un equipo
     */
    public function update(Request $request, $id)
    {
        $equipo = Equipo::findOrFail($id);

        $request->validate([
            'unidad_organizacional_id' => 'nullable|exists:unidades_organizacionales,id',
            'codigo_patrimonial' => 'nullable|string|unique:equipos,codigo_patrimonial,' . $id,
            'codigo_inventario' => 'nullable|string|unique:equipos,codigo_inventario,' . $id,
            'responsable_id' => 'nullable|exists:responsables,id',
            'tipo_equipo_id' => 'nullable|exists:tipos_equipo,id',
            'numero_serie' => 'nullable|string',
            'marca' => 'nullable|string',
            'modelo' => 'nullable|string',
            'direccion_ip' => 'nullable|string',
            'fecha_registro' => 'nullable|date',
            'fecha_compra' => 'nullable|date',
            'fecha_fabricacion' => 'nullable|date',
            'estado' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['usuario_id'] = auth()->id();

        $equipo->update($data);

        return response()->json([
            'mensaje' => 'Equipo actualizado exitosamente',
            'equipo' => $equipo->load([
                'unidadOrganizacional',
                'tipoEquipo',
                'usuario',
                'responsable',
                'hardware.tipoHardware',
                'software.categoriaSoftware',
                'componentes'
            ]),
        ]);
    }

    /**
     * Eliminar un equipo
     */
    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();

        return response()->json([
            'mensaje' => 'Equipo eliminado exitosamente',
        ]);
    }
}
