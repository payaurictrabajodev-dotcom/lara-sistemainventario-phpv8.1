<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ImpresorasSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $unidadId = DB::table('unidades_organizacionales')->where('nombre', 'Oficina Central')->value('id')
            ?? DB::table('unidades_organizacionales')->value('id');

        $tipoImpresoraId = DB::table('tipos_impresora')->where('nombre', 'Láser')->value('id')
            ?? DB::table('tipos_impresora')->value('id');

        $tipoInsumoId = DB::table('tipos_insumo')->where('nombre', 'Tóner')->value('id')
            ?? DB::table('tipos_insumo')->value('id');

        $usuarioId = DB::table('users')->where('email', 'admin@example.com')->value('id')
            ?? DB::table('users')->where('name', 'Administrador Demo')->value('id');

        DB::table('impresoras')->updateOrInsert(
            ['codigo_patrimonial' => 'IMP-0001'],
            [
                'unidad_organizacional_id' => $unidadId,
                'tipo_impresora_id' => $tipoImpresoraId,
                'tipo_insumo_id' => $tipoInsumoId,
                'marca' => 'HP',
                'modelo' => 'LaserJet Demo',
                'numero_serie' => 'IMP-DEMO-001',
                'codigo_patrimonial' => 'IMP-0001',
                'direccion_ip' => '192.168.1.100',
                'estado' => 'Operativo',
                'usuario_id' => $usuarioId,
                'observaciones' => 'Impresora de ejemplo',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}
