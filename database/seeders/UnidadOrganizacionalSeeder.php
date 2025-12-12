<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UnidadOrganizacionalSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        // Nivel 1: Municipalidad (raíz)
        $municipalidadId = DB::table('unidades_organizacionales')->insertGetId([
            'tipo_unidad_id' => 1, // Municipalidad
            'parent_id' => null,
            'nombre' => 'Municipalidad Provincial de Tacna',
            'codigo' => 'MPT',
            'descripcion' => 'Gobierno local de la provincia de Tacna',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Nivel 2: Gerencia Municipal
        $gerenciaMunicipalId = DB::table('unidades_organizacionales')->insertGetId([
            'tipo_unidad_id' => 2, // Gerencia Municipal
            'parent_id' => $municipalidadId,
            'nombre' => 'Gerencia Municipal',
            'codigo' => 'GM',
            'descripcion' => 'Gerencia Municipal Principal',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Nivel 2: Gerencias principales
        $gerenciaGeneralId = DB::table('unidades_organizacionales')->insertGetId([
            'tipo_unidad_id' => 3, // Gerencia
            'parent_id' => $municipalidadId,
            'nombre' => 'Gerencia General',
            'codigo' => 'GG',
            'descripcion' => 'Gerencia General de la Municipalidad',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $gerenciaAdminId = DB::table('unidades_organizacionales')->insertGetId([
            'tipo_unidad_id' => 3, // Gerencia
            'parent_id' => $municipalidadId,
            'nombre' => 'Gerencia de Administración',
            'codigo' => 'GA',
            'descripcion' => 'Gerencia de Administración y Finanzas',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $gerenciaDesarrolloId = DB::table('unidades_organizacionales')->insertGetId([
            'tipo_unidad_id' => 3, // Gerencia
            'parent_id' => $municipalidadId,
            'nombre' => 'Gerencia de Desarrollo Urbano',
            'codigo' => 'GDU',
            'descripcion' => 'Gerencia de Desarrollo Urbano y Rural',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Nivel 3: Sub Gerencias bajo Gerencia General
        $subGerenciaTIId = DB::table('unidades_organizacionales')->insertGetId([
            'tipo_unidad_id' => 4, // Sub Gerencia
            'parent_id' => $gerenciaGeneralId,
            'nombre' => 'Sub Gerencia de Tecnologías de Información y Telecomunicaciones',
            'codigo' => 'SGTI',
            'descripcion' => 'Gestión de tecnologías de información',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $subGerenciaRRHHId = DB::table('unidades_organizacionales')->insertGetId([
            'tipo_unidad_id' => 4, // Sub Gerencia
            'parent_id' => $gerenciaAdminId,
            'nombre' => 'Sub Gerencia de Recursos Humanos',
            'codigo' => 'SGRH',
            'descripcion' => 'Gestión del talento humano',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $subGerenciaMAId = DB::table('unidades_organizacionales')->insertGetId([
            'tipo_unidad_id' => 4, // Sub Gerencia
            'parent_id' => $gerenciaDesarrolloId,
            'nombre' => 'Sub Gerencia de Medio Ambiente',
            'codigo' => 'SGMA',
            'descripcion' => 'Gestión ambiental y sostenibilidad',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $subGerenciaLogisticaId = DB::table('unidades_organizacionales')->insertGetId([
            'tipo_unidad_id' => 4, // Sub Gerencia
            'parent_id' => $gerenciaAdminId,
            'nombre' => 'Sub Gerencia de Logística',
            'codigo' => 'SGL',
            'descripcion' => 'Gestión de compras y abastecimiento',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Nivel 4: Oficinas
        DB::table('unidades_organizacionales')->insert([
            [
                'tipo_unidad_id' => 5, // Oficina
                'parent_id' => $municipalidadId,
                'nombre' => 'Mesa de Partes',
                'codigo' => 'MP',
                'descripcion' => 'Oficina de trámite documentario',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'tipo_unidad_id' => 5, // Oficina
                'parent_id' => $subGerenciaTIId,
                'nombre' => 'Oficina de Soporte Técnico',
                'codigo' => 'OST',
                'descripcion' => 'Soporte técnico informático',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'tipo_unidad_id' => 5, // Oficina
                'parent_id' => $subGerenciaTIId,
                'nombre' => 'Oficina de Desarrollo de Sistemas',
                'codigo' => 'ODS',
                'descripcion' => 'Desarrollo y mantenimiento de sistemas',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'tipo_unidad_id' => 5, // Oficina
                'parent_id' => $subGerenciaRRHHId,
                'nombre' => 'Oficina de Planillas',
                'codigo' => 'OP',
                'descripcion' => 'Gestión de planillas y remuneraciones',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);

        // Nivel 5: Áreas y Equipos
        $oficinaSTId = DB::getPdo()->lastInsertId() - 2; // Oficina de Soporte Técnico

        DB::table('unidades_organizacionales')->insert([
            [
                'tipo_unidad_id' => 7, // Área
                'parent_id' => $oficinaSTId,
                'nombre' => 'Área de Redes',
                'codigo' => 'AR',
                'descripcion' => 'Gestión de infraestructura de redes',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'tipo_unidad_id' => 8, // Equipo
                'parent_id' => $oficinaSTId,
                'nombre' => 'Equipo de Mantenimiento',
                'codigo' => 'EM',
                'descripcion' => 'Equipo de mantenimiento preventivo y correctivo',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
