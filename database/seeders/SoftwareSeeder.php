<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SoftwareSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de categorías
        $catSO = DB::table('categorias_software')->where('nombre', 'SISTEMA OPERATIVO')->value('id');
        $catOfim = DB::table('categorias_software')->where('nombre', 'SISTEMA OFIMATICO')->value('id');
        $catDiseno = DB::table('categorias_software')->where('nombre', 'PROGRAMAS DE DISEÑO')->value('id');
        $catIngenieria = DB::table('categorias_software')->where('nombre', 'PROGRAMAS DE INGENIERIA')->value('id');
        $catQuemador = DB::table('categorias_software')->where('nombre', 'QUEMADOR')->value('id');
        $catPDF = DB::table('categorias_software')->where('nombre', 'PDF')->value('id');
        $catNavegador = DB::table('categorias_software')->where('nombre', 'NAVEGADOR WEB')->value('id');
        $catCompresor = DB::table('categorias_software')->where('nombre', 'COMPRESORES')->value('id');
        $catVideo = DB::table('categorias_software')->where('nombre', 'PROGRAMAS DE VIDEO')->value('id');
        $catAudio = DB::table('categorias_software')->where('nombre', 'PROGRAMAS DE AUDIO')->value('id');
        $catLimpieza = DB::table('categorias_software')->where('nombre', 'UTILITARIOS DE LIMPIEZA')->value('id');
        $catAntivirus = DB::table('categorias_software')->where('nombre', 'ANTIVIRUS')->value('id');
        $catMensajero = DB::table('categorias_software')->where('nombre', 'LAN MESSENGER')->value('id');
        
        $now = Carbon::now();
        
        // Datos reales basados en la imagen 1
        $software = [
            // SISTEMA OPERATIVO
            ['categoria_software_id' => $catSO, 'nombre_programa' => 'Windows 10', 'version' => '64-bit', 'licencia' => 'No', 'created_at' => $now, 'updated_at' => $now],
            ['categoria_software_id' => $catSO, 'nombre_programa' => 'Windows 7', 'version' => 'Professional', 'licencia' => 'Sí', 'created_at' => $now, 'updated_at' => $now],
            ['categoria_software_id' => $catSO, 'nombre_programa' => 'Windows 8', 'version' => '64-bit', 'licencia' => 'Sí', 'created_at' => $now, 'updated_at' => $now],
            
            // SISTEMA OFIMATICO
            ['categoria_software_id' => $catOfim, 'nombre_programa' => 'Microsoft Office Pro-2019', 'version' => '15', 'licencia' => 'No', 'created_at' => $now, 'updated_at' => $now],
            ['categoria_software_id' => $catOfim, 'nombre_programa' => 'LibreOffice', 'version' => '6.0', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            
            // QUEMADOR
            ['categoria_software_id' => $catQuemador, 'nombre_programa' => 'BurnAware Professional', 'version' => '8.4', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            ['categoria_software_id' => $catQuemador, 'nombre_programa' => 'Nero Burning ROM', 'version' => '12', 'licencia' => 'Comercial', 'created_at' => $now, 'updated_at' => $now],
            
            // PDF
            ['categoria_software_id' => $catPDF, 'nombre_programa' => 'Adobe Reader XI', 'version' => '11', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            ['categoria_software_id' => $catPDF, 'nombre_programa' => 'Foxit Reader', 'version' => '9.0', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            
            // NAVEGADOR WEB
            ['categoria_software_id' => $catNavegador, 'nombre_programa' => 'Google Chrome', 'version' => '58', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            ['categoria_software_id' => $catNavegador, 'nombre_programa' => 'Mozilla Firefox', 'version' => '52', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            ['categoria_software_id' => $catNavegador, 'nombre_programa' => 'Internet Explorer', 'version' => '11', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            
            // COMPRESORES
            ['categoria_software_id' => $catCompresor, 'nombre_programa' => 'WinRAR', 'version' => '5.2', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            ['categoria_software_id' => $catCompresor, 'nombre_programa' => '7-Zip', 'version' => '16.04', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            
            // PROGRAMAS DE VIDEO
            ['categoria_software_id' => $catVideo, 'nombre_programa' => 'VLC Media Player', 'version' => '2.2', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            
            // UTILITARIOS DE LIMPIEZA
            ['categoria_software_id' => $catLimpieza, 'nombre_programa' => 'Advanced SystemCare', 'version' => '9', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            ['categoria_software_id' => $catLimpieza, 'nombre_programa' => 'CCleaner', 'version' => '5.0', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            
            // ANTIVIRUS
            ['categoria_software_id' => $catAntivirus, 'nombre_programa' => 'ESET Smart Security', 'version' => '14', 'licencia' => 'Si', 'created_at' => $now, 'updated_at' => $now],
            ['categoria_software_id' => $catAntivirus, 'nombre_programa' => 'Kaspersky', 'version' => '16', 'licencia' => 'Comercial', 'created_at' => $now, 'updated_at' => $now],
            
            // LAN MESSENGER
            ['categoria_software_id' => $catMensajero, 'nombre_programa' => 'Comunicador Local', 'version' => '1.2', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
            ['categoria_software_id' => $catMensajero, 'nombre_programa' => 'Skype', 'version' => '7.0', 'licencia' => 'Free', 'created_at' => $now, 'updated_at' => $now],
        ];
        
        DB::table('software')->insert($software);
    }
}
