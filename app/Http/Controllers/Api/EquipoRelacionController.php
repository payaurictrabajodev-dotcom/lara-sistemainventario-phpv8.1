<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Hardware;
use App\Models\Software;

class EquipoRelacionController extends Controller
{
    // Listar hardware asociado a un equipo
    public function listarHardware($equipoId)
    {
        $equipo = Equipo::with('hardware.tipoHardware')->findOrFail($equipoId);
        return response()->json([
            'hardware' => $equipo->hardware
        ]);
    }

    // Adjuntar un hardware a un equipo
    public function adjuntarHardware(Request $request, $equipoId)
    {
        $request->validate([
            'hardware_id' => 'nullable|integer|exists:hardware,id',
            'hardware_ids' => 'nullable|array',
            'hardware_ids.*' => 'integer|exists:hardware,id',
            'observaciones' => 'nullable|string',
        ]);

        $equipo = Equipo::findOrFail($equipoId);

        // Soporta un único id o múltiples
        if ($request->filled('hardware_ids')) {
            foreach ($request->input('hardware_ids') as $hid) {
                $equipo->hardware()->syncWithoutDetaching([$hid => ['observaciones' => $request->input('observaciones')]]);
            }
        } elseif ($request->filled('hardware_id')) {
            $equipo->hardware()->syncWithoutDetaching([$request->input('hardware_id') => ['observaciones' => $request->input('observaciones')]]);
        } else {
            return response()->json(['message' => 'hardware_id o hardware_ids requerido'], 422);
        }

        return response()->json(['message' => 'Hardware vinculado correctamente']);
    }

    // Sincronizar hardware completo (reemplaza todos)
    public function sincronizarHardware(Request $request, $equipoId)
    {
        $request->validate([
            'hardware_ids' => 'required|array',
            'hardware_ids.*' => 'integer|exists:hardware,id',
        ]);

        $equipo = Equipo::findOrFail($equipoId);
        $equipo->hardware()->sync($request->input('hardware_ids'));

        return response()->json([
            'message' => 'Hardware sincronizado correctamente',
            'hardware' => $equipo->load('hardware.tipoHardware')->hardware
        ]);
    }

    // Desvincular hardware
    public function desvincularHardware($equipoId, $hardwareId)
    {
        $equipo = Equipo::findOrFail($equipoId);
        $equipo->hardware()->detach($hardwareId);
        return response()->json(['message' => 'Hardware desvinculado']);
    }

    // Listar software asociado a un equipo
    public function listarSoftware($equipoId)
    {
        $equipo = Equipo::with('software.categoriaSoftware')->findOrFail($equipoId);
        return response()->json([
            'software' => $equipo->software
        ]);
    }

    // Adjuntar software
    public function adjuntarSoftware(Request $request, $equipoId)
    {
        $request->validate([
            'software_id' => 'nullable|integer|exists:software,id',
            'software_ids' => 'nullable|array',
            'software_ids.*' => 'integer|exists:software,id',
            'observaciones' => 'nullable|string',
        ]);

        $equipo = Equipo::findOrFail($equipoId);

        if ($request->filled('software_ids')) {
            foreach ($request->input('software_ids') as $sid) {
                $equipo->software()->syncWithoutDetaching([$sid => ['observaciones' => $request->input('observaciones')]]);
            }
        } elseif ($request->filled('software_id')) {
            $equipo->software()->syncWithoutDetaching([$request->input('software_id') => ['observaciones' => $request->input('observaciones')]]);
        } else {
            return response()->json(['message' => 'software_id o software_ids requerido'], 422);
        }

        return response()->json(['message' => 'Software vinculado correctamente']);
    }

    // Sincronizar software completo (reemplaza todos)
    public function sincronizarSoftware(Request $request, $equipoId)
    {
        $request->validate([
            'software_ids' => 'required|array',
            'software_ids.*' => 'integer|exists:software,id',
        ]);

        $equipo = Equipo::findOrFail($equipoId);
        $equipo->software()->sync($request->input('software_ids'));

        return response()->json([
            'message' => 'Software sincronizado correctamente',
            'software' => $equipo->load('software.categoriaSoftware')->software
        ]);
    }

    // Desvincular software
    public function desvincularSoftware($equipoId, $softwareId)
    {
        $equipo = Equipo::findOrFail($equipoId);
        $equipo->software()->detach($softwareId);
        return response()->json(['message' => 'Software desvinculado']);
    }

    // Listar componentes asociados a un equipo
    public function listarComponentes($equipoId)
    {
        $equipo = Equipo::with('componentes.tipoComponente')->findOrFail($equipoId);
        return response()->json([
            'componentes' => $equipo->componentes
        ]);
    }

    // Adjuntar componente
    public function adjuntarComponente(Request $request, $equipoId)
    {
        $request->validate([
            'componente_id' => 'required|integer|exists:componentes,id',
            'fecha_asignacion' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $equipo = Equipo::findOrFail($equipoId);

        $equipo->componentes()->syncWithoutDetaching([
            $request->input('componente_id') => [
                'fecha_asignacion' => $request->input('fecha_asignacion'),
                'observaciones' => $request->input('observaciones')
            ]
        ]);

        return response()->json(['message' => 'Componente vinculado correctamente']);
    }

    // Sincronizar componentes completo (reemplaza todos)
    public function sincronizarComponentes(Request $request, $equipoId)
    {
        $request->validate([
            'componente_ids' => 'required|array',
            'componente_ids.*' => 'integer|exists:componentes,id',
        ]);

        $equipo = Equipo::findOrFail($equipoId);
        $equipo->componentes()->sync($request->input('componente_ids'));

        return response()->json([
            'message' => 'Componentes sincronizados correctamente',
            'componentes' => $equipo->load('componentes')->componentes
        ]);
    }

    // Desvincular componente
    public function desvincularComponente($equipoId, $componenteId)
    {
        $equipo = Equipo::findOrFail($equipoId);
        $equipo->componentes()->detach($componenteId);
        return response()->json(['message' => 'Componente desvinculado']);
    }
}
