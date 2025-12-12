<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\ComponenteEquipo;

class ComponenteEquipoController extends Controller
{
    public function index($equipoId)
    {
        $equipo = Equipo::with('componentes')->findOrFail($equipoId);
        return response()->json($equipo->componentes);
    }

    public function store(Request $request, $equipoId)
    {
        $request->validate([
            'nombre' => 'required|string',
            'observaciones' => 'nullable|string',
        ]);

        $equipo = Equipo::findOrFail($equipoId);

        $componente = $equipo->componentes()->create([
            'nombre' => $request->input('nombre'),
            'observaciones' => $request->input('observaciones'),
        ]);

        return response()->json($componente, 201);
    }

    public function show($equipoId, $componenteId)
    {
        $componente = ComponenteEquipo::where('equipo_id', $equipoId)->findOrFail($componenteId);
        return response()->json($componente);
    }

    public function update(Request $request, $equipoId, $componenteId)
    {
        $request->validate([
            'nombre' => 'sometimes|required|string',
            'observaciones' => 'nullable|string',
        ]);

        $componente = ComponenteEquipo::where('equipo_id', $equipoId)->findOrFail($componenteId);
        $componente->update($request->only(['nombre', 'observaciones']));

        return response()->json($componente);
    }

    public function destroy($equipoId, $componenteId)
    {
        $componente = ComponenteEquipo::where('equipo_id', $equipoId)->findOrFail($componenteId);
        $componente->delete();
        return response()->json(['message' => 'Componente eliminado']);
    }
}
