<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TipoHardwareSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $tipos = [
            ['nombre' => 'CASE', 'descripcion' => 'Gabinete o caja del equipo', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'MOTHERBOARD', 'descripcion' => 'Tarjeta madre o placa base', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'PROCESADOR', 'descripcion' => 'CPU - Unidad central de procesamiento', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'DISCO DURO', 'descripcion' => 'Unidad de almacenamiento HDD/SSD', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'MEMORIA RAM', 'descripcion' => 'Memoria de acceso aleatorio', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'UNIDAD OPTICA', 'descripcion' => 'Lectora/grabadora de CD/DVD', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'TARJETA DE RED', 'descripcion' => 'Adaptador de red Ethernet', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'TARJETA DE VIDEO', 'descripcion' => 'Tarjeta gráfica GPU', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'TARJETA DE AUDIO', 'descripcion' => 'Tarjeta de sonido', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'TARJETA RED WIFI', 'descripcion' => 'Adaptador de red inalámbrica', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('tipos_hardware')->insert($tipos);
    }
}
