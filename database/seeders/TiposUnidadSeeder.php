<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TiposUnidadSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('tipos_unidad_organizacional')->insert([
            ['nombre' => 'Agencia', 'descripcion' => 'Agencia local', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Oficina', 'descripcion' => 'Oficina central', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
