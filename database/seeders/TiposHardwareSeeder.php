<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposHardwareSeeder extends Seeder
{
    public function run(): void
    {
        $tiposHardware = [
            // COMPONENTES INTERNOS (según imagen 1)
            ['nombre' => 'CASE', 'categoria' => 'Componente', 'descripcion' => 'Gabinete del equipo', 'orden' => 1],
            ['nombre' => 'MOTHERBOARD', 'categoria' => 'Componente', 'descripcion' => 'Placa madre', 'orden' => 2],
            ['nombre' => 'PROCESADOR', 'categoria' => 'Componente', 'descripcion' => 'Unidad central de procesamiento', 'orden' => 3],
            ['nombre' => 'DISCO DURO', 'categoria' => 'Componente', 'descripcion' => 'Almacenamiento principal', 'orden' => 4],
            ['nombre' => 'MEMORIA RAM', 'categoria' => 'Componente', 'descripcion' => 'Memoria RAM', 'orden' => 5],
            ['nombre' => 'UNIDADES OPTICAS', 'categoria' => 'Componente', 'descripcion' => 'DVD, CD, Blu-ray', 'orden' => 6],
            ['nombre' => 'TARJETA DE RED', 'categoria' => 'Componente', 'descripcion' => 'Controlador de red', 'orden' => 7],
            ['nombre' => 'TARJETA DE VIDEO', 'categoria' => 'Componente', 'descripcion' => 'Tarjeta gráfica', 'orden' => 8],
            ['nombre' => 'TARJETA DE AUDIO', 'categoria' => 'Componente', 'descripcion' => 'Tarjeta de sonido', 'orden' => 9],
            ['nombre' => 'TARJETA RED WIFI', 'categoria' => 'Componente', 'descripcion' => 'Adaptador inalámbrico', 'orden' => 10],
            ['nombre' => 'OTROS', 'categoria' => 'Componente', 'descripcion' => 'Otros componentes', 'orden' => 11],
        ];

        DB::table('tipos_hardware')->insert($tiposHardware);
    }
}
