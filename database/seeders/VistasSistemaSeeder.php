<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VistasSistemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vistas = [
            // Usuarios (Padre)
            [
                'nombre' => 'Usuarios',
                'ruta' => '#',
                'icono' => 'pi pi-users',
                'modulo' => 'Usuarios',
                'orden' => 1,
                'es_menu' => true,
                'parent_id' => null
            ],

            // Responsables
            [
                'nombre' => 'Responsables',
                'ruta' => '/admin/responsables/listar',
                'icono' => 'pi pi-users',
                'modulo' => 'Responsables',
                'orden' => 3,
                'es_menu' => true,
                'parent_id' => null
            ],

            // Equipos (Padre)
            [
                'nombre' => 'Equipos',
                'ruta' => '#',
                'icono' => 'pi pi-desktop',
                'modulo' => 'Equipos',
                'orden' => 2,
                'es_menu' => true,
                'parent_id' => null
            ],

            // Inventario (Padre)
            [
                'nombre' => 'Inventario',
                'ruta' => '#',
                'icono' => 'pi pi-box',
                'modulo' => 'Inventario',
                'orden' => 3,
                'es_menu' => true,
                'parent_id' => null
            ],

            // Impresoras (Padre)
            [
                'nombre' => 'Impresoras',
                'ruta' => '#',
                'icono' => 'pi pi-print',
                'modulo' => 'Impresoras',
                'orden' => 4,
                'es_menu' => true,
                'parent_id' => null
            ],

            // Unidades (Padre)
            [
                'nombre' => 'Unidades',
                'ruta' => '#',
                'icono' => 'pi pi-building',
                'modulo' => 'Unidades',
                'orden' => 5,
                'es_menu' => true,
                'parent_id' => null
            ],

            // Consultas (Padre)
            [
                'nombre' => 'Consultas',
                'ruta' => '#',
                'icono' => 'pi pi-search',
                'modulo' => 'Consultas',
                'orden' => 6,
                'es_menu' => true,
                'parent_id' => null
            ],

            // Reportes (Padre)
            [
                'nombre' => 'Reportes',
                'ruta' => '#',
                'icono' => 'pi pi-chart-bar',
                'modulo' => 'Reportes',
                'orden' => 7,
                'es_menu' => true,
                'parent_id' => null
            ],
        ];

        // Insertar vistas padres primero
        foreach ($vistas as $vista) {
            DB::table('vistas_sistema')->insert(array_merge($vista, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // Obtener IDs de las vistas padres
        $usuariosId = DB::table('vistas_sistema')->where('nombre', 'Usuarios')->value('id');
        $equiposId = DB::table('vistas_sistema')->where('nombre', 'Equipos')->value('id');
        $inventarioId = DB::table('vistas_sistema')->where('nombre', 'Inventario')->value('id');
        $impresorasId = DB::table('vistas_sistema')->where('nombre', 'Impresoras')->value('id');
        $unidadesId = DB::table('vistas_sistema')->where('nombre', 'Unidades')->value('id');
        $consultasId = DB::table('vistas_sistema')->where('nombre', 'Consultas')->value('id');
        $reportesId = DB::table('vistas_sistema')->where('nombre', 'Reportes')->value('id');

        // Vistas hijas
        $vistasHijas = [
            // Hijos de Usuarios
            [
                'nombre' => 'Lista de Usuarios',
                'ruta' => '/admin/usuarios/list',
                'icono' => 'pi pi-list',
                'modulo' => 'Usuarios',
                'orden' => 1,
                'es_menu' => true,
                'parent_id' => $usuariosId
            ],
            [
                'nombre' => 'Roles',
                'ruta' => '/admin/roles',
                'icono' => 'pi pi-shield',
                'modulo' => 'Usuarios',
                'orden' => 2,
                'es_menu' => true,
                'parent_id' => $usuariosId
            ],

            // Hijos de Equipos
            [
                'nombre' => 'Lista de Equipos',
                'ruta' => '/admin/equipos/listar',
                'icono' => 'pi pi-list',
                'modulo' => 'Equipos',
                'orden' => 1,
                'es_menu' => true,
                'parent_id' => $equiposId
            ],
            [
                'nombre' => 'Nuevo Equipo',
                'ruta' => '/admin/equipos/nuevo',
                'icono' => 'pi pi-plus',
                'modulo' => 'Equipos',
                'orden' => 2,
                'es_menu' => true,
                'parent_id' => $equiposId
            ],
            [
                'nombre' => 'Tipos de Equipo',
                'ruta' => '/admin/tipos-equipo/listar',
                'icono' => 'pi pi-tags',
                'modulo' => 'Equipos',
                'orden' => 3,
                'es_menu' => true,
                'parent_id' => $equiposId
            ],

            // Hijos de Inventario
            [
                'nombre' => 'Hardware',
                'ruta' => '/admin/hardware/listar',
                'icono' => 'pi pi-cog',
                'modulo' => 'Inventario',
                'orden' => 1,
                'es_menu' => true,
                'parent_id' => $inventarioId
            ],
            [
                'nombre' => 'Software',
                'ruta' => '/admin/software/listar',
                'icono' => 'pi pi-code',
                'modulo' => 'Inventario',
                'orden' => 2,
                'es_menu' => true,
                'parent_id' => $inventarioId
            ],
            [
                'nombre' => 'Componentes',
                'ruta' => '/admin/componentes/listar',
                'icono' => 'pi pi-th-large',
                'modulo' => 'Inventario',
                'orden' => 3,
                'es_menu' => true,
                'parent_id' => $inventarioId
            ],

            // Hijos de Impresoras
            [
                'nombre' => 'Lista de Impresoras',
                'ruta' => '/admin/impresoras/listar',
                'icono' => 'pi pi-list',
                'modulo' => 'Impresoras',
                'orden' => 1,
                'es_menu' => true,
                'parent_id' => $impresorasId
            ],
            [
                'nombre' => 'Nueva Impresora',
                'ruta' => '/admin/impresoras/nuevo',
                'icono' => 'pi pi-plus',
                'modulo' => 'Impresoras',
                'orden' => 2,
                'es_menu' => true,
                'parent_id' => $impresorasId
            ],
            [
                'nombre' => 'Tipos de Impresora',
                'ruta' => '/admin/tipos-impresora/listar',
                'icono' => 'pi pi-th-large',
                'modulo' => 'Impresoras',
                'orden' => 3,
                'es_menu' => true,
                'parent_id' => $impresorasId
            ],
            [
                'nombre' => 'Tipos de Insumo',
                'ruta' => '/admin/tipos-insumo/listar',
                'icono' => 'pi pi-th-large',
                'modulo' => 'Impresoras',
                'orden' => 4,
                'es_menu' => true,
                'parent_id' => $impresorasId
            ],

            // Hijos de Unidades
            [
                'nombre' => 'Lista de Unidades',
                'ruta' => '/admin/unidades/listar',
                'icono' => 'pi pi-list',
                'modulo' => 'Unidades',
                'orden' => 1,
                'es_menu' => true,
                'parent_id' => $unidadesId
            ],
            [
                'nombre' => 'Tipos de Unidad',
                'ruta' => '/admin/tipos-unidad/listar',
                'icono' => 'pi pi-th-large',
                'modulo' => 'Unidades',
                'orden' => 2,
                'es_menu' => true,
                'parent_id' => $unidadesId
            ],

            // Hijos de Consultas
            [
                'nombre' => 'Consulta Computadoras',
                'ruta' => '/admin/computadoras-detalle',
                'icono' => 'pi pi-desktop',
                'modulo' => 'Consultas',
                'orden' => 1,
                'es_menu' => true,
                'parent_id' => $consultasId
            ],
            [
                'nombre' => 'Consulta Impresoras',
                'ruta' => '/admin/impresoras-detalle',
                'icono' => 'pi pi-print',
                'modulo' => 'Consultas',
                'orden' => 2,
                'es_menu' => true,
                'parent_id' => $consultasId
            ],

            // Hijos de Reportes
            [
                'nombre' => 'Reportes Generales',
                'ruta' => '/admin/reportes',
                'icono' => 'pi pi-file',
                'modulo' => 'Reportes',
                'orden' => 1,
                'es_menu' => true,
                'parent_id' => $reportesId
            ],
        ];

        foreach ($vistasHijas as $vista) {
            DB::table('vistas_sistema')->insert(array_merge($vista, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}
