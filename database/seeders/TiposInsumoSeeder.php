<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TiposInsumoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('tipos_insumo')->insert([
            ['nombre' => 'Tóner', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Cartucho', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
