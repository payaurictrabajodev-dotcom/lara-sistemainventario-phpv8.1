<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ResponsablesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $responsables = [
            ['dni' => '12345678', 'nombre_completo' => 'Juan Carlos Pérez Rodríguez', 'grado_academico' => 'Ingeniero de Sistemas', 'cargo' => 'Jefe de TI', 'telefono' => '987654321', 'email' => 'jperez@institucion.gob.pe', 'created_at' => $now, 'updated_at' => $now],
            ['dni' => '23456789', 'nombre_completo' => 'María Elena García Flores', 'grado_academico' => 'Licenciada en Administración', 'cargo' => 'Coordinadora Administrativa', 'telefono' => '987654322', 'email' => 'mgarcia@institucion.gob.pe', 'created_at' => $now, 'updated_at' => $now],
            ['dni' => '34567890', 'nombre_completo' => 'Carlos Alberto Ramírez Sánchez', 'grado_academico' => 'Técnico en Informática', 'cargo' => 'Analista de Soporte', 'telefono' => '987654323', 'email' => 'cramirez@institucion.gob.pe', 'created_at' => $now, 'updated_at' => $now],
            ['dni' => '45678901', 'nombre_completo' => 'Ana Lucía Torres Mendoza', 'grado_academico' => 'Contadora Pública', 'cargo' => 'Jefa de Contabilidad', 'telefono' => '987654324', 'email' => 'atorres@institucion.gob.pe', 'created_at' => $now, 'updated_at' => $now],
            ['dni' => '56789012', 'nombre_completo' => 'Roberto Miguel Vásquez Castro', 'grado_academico' => 'Ingeniero Civil', 'cargo' => 'Jefe de Logística', 'telefono' => '987654325', 'email' => 'rvasquez@institucion.gob.pe', 'created_at' => $now, 'updated_at' => $now],
            ['dni' => '67890123', 'nombre_completo' => 'Patricia Isabel Morales Díaz', 'grado_academico' => 'Abogada', 'cargo' => 'Asesora Legal', 'telefono' => '987654326', 'email' => 'pmorales@institucion.gob.pe', 'created_at' => $now, 'updated_at' => $now],
            ['dni' => '78901234', 'nombre_completo' => 'Luis Fernando Chávez Rojas', 'grado_academico' => 'Bachiller en Economía', 'cargo' => 'Analista Económico', 'telefono' => '987654327', 'email' => 'lchavez@institucion.gob.pe', 'created_at' => $now, 'updated_at' => $now],
            ['dni' => '89012345', 'nombre_completo' => 'Carmen Rosa Delgado Paredes', 'grado_academico' => 'Licenciada en Educación', 'cargo' => 'Coordinadora de Capacitación', 'telefono' => '987654328', 'email' => 'cdelgado@institucion.gob.pe', 'created_at' => $now, 'updated_at' => $now],
        ];
        
        DB::table('responsables')->insert($responsables);
    }
}
