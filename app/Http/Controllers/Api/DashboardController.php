<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\Impresora;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Retorna métricas para el dashboard
     */
    public function index(Request $request)
    {
        $totalEquipos = Equipo::count();
        $totalImpresoras = Impresora::count();
        $totalUsuarios = User::count();

        // Registros activos: equipos cuyo estado no sea 'Baja' (fallback razonable)
        $totalRegistrosActivos = Equipo::where('estado', '!=', 'Baja')->count();

        return response()->json([
            'total_equipos' => $totalEquipos,
            'total_impresoras' => $totalImpresoras,
            'total_usuarios' => $totalUsuarios,
            'total_registros_activos' => $totalRegistrosActivos,
        ]);
    }
}
