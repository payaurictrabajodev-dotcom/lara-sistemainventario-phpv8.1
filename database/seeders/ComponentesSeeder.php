<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\TipoComponente;

class ComponentesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Obtener usuario admin
        $usuarioId = DB::table('users')->where('email', 'admin@example.com')->value('id')
            ?? DB::table('users')->value('id');

        // Obtener IDs de tipos de componentes
        $tipoMonitor = TipoComponente::where('nombre', 'MONITOR')->first()->id;
        $tipoTeclado = TipoComponente::where('nombre', 'TECLADO')->first()->id;
        $tipoMouse = TipoComponente::where('nombre', 'MOUSE')->first()->id;
        $tipoEstabilizador = TipoComponente::where('nombre', 'ESTABILIZADOR')->first()->id;
        $tipoParlantes = TipoComponente::where('nombre', 'PARLANTES')->first()->id;
        $tipoWebcam = TipoComponente::where('nombre', 'WEBCAM')->first()->id;
        DB::table('componentes')->insert([
            // Monitores
            [
                'codigo_patrimonial' => 'COMP-MON-001',
                'nombre' => 'Monitor Dell P2422H',
                'tipo_componente_id' => $tipoMonitor,
                'marca' => 'Dell',
                'modelo' => 'P2422H',
                'especificaciones' => '24 pulgadas, Full HD 1920x1080, IPS',
                'numero_serie' => 'MON-DELL-001',
                'estado' => 'Disponible',
                'unidad_organizacional_id' => 1,
                'usuario_id' => $usuarioId,
                'usuario_id' => $usuarioId,
                'observaciones' => 'Monitor para oficina',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo_patrimonial' => 'COMP-MON-002',
                'nombre' => 'Monitor LG 27UL500',
                'tipo_componente_id' => $tipoMonitor,
                'marca' => 'LG',
                'modelo' => '27UL500',
                'especificaciones' => '27 pulgadas, 4K UHD, IPS',
                'numero_serie' => 'MON-LG-002',
                'estado' => 'En Uso',
                'unidad_organizacional_id' => 1,
                'usuario_id' => $usuarioId,
                'observaciones' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo_patrimonial' => 'COMP-MON-003',
                'nombre' => 'Monitor HP E24 G4',
                'tipo_componente_id' => $tipoMonitor,
                'marca' => 'HP',
                'modelo' => 'E24 G4',
                'especificaciones' => '24 pulgadas, Full HD, Ajustable',
                'numero_serie' => 'MON-HP-003',
                'estado' => 'Disponible',
                'unidad_organizacional_id' => 1,
                'usuario_id' => $usuarioId,
                'observaciones' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Teclados
            [
                'codigo_patrimonial' => 'COMP-TEC-001',
                'nombre' => 'Teclado Logitech K120',
                'tipo_componente_id' => $tipoTeclado,
                'marca' => 'Logitech',
                'modelo' => 'K120',
                'especificaciones' => 'USB, Español, Resistente a salpicaduras',
                'numero_serie' => 'TEC-LOG-001',
                'estado' => 'Disponible',
                'unidad_organizacional_id' => 1,
                'usuario_id' => $usuarioId,
                'observaciones' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo_patrimonial' => 'COMP-TEC-002',
                'nombre' => 'Teclado HP Wireless',
                'tipo_componente_id' => $tipoTeclado,
                'marca' => 'HP',
                'modelo' => 'Wireless 600',
                'especificaciones' => 'Inalámbrico 2.4GHz, Español',
                'numero_serie' => 'TEC-HP-002',
                'estado' => 'En Uso',
                'unidad_organizacional_id' => 1,
                'usuario_id' => $usuarioId,
                'observaciones' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Mouse
            [
                'codigo_patrimonial' => 'COMP-MOU-001',
                'nombre' => 'Mouse Logitech M170',
                'tipo_componente_id' => $tipoMouse,
                'marca' => 'Logitech',
                'modelo' => 'M170',
                'especificaciones' => 'Inalámbrico, Óptico, 1000 DPI',
                'numero_serie' => 'MOU-LOG-001',
                'estado' => 'Disponible',
                'unidad_organizacional_id' => 1,
                'usuario_id' => $usuarioId,
                'observaciones' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo_patrimonial' => 'COMP-MOU-002',
                'nombre' => 'Mouse HP X3000',
                'tipo_componente_id' => $tipoMouse,
                'marca' => 'HP',
                'modelo' => 'X3000',
                'especificaciones' => 'Inalámbrico, Ambidiestro',
                'numero_serie' => 'MOU-HP-002',
                'estado' => 'En Uso',
                'unidad_organizacional_id' => 1,
                'usuario_id' => $usuarioId,
                'observaciones' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}


