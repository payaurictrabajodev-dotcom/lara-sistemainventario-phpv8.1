<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoComponente;

class TipoComponenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'MONITOR', 'descripcion' => 'Pantallas y monitores'],
            ['nombre' => 'CAÑON MULTIMEDIA', 'descripcion' => 'Proyectores y cañones multimedia'],
            ['nombre' => 'TECLADO', 'descripcion' => 'Teclados'],
            ['nombre' => 'MOUSE', 'descripcion' => 'Mouse y dispositivos señaladores'],
            ['nombre' => 'ESTABILIZADOR', 'descripcion' => 'Estabilizadores de voltaje'],
            ['nombre' => 'IMPRESORA', 'descripcion' => 'Impresoras y multifuncionales'],
            ['nombre' => 'PARLANTES', 'descripcion' => 'Altavoces y sistemas de audio'],
            ['nombre' => 'WEBCAM', 'descripcion' => 'Cámaras web'],
            ['nombre' => 'UPS', 'descripcion' => 'Sistemas de alimentación ininterrumpida'],
            ['nombre' => 'SCANNER', 'descripcion' => 'Escáneres'],
            ['nombre' => 'OTROS', 'descripcion' => 'Otros componentes'],
        ];

        foreach ($tipos as $tipo) {
            TipoComponente::create($tipo);
        }
    }
}
