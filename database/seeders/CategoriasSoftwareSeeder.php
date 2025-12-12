<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSoftwareSeeder extends Seeder
{
    public function run(): void
    {
        // Categorías basadas en la imagen 1 (columna SOFTWARE Y UTILITARIOS)
        $categorias = [
            ['nombre' => 'SISTEMA OPERATIVO', 'descripcion' => 'Sistemas operativos', 'orden' => 1],
            ['nombre' => 'SISTEMA OFIMATICO', 'descripcion' => 'Suites ofimáticas', 'orden' => 2],
            ['nombre' => 'PROGRAMAS DE DISEÑO', 'descripcion' => 'Software de diseño gráfico', 'orden' => 3],
            ['nombre' => 'PROGRAMAS DE INGENIERIA', 'descripcion' => 'Software de ingeniería y CAD', 'orden' => 4],
            ['nombre' => 'QUEMADOR', 'descripcion' => 'Software para grabación de discos', 'orden' => 5],
            ['nombre' => 'PDF', 'descripcion' => 'Lectores y editores PDF', 'orden' => 6],
            ['nombre' => 'NAVEGADOR WEB', 'descripcion' => 'Navegadores de internet', 'orden' => 7],
            ['nombre' => 'COMPRESORES', 'descripcion' => 'Software de compresión', 'orden' => 8],
            ['nombre' => 'PROGRAMAS DE VIDEO', 'descripcion' => 'Reproductores y editores de video', 'orden' => 9],
            ['nombre' => 'PROGRAMAS DE AUDIO', 'descripcion' => 'Reproductores y editores de audio', 'orden' => 10],
            ['nombre' => 'UTILITARIOS DE LIMPIEZA', 'descripcion' => 'Herramientas de mantenimiento', 'orden' => 11],
            ['nombre' => 'ANTIVIRUS', 'descripcion' => 'Software de seguridad', 'orden' => 12],
            ['nombre' => 'LAN MESSENGER', 'descripcion' => 'Mensajería instantánea', 'orden' => 13],
            ['nombre' => 'UTILITARIOS', 'descripcion' => 'Utilidades generales', 'orden' => 14],
        ];

        DB::table('categorias_software')->insert($categorias);
    }
}
