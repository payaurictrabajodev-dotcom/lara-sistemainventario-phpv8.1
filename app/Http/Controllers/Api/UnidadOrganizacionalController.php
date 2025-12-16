<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnidadOrganizacional;
use Illuminate\Http\Request;

class UnidadOrganizacionalController extends Controller
{
    /**
     * Listar todas las unidades organizacionales
     */
    public function index()
    {
        $unidades = UnidadOrganizacional::with(['tipoUnidad', 'parent', 'children'])->get();

        return response()->json([
            'unidades' => $unidades,
        ]);
    }

    /**
     * Obtener estructura jerárquica (árbol)
     */
    public function tree()
    {
        $unidades = UnidadOrganizacional::with(['tipoUnidad', 'children'])
            ->whereNull('parent_id')
            ->get();

        return response()->json([
            'unidades' => $unidades,
        ]);
    }

    /**
     * Obtener hijos de una unidad específica
     */
    public function children($id)
    {
        $unidad = UnidadOrganizacional::findOrFail($id);
        $children = $unidad->children()->with('tipoUnidad')->get();

        return response()->json([
            'children' => $children,
        ]);
    }

    /**
     * Crear una nueva unidad organizacional
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo_unidad_id' => 'nullable|exists:tipos_unidad_organizacional,id',
            'parent_id' => 'nullable|exists:unidades_organizacionales,id',
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        $unidad = UnidadOrganizacional::create($request->all());

        return response()->json([
            'mensaje' => 'Unidad organizacional creada exitosamente',
            'unidad' => $unidad->load(['tipoUnidad', 'parent']),
        ], 201);
    }

    /**
     * Mostrar una unidad organizacional específica
     */
    public function show($id)
    {
        $unidad = UnidadOrganizacional::with(['tipoUnidad', 'equipos'])->findOrFail($id);

        return response()->json([
            'unidad' => $unidad,
        ]);
    }

    /**
     * Actualizar una unidad organizacional
     */
    public function update(Request $request, $id)
    {
        $unidad = UnidadOrganizacional::findOrFail($id);

        $request->validate([
            'tipo_unidad_id' => 'nullable|exists:tipos_unidad_organizacional,id',
            'parent_id' => 'nullable|exists:unidades_organizacionales,id',
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        // Validar que no se asigne como padre a sí mismo o a sus descendientes
        if ($request->parent_id) {
            if ($request->parent_id == $id) {
                return response()->json([
                    'error' => 'Una unidad no puede ser su propio padre'
                ], 422);
            }

            $descendants = $this->getAllDescendants($id);
            if (in_array($request->parent_id, $descendants)) {
                return response()->json([
                    'error' => 'No se puede asignar un descendiente como padre'
                ], 422);
            }
        }

        $unidad->update($request->all());

        return response()->json([
            'mensaje' => 'Unidad organizacional actualizada exitosamente',
            'unidad' => $unidad->load(['tipoUnidad', 'parent']),
        ]);
    }

    /**
     * Obtener todos los IDs de descendientes
     */
    private function getAllDescendants($id)
    {
        $descendants = [];
        $children = UnidadOrganizacional::where('parent_id', $id)->pluck('id');

        foreach ($children as $childId) {
            $descendants[] = $childId;
            $descendants = array_merge($descendants, $this->getAllDescendants($childId));
        }

        return $descendants;
    }

    /**
     * Eliminar una unidad organizacional
     */
    public function destroy($id)
    {
        $unidad = UnidadOrganizacional::findOrFail($id);
        $unidad->delete();

        return response()->json([
            'mensaje' => 'Unidad organizacional eliminada exitosamente',
        ]);
    }
}
