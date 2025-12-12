<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Responsable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResponsableController extends Controller
{
    public function index()
    {
        $responsables = Responsable::orderBy('nombre_completo')->get();
        return response()->json($responsables);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dni' => 'required|string|unique:responsables,dni|max:20',
            'nombre_completo' => 'required|string|max:255',
            'grado_academico' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255'
        ]);

        $responsable = Responsable::create($validated);
        return response()->json($responsable, 201);
    }

    public function show($id)
    {
        $responsable = Responsable::findOrFail($id);
        return response()->json($responsable);
    }

    public function update(Request $request, $id)
    {
        $responsable = Responsable::findOrFail($id);
        
        $validated = $request->validate([
            'dni' => ['required', 'string', 'max:20', Rule::unique('responsables')->ignore($id)],
            'nombre_completo' => 'required|string|max:255',
            'grado_academico' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255'
        ]);

        $responsable->update($validated);
        return response()->json($responsable);
    }

    public function destroy($id)
    {
        $responsable = Responsable::findOrFail($id);
        $responsable->delete();
        return response()->json(['message' => 'Responsable eliminado correctamente']);
    }

    public function buscar(Request $request)
    {
        $termino = $request->input('termino', '');
        
        $responsables = Responsable::where('dni', 'like', "%{$termino}%")
            ->orWhere('nombre_completo', 'like', "%{$termino}%")
            ->limit(20)
            ->get();
            
        return response()->json($responsables);
    }
}
