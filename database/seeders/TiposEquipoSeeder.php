<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TiposEquipoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('tipos_equipo')->insert([
            ['nombre' => 'Computadora', 'descripcion' => 'Equipo de escritorio', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Laptop', 'descripcion' => 'Equipo portátil', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Servidor', 'descripcion' => 'Servidor de red', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
