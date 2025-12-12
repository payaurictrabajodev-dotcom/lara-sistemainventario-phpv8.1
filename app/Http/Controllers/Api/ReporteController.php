<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Impresora;
use App\Models\Componente;
use App\Models\UnidadOrganizacional;
use App\Models\User;
use App\Models\Responsable;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    /**
     * Búsqueda completa de equipos, impresoras y componentes por responsable
     */
    public function buscarPorResponsable(Request $request)
    {
        $busqueda = $request->input('busqueda');

        if (!$busqueda) {
            return response()->json(['error' => 'Término de búsqueda requerido'], 400);
        }

        // Buscar responsable por DNI, código o nombre
        $responsables = Responsable::where('dni', 'LIKE', "%{$busqueda}%")
            ->orWhere('nombre_completo', 'LIKE', "%{$busqueda}%")
            ->get();

        if ($responsables->isEmpty()) {
            return response()->json([
                'responsable' => null,
                'equipos' => [],
                'impresoras' => [],
                'componentes' => []
            ]);
        }

        // Si hay múltiples coincidencias, usar el primero
        $responsable = $responsables->first();

        // Obtener todos los equipos del responsable
        $equipos = Equipo::with(['tipoEquipo', 'unidadOrganizacional', 'hardware', 'software'])
            ->where('responsable_id', $responsable->id)
            ->get()
            ->map(function ($equipo) {
                return [
                    'id' => $equipo->id,
                    'codigo_patrimonial' => $equipo->codigo_patrimonial,
                    'numero_serie' => $equipo->numero_serie,
                    'tipo' => $equipo->tipoEquipo->nombre ?? 'N/A',
                    'marca' => $equipo->marca,
                    'modelo' => $equipo->modelo,
                    'estado' => $equipo->estado,
                    'unidad' => $equipo->unidadOrganizacional->nombre ?? 'N/A',
                    'procesador' => $equipo->procesador_marca . ' ' . $equipo->procesador_modelo,
                    'ram_gb' => $equipo->ram_capacidad_gb ?? $equipo->ram_gb,
                    'disco_gb' => $equipo->disco_capacidad_gb ?? $equipo->almacenamiento_gb
                ];
            });

        // Obtener todas las impresoras del responsable
        $impresoras = Impresora::with(['tipoImpresora', 'unidadOrganizacional'])
            ->where('responsable_id', $responsable->id)
            ->get()
            ->map(function ($impresora) {
                return [
                    'id' => $impresora->id,
                    'codigo_patrimonial' => $impresora->codigo_patrimonial,
                    'numero_serie' => $impresora->numero_serie,
                    'tipo' => $impresora->tipoImpresora->nombre ?? 'N/A',
                    'marca' => $impresora->marca,
                    'modelo' => $impresora->modelo,
                    'estado' => $impresora->estado,
                    'unidad' => $impresora->unidadOrganizacional->nombre ?? 'N/A'
                ];
            });

        // Obtener todos los componentes del responsable
        $componentes = Componente::with(['unidadOrganizacional'])
            ->where('responsable_id', $responsable->id)
            ->get()
            ->map(function ($componente) {
                return [
                    'id' => $componente->id,
                    'codigo_patrimonial' => $componente->codigo_patrimonial,
                    'nombre' => $componente->nombre,
                    'tipo' => $componente->tipo,
                    'marca' => $componente->marca,
                    'modelo' => $componente->modelo,
                    'estado' => $componente->estado,
                    'unidad' => $componente->unidadOrganizacional->nombre ?? 'N/A'
                ];
            });

        return response()->json([
            'responsable' => [
                'id' => $responsable->id,
                'dni' => $responsable->dni,
                'nombre_completo' => $responsable->nombre_completo,
                'grado_academico' => $responsable->grado_academico,
                'cargo' => $responsable->cargo,
                'telefono' => $responsable->telefono,
                'email' => $responsable->email
            ],
            'equipos' => $equipos,
            'impresoras' => $impresoras,
            'componentes' => $componentes,
            'total_equipos' => $equipos->count(),
            'total_impresoras' => $impresoras->count(),
            'total_componentes' => $componentes->count()
        ]);
    }

    /**
     * Búsqueda global por código de inventario, DNI o nombre de responsable
     */
    public function buscarPorCodigo(Request $request)
    {
        $codigo = $request->input('codigo');

        if (!$codigo) {
            return response()->json(['error' => 'Código requerido'], 400);
        }

        $resultados = [];

        // Buscar en equipos (por código, DNI o nombre de responsable)
        $equipos = Equipo::with(['tipoEquipo', 'unidadOrganizacional', 'usuario', 'responsable', 'componentes', 'hardware', 'software'])
            ->where(function($query) use ($codigo) {
                $query->where('codigo_patrimonial', 'LIKE', "%{$codigo}%")
                      ->orWhere('numero_serie', 'LIKE', "%{$codigo}%")
                      ->orWhereHas('responsable', function($q) use ($codigo) {
                          $q->where('dni', 'LIKE', "%{$codigo}%")
                            ->orWhere('nombre_completo', 'LIKE', "%{$codigo}%");
                      });
            })
            ->get()
            ->map(function ($equipo) {
                return [
                    'tipo' => 'equipo',
                    'id' => $equipo->id,
                    'codigo_patrimonial' => $equipo->codigo_patrimonial,
                    'numero_serie' => $equipo->numero_serie,
                    'tipo_especifico' => $equipo->tipoEquipo->nombre ?? null,
                    'marca' => $equipo->marca,
                    'modelo' => $equipo->modelo,
                    'estado' => $equipo->estado,
                    'unidad' => $equipo->unidadOrganizacional->nombre ?? null,
                    'unidad_id' => $equipo->unidad_organizacional_id,
                    'responsable' => $equipo->responsable ? $equipo->responsable->nombre_completo : ($equipo->usuario->name ?? null),
                    'responsable_id' => $equipo->responsable_id ?? $equipo->usuario_id,
                    'responsable_dni' => $equipo->responsable->dni ?? null,
                    'procesador' => $equipo->procesador,
                    'ram_gb' => $equipo->ram_gb,
                    'almacenamiento_gb' => $equipo->almacenamiento_gb,
                    'componentes' => $equipo->componentes,
                    'hardware' => $equipo->hardware,
                    'software' => $equipo->software,
                    'observaciones' => $equipo->observaciones,
                    'fecha_compra' => $equipo->fecha_compra,
                ];
            });

        // Buscar en impresoras (por código, DNI o nombre de responsable)
        $impresoras = Impresora::with(['tipoImpresora', 'tipoInsumo', 'unidadOrganizacional', 'responsable'])
            ->where(function($query) use ($codigo) {
                $query->where('codigo_patrimonial', 'LIKE', "%{$codigo}%")
                      ->orWhere('numero_serie', 'LIKE', "%{$codigo}%")
                      ->orWhereHas('responsable', function($q) use ($codigo) {
                          $q->where('dni', 'LIKE', "%{$codigo}%")
                            ->orWhere('nombre_completo', 'LIKE', "%{$codigo}%");
                      });
            })
            ->get()
            ->map(function ($impresora) {
                return [
                    'tipo' => 'impresora',
                    'id' => $impresora->id,
                    'codigo_patrimonial' => $impresora->codigo_patrimonial,
                    'numero_serie' => $impresora->numero_serie,
                    'tipo_especifico' => $impresora->tipoImpresora->nombre ?? null,
                    'tipo_insumo' => $impresora->tipoInsumo->nombre ?? null,
                    'marca' => $impresora->marca,
                    'modelo' => $impresora->modelo,
                    'estado' => $impresora->estado,
                    'unidad' => $impresora->unidadOrganizacional->nombre ?? null,
                    'unidad_id' => $impresora->unidad_organizacional_id,
                    'responsable' => $impresora->responsable ? $impresora->responsable->nombre_completo : null,
                    'responsable_id' => $impresora->responsable_id ?? $impresora->usuario_responsable_id,
                    'responsable_dni' => $impresora->responsable->dni ?? null,
                    'observaciones' => $impresora->observaciones,
                ];
            });

        // Buscar en componentes
        $componentes = Componente::with(['unidadOrganizacional', 'equipos'])
            ->where('codigo_patrimonial', 'LIKE', "%{$codigo}%")
            ->get()
            ->map(function ($componente) {
                return [
                    'tipo' => 'componente',
                    'id' => $componente->id,
                    'codigo_patrimonial' => $componente->codigo_patrimonial,
                    'numero_serie' => $componente->numero_serie,
                    'nombre' => $componente->nombre,
                    'tipo_especifico' => $componente->tipo,
                    'marca' => $componente->marca,
                    'modelo' => $componente->modelo,
                    'especificaciones' => $componente->especificaciones,
                    'estado' => $componente->estado,
                    'unidad' => $componente->unidadOrganizacional->nombre ?? null,
                    'unidad_id' => $componente->unidad_organizacional_id,
                    'equipos_asignados' => $componente->equipos,
                    'observaciones' => $componente->observaciones,
                ];
            });

        $resultados = $equipos->concat($impresoras)->concat($componentes);

        return response()->json([
            'resultados' => $resultados,
            'total' => $resultados->count()
        ]);
    }

    /**
     * Reporte por responsable
     */
    public function reportePorResponsable(Request $request)
    {
        $responsableId = $request->input('responsable_id');

        if (!$responsableId) {
            return response()->json(['error' => 'ID de responsable requerido'], 400);
        }

        $responsable = User::find($responsableId);

        // Equipos del responsable
        $equipos = Equipo::with(['tipoEquipo', 'unidadOrganizacional', 'componentes', 'hardware', 'software'])
            ->where('usuario_id', $responsableId)
            ->get();

        // Impresoras del responsable
        $impresoras = Impresora::with(['tipoImpresora', 'tipoInsumo', 'unidadOrganizacional'])
            ->where('usuario_responsable_id', $responsableId)
            ->get();

        return response()->json([
            'responsable' => $responsable,
            'equipos' => $equipos,
            'impresoras' => $impresoras,
            'total_equipos' => $equipos->count(),
            'total_impresoras' => $impresoras->count()
        ]);
    }

    /**
     * Reporte por unidad organizacional
     */
    public function reportePorUnidad(Request $request)
    {
        $unidadId = $request->input('unidad_id');

        if (!$unidadId) {
            return response()->json(['error' => 'ID de unidad requerido'], 400);
        }

        $unidad = UnidadOrganizacional::with('tipoUnidad')->find($unidadId);

        // Equipos de la unidad
        $equipos = Equipo::with(['tipoEquipo', 'usuario', 'componentes', 'hardware', 'software'])
            ->where('unidad_organizacional_id', $unidadId)
            ->get();

        // Impresoras de la unidad
        $impresoras = Impresora::with(['tipoImpresora', 'tipoInsumo', 'responsable'])
            ->where('unidad_organizacional_id', $unidadId)
            ->get();

        // Componentes de la unidad
        $componentes = Componente::with('equipos')
            ->where('unidad_organizacional_id', $unidadId)
            ->get();

        // Estadísticas
        $estadisticas = [
            'total_equipos' => $equipos->count(),
            'equipos_operativos' => $equipos->where('estado', 'Operativo')->count(),
            'equipos_en_reparacion' => $equipos->where('estado', 'En Reparación')->count(),
            'equipos_fuera_servicio' => $equipos->where('estado', 'Fuera de Servicio')->count(),
            'total_impresoras' => $impresoras->count(),
            'impresoras_operativas' => $impresoras->where('estado', 'Operativo')->count(),
            'total_componentes' => $componentes->count(),
            'componentes_disponibles' => $componentes->where('estado', 'Disponible')->count(),
            'componentes_en_uso' => $componentes->where('estado', 'En Uso')->count(),
        ];

        return response()->json([
            'unidad' => $unidad,
            'equipos' => $equipos,
            'impresoras' => $impresoras,
            'componentes' => $componentes,
            'estadisticas' => $estadisticas
        ]);
    }

    /**
     * Reporte general de inventario
     */
    public function reporteGeneral(Request $request)
    {
        $filtros = $request->all();

        // Query base para equipos
        $equiposQuery = Equipo::with(['tipoEquipo', 'unidadOrganizacional', 'usuario']);

        if (isset($filtros['unidad_id'])) {
            $equiposQuery->where('unidad_organizacional_id', $filtros['unidad_id']);
        }

        if (isset($filtros['estado'])) {
            $equiposQuery->where('estado', $filtros['estado']);
        }

        if (isset($filtros['tipo_equipo_id'])) {
            $equiposQuery->where('tipo_equipo_id', $filtros['tipo_equipo_id']);
        }

        $equipos = $equiposQuery->get();

        // Query base para impresoras
        $impresorasQuery = Impresora::with(['tipoImpresora', 'unidadOrganizacional', 'responsable']);

        if (isset($filtros['unidad_id'])) {
            $impresorasQuery->where('unidad_organizacional_id', $filtros['unidad_id']);
        }

        if (isset($filtros['estado'])) {
            $impresorasQuery->where('estado', $filtros['estado']);
        }

        $impresoras = $impresorasQuery->get();

        // Query base para componentes
        $componentesQuery = Componente::with(['unidadOrganizacional', 'equipos']);

        if (isset($filtros['unidad_id'])) {
            $componentesQuery->where('unidad_organizacional_id', $filtros['unidad_id']);
        }

        if (isset($filtros['estado'])) {
            $componentesQuery->where('estado', $filtros['estado']);
        }

        $componentes = $componentesQuery->get();

        return response()->json([
            'equipos' => $equipos,
            'impresoras' => $impresoras,
            'componentes' => $componentes,
            'totales' => [
                'equipos' => $equipos->count(),
                'impresoras' => $impresoras->count(),
                'componentes' => $componentes->count(),
                'total_general' => $equipos->count() + $impresoras->count() + $componentes->count()
            ]
        ]);
    }

    /**
     * PDF Reporte 1: Ficha de Equipo Individual (Imagen 1)
     */
    public function pdfFichaEquipo($equipoId)
    {
        $equipo = Equipo::with([
            'tipoEquipo',
            'unidadOrganizacional.parent',
            'usuario.role',
            'componentes',
            'hardware.tipoHardware',
            'software.categoriaSoftware'
        ])->findOrFail($equipoId);

        $data = [
            'equipo' => $equipo,
            'fecha_generacion' => now()->format('d \d\e F \d\e\l Y'),
        ];

        $pdf = Pdf::loadView('reportes.ficha-equipo', $data);
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('ficha-equipo-' . $equipo->codigo_patrimonial . '.pdf');
    }

    /**
     * PDF Reporte 3: Distribución Actual de Impresoras por Oficinas (Imagen 3)
     */
    public function pdfDistribucionImpresoras(Request $request)
    {
        $impresoras = Impresora::with([
            'tipoImpresora',
            'tipoInsumo',
            'unidadOrganizacional.parent',
            'responsable'
        ])
        ->orderBy('unidad_organizacional_id')
        ->orderBy('codigo_patrimonial')
        ->get();

        // Agrupar por unidad organizacional padre (Área)
        $impresorasPorArea = $impresoras->groupBy(function($impresora) {
            if ($impresora->unidadOrganizacional && $impresora->unidadOrganizacional->parent) {
                return $impresora->unidadOrganizacional->parent->nombre;
            } elseif ($impresora->unidadOrganizacional) {
                return $impresora->unidadOrganizacional->nombre;
            }
            return 'Sin área';
        });

        $data = [
            'impresoras_por_area' => $impresorasPorArea,
            'fecha_generacion' => now()->format('d/m/Y'),
            'titulo' => 'DISTRIBUCIÓN ACTUAL DE IMPRESORAS POR OFICINAS ' . date('Y')
        ];

        $pdf = Pdf::loadView('reportes.distribucion-impresoras', $data);
        $pdf->setPaper('letter', 'landscape');

        return $pdf->stream('distribucion-impresoras-' . date('Y-m-d') . '.pdf');
    }

    /**
     * PDF Reporte 2: Inventario General de Equipos por Oficinas (Imagen 2)
     */
    public function pdfInventarioGeneral(Request $request)
    {
        $unidadId = $request->input('unidad_id');

        $query = Equipo::with([
            'tipoEquipo',
            'unidadOrganizacional.parent',
            'usuario',
            'responsable',
            'hardware.tipoHardware', // Cargar TODO el hardware con sus tipos
            'componentes.tipoComponente' // Cargar componentes con sus tipos
        ]);

        if ($unidadId) {
            $query->where('unidad_organizacional_id', $unidadId);
        }

        $equipos = $query->orderBy('unidad_organizacional_id')->orderBy('codigo_patrimonial')->get();

        // Agrupar por unidad organizacional
        $equiposPorOficina = $equipos->groupBy(function($equipo) {
            return $equipo->unidadOrganizacional ? $equipo->unidadOrganizacional->id : 0;
        });

        $data = [
            'equipos_por_oficina' => $equiposPorOficina,
            'fecha_generacion' => now()->format('d/m/Y'),
            'titulo' => 'RESUMEN DE LA TOMA DE INVENTARIO DE HARDWARE Y SOFTWARE POR OFICINAS ' . date('Y')
        ];

        $pdf = Pdf::loadView('reportes.inventario-oficinas', $data);
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('inventario-oficinas-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Obtener lista de equipos para selector
     */
    public function listarEquipos()
    {
        $equipos = Equipo::select('id', 'codigo_patrimonial', 'marca', 'modelo')
            ->orderBy('codigo_patrimonial')
            ->get()
            ->map(function($equipo) {
                return [
                    'id' => $equipo->id,
                    'label' => $equipo->codigo_patrimonial . ' - ' . $equipo->marca . ' ' . $equipo->modelo
                ];
            });

        return response()->json($equipos);
    }

    /**
     * Obtener lista de unidades organizacionales para selector
     */
    public function listarUnidades()
    {
        $unidades = UnidadOrganizacional::select('id', 'nombre', 'codigo')
            ->orderBy('nombre')
            ->get()
            ->map(function($unidad) {
                return [
                    'id' => $unidad->id,
                    'label' => ($unidad->codigo ? $unidad->codigo . ' - ' : '') . $unidad->nombre
                ];
            });

        return response()->json($unidades);
    }

    /**
     * Obtener lista de responsables para selector
     */
    public function listarResponsables()
    {
        $responsables = Responsable::select('id', 'dni', 'nombre_completo', 'cargo')
            ->orderBy('nombre_completo')
            ->get()
            ->map(function($responsable) {
                return [
                    'id' => $responsable->id,
                    'label' => $responsable->nombre_completo . ' (DNI: ' . $responsable->dni . ')'
                ];
            });

        return response()->json($responsables);
    }
}
