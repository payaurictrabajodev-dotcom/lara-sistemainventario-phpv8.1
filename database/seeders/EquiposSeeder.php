<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EquiposSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Resolve foreign keys by unique names when possible
        $unidadId = DB::table('unidades_organizacionales')->where('nombre', 'Agencia Demo')->value('id')
            ?? DB::table('unidades_organizacionales')->where('nombre', 'Agencia Tacna')->value('id')
            ?? DB::table('unidades_organizacionales')->value('id');

        $tipoEquipoId = DB::table('tipos_equipo')->where('nombre', 'Laptop')->value('id')
            ?? DB::table('tipos_equipo')->value('id');

        // Obtener un usuario para asignar como responsable
        $usuarioId = DB::table('users')->where('email', 'admin@example.com')->value('id')
            ?? DB::table('users')->value('id');

        // Crear equipo de ejemplo
        $equipoId = DB::table('equipos')->insertGetId([
            'codigo_patrimonial' => 'INV-0001',
            'unidad_organizacional_id' => $unidadId,
            'tipo_equipo_id' => $tipoEquipoId,
            'usuario_id' => $usuarioId,
            'numero_serie' => 'SN-DEMO-001',
            'marca' => 'HP',
            'modelo' => 'EliteBook 840 G5',
            'direccion_ip' => '192.168.1.50',
            'fecha_compra' => $now->subMonths(6),
            'fecha_fabricacion' => $now->subYears(2),
            'fecha_asignacion' => $now->subMonths(3),
            'estado' => 'Operativo',
            'observaciones' => 'Equipo de ejemplo con componentes de hardware',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Asignar hardware al equipo (procesador, RAM, disco, etc)
        $hardwareAsignado = [
            // Procesador Intel Core i5
            DB::table('hardware')->where('marca', 'Intel')->where('modelo', 'Core i5-8250U')->value('id'),
            // RAM 8GB DDR4
            DB::table('hardware')->where('marca', 'Kingston')->where('modelo', '8GB DDR4 2400MHz')->value('id'),
            // Disco SSD 256GB
            DB::table('hardware')->where('marca', 'Samsung')->where('modelo', '860 EVO 256GB')->value('id'),
            // Tarjeta de video integrada
            DB::table('hardware')->where('marca', 'Intel')->where('modelo', 'HD Graphics 620')->value('id'),
        ];

        foreach (array_filter($hardwareAsignado) as $hardwareId) {
            DB::table('equipo_hardware')->insert([
                'equipo_id' => $equipoId,
                'hardware_id' => $hardwareId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
