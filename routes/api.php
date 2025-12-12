<?php

use App\Http\Controllers\Api\TipoComponenteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\EquipoController;
use App\Http\Controllers\Api\UnidadOrganizacionalController;

use App\Http\Controllers\Api\ImpresoraController;
use App\Http\Controllers\Api\TipoEquipoController;
use App\Http\Controllers\Api\TipoUnidadOrganizacionalController;

use App\Http\Controllers\Api\HardwareController;
use App\Http\Controllers\Api\SoftwareController;
use App\Http\Controllers\Api\TipoImpresoraController;
use App\Http\Controllers\Api\TipoInsumoController;
use App\Http\Controllers\Api\EquipoRelacionController;
use App\Http\Controllers\Api\ComponenteController;
use App\Http\Controllers\Api\GestionEquiposController;
use App\Http\Controllers\Api\ReporteController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TipoHardwareController;
use App\Http\Controllers\Api\CategoriaSoftwareController;
use App\Http\Controllers\Api\ResponsableController;

// Rutas públicas de autenticación
Route::post('/registrar', [AuthController::class, 'registrar']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas con autenticación Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/usuario', [AuthController::class, 'usuarioActual']);

    // Dashboard stats
    Route::get('/dashboard/stats', [DashboardController::class, 'index']);

    // Equipos
    Route::apiResource('equipos', EquipoController::class);

    // Unidades Organizacionales
    Route::apiResource('unidades-organizacionales', UnidadOrganizacionalController::class);
    Route::get('/unidades-organizacionales-tree', [UnidadOrganizacionalController::class, 'tree']);
    Route::get('/unidades-organizacionales/{id}/children', [UnidadOrganizacionalController::class, 'children']);

    // Impresoras
    Route::apiResource('impresoras', ImpresoraController::class);

    // Tipos de Equipo
    Route::apiResource('tipos-equipo', TipoEquipoController::class);

    // Tipos de Unidad Organizacional
    Route::apiResource('tipos-unidad', TipoUnidadOrganizacionalController::class);

    // Usuarios
    Route::apiResource('usuarios', UserController::class);
    Route::get('/usuarios-rol/{roleId}', [UserController::class, 'porRol']);
    Route::get('/usuarios-administradores', [UserController::class, 'administradores']);
    Route::post('/usuarios/{id}/cambiar-contrasena', [UserController::class, 'cambiarContrasena']);

    // Roles
    Route::apiResource('roles', RolController::class);

    // Hardware
    Route::apiResource('hardware', HardwareController::class);

    // Gestión de relaciones equipos <-> hardware/software/componentes
    Route::get('equipos/{id}/hardware', [EquipoRelacionController::class, 'listarHardware']);
    Route::post('equipos/{id}/hardware', [EquipoRelacionController::class, 'adjuntarHardware']);
    Route::put('equipos/{id}/hardware/sync', [EquipoRelacionController::class, 'sincronizarHardware']);
    Route::delete('equipos/{id}/hardware/{hid}', [EquipoRelacionController::class, 'desvincularHardware']);

    Route::get('equipos/{id}/software', [EquipoRelacionController::class, 'listarSoftware']);
    Route::post('equipos/{id}/software', [EquipoRelacionController::class, 'adjuntarSoftware']);
    Route::put('equipos/{id}/software/sync', [EquipoRelacionController::class, 'sincronizarSoftware']);
    Route::delete('equipos/{id}/software/{sid}', [EquipoRelacionController::class, 'desvincularSoftware']);

    Route::get('equipos/{id}/componentes', [EquipoRelacionController::class, 'listarComponentes']);
    Route::post('equipos/{id}/componentes', [EquipoRelacionController::class, 'adjuntarComponente']);
    Route::put('equipos/{id}/componentes/sync', [EquipoRelacionController::class, 'sincronizarComponentes']);
    Route::delete('equipos/{id}/componentes/{cid}', [EquipoRelacionController::class, 'desvincularComponente']);

    // Componentes (CRUD independiente)
    Route::apiResource('componentes', ComponenteController::class);

    // Software
    Route::apiResource('software', SoftwareController::class);

    // Tipos de Impresora
    Route::apiResource('tipos-impresora', TipoImpresoraController::class);

    // Tipos de Insumo
    Route::apiResource('tipos-insumo', TipoInsumoController::class);

    // Catálogos
    Route::apiResource('tipos-hardware', TipoHardwareController::class);
    Route::apiResource('categorias-software', CategoriaSoftwareController::class);
    Route::apiResource('tipos-componente', TipoComponenteController::class);

    // Responsables
    Route::apiResource('responsables', ResponsableController::class);
    Route::get('/responsables-buscar', [ResponsableController::class, 'buscar']);

    // Reportes
    Route::post('/reportes/buscar-codigo', [ReporteController::class, 'buscarPorCodigo']);
    Route::get('/reportes/buscar-responsable', [ReporteController::class, 'buscarPorResponsable']);
    Route::get('/reportes/responsable', [ReporteController::class, 'reportePorResponsable']);
    Route::get('/reportes/unidad', [ReporteController::class, 'reportePorUnidad']);
    Route::get('/reportes/general', [ReporteController::class, 'reporteGeneral']);
    Route::get('/reportes/listar-equipos', [ReporteController::class, 'listarEquipos']);
    Route::get('/reportes/listar-unidades', [ReporteController::class, 'listarUnidades']);
    Route::get('/reportes/listar-responsables', [ReporteController::class, 'listarResponsables']);
});

// Reportes PDF - Rutas públicas (sin autenticación para permitir descarga directa)
Route::get('/reportes/pdf/ficha-equipo/{id}', [ReporteController::class, 'pdfFichaEquipo']);
Route::get('/reportes/pdf/inventario-general', [ReporteController::class, 'pdfInventarioGeneral']);
Route::get('/reportes/pdf/distribucion-impresoras', [ReporteController::class, 'pdfDistribucionImpresoras']);

/**Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});**/