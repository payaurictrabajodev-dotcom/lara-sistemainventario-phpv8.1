<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UnidadesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        // lookup tipos_unidad ids by name
        $agenciaTipoId = DB::table('tipos_unidad_organizacional')->where('nombre', 'Agencia')->value('id');
        $oficinaTipoId = DB::table('tipos_unidad_organizacional')->where('nombre', 'Oficina')->value('id');

        DB::table('unidades_organizacionales')->updateOrInsert(
            ['nombre' => 'Agencia Tacna'],
            ['tipo_unidad_id' => $agenciaTipoId, 'codigo' => 'AG-TAC', 'descripcion' => 'Agencia regional Tacna', 'created_at' => $now, 'updated_at' => $now]
        );

        DB::table('unidades_organizacionales')->updateOrInsert(
            ['nombre' => 'Oficina Central'],
            ['tipo_unidad_id' => $oficinaTipoId, 'codigo' => 'OF-CEN', 'descripcion' => 'Oficina principal', 'created_at' => $now, 'updated_at' => $now]
        );
    }
}
