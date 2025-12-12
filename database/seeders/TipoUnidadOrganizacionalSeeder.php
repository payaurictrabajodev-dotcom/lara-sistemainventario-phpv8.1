<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TipoUnidadOrganizacionalSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('tipos_unidad_organizacional')->insert([
            ['nombre' => 'Municipalidad', 'descripcion' => 'Entidad municipal principal', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Gerencia Municipal', 'descripcion' => 'Gerencia de nivel municipal', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Gerencia', 'descripcion' => 'Gerencia general', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Sub Gerencia', 'descripcion' => 'Sub gerencia dependiente', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Oficina', 'descripcion' => 'Oficina administrativa', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Departamento', 'descripcion' => 'Departamento operativo', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Área', 'descripcion' => 'Área funcional', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Equipo', 'descripcion' => 'Equipo de trabajo', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Unidad', 'descripcion' => 'Unidad operativa', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
