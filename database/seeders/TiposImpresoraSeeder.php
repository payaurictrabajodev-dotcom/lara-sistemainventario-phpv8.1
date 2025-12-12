<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TiposImpresoraSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('tipos_impresora')->insert([
            ['nombre' => 'Láser', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Inyección', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Multifuncional', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
