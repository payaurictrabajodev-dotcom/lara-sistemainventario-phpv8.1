<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HardwareSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de tipos de hardware
        $tipoCase = DB::table('tipos_hardware')->where('nombre', 'CASE')->value('id');
        $tipoMotherboard = DB::table('tipos_hardware')->where('nombre', 'MOTHERBOARD')->value('id');
        $tipoProcesador = DB::table('tipos_hardware')->where('nombre', 'PROCESADOR')->value('id');
        $tipoDisco = DB::table('tipos_hardware')->where('nombre', 'DISCO DURO')->value('id');
        $tipoRam = DB::table('tipos_hardware')->where('nombre', 'MEMORIA RAM')->value('id');
        $tipoUnidadOptica = DB::table('tipos_hardware')->where('nombre', 'UNIDAD OPTICA')->value('id');
        $tipoTarjetaRed = DB::table('tipos_hardware')->where('nombre', 'TARJETA DE RED')->value('id');
        $tipoTarjetaVideo = DB::table('tipos_hardware')->where('nombre', 'TARJETA DE VIDEO')->value('id');
        $tipoTarjetaAudio = DB::table('tipos_hardware')->where('nombre', 'TARJETA DE AUDIO')->value('id');
        $tipoTarjetaWifi = DB::table('tipos_hardware')->where('nombre', 'TARJETA RED WIFI')->value('id');

        $now = Carbon::now();

        $hardware = [
            // ========== COMPONENTES INTERNOS ==========

            // CASES
            ['tipo_hardware_id' => $tipoCase, 'codigo_inventario' => null, 'nombre_periferico' => 'Case ATX', 'marca' => 'Sentey', 'modelo' => 'ATX Mid Tower', 'especificaciones' => 'Gabinete ATX Negro con fuente 500W', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoCase, 'codigo_inventario' => null, 'nombre_periferico' => 'Case Mini Tower', 'marca' => 'Generic', 'modelo' => 'Mini Tower', 'especificaciones' => 'Gabinete compacto con fuente 300W', 'created_at' => $now, 'updated_at' => $now],

            // MOTHERBOARDS
            ['tipo_hardware_id' => $tipoMotherboard, 'codigo_inventario' => null, 'nombre_periferico' => 'Motherboard H61', 'marca' => 'ASUS', 'modelo' => 'H61M-E', 'especificaciones' => 'Socket LGA1155, DDR3, 2 slots RAM', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoMotherboard, 'codigo_inventario' => null, 'nombre_periferico' => 'Motherboard B450', 'marca' => 'MSI', 'modelo' => 'B450M PRO-M2', 'especificaciones' => 'Socket AM4, DDR4, 4 slots RAM', 'created_at' => $now, 'updated_at' => $now],

            // PROCESADORES
            ['tipo_hardware_id' => $tipoProcesador, 'codigo_inventario' => null, 'nombre_periferico' => 'Intel Core i3', 'marca' => 'Intel', 'modelo' => 'Core i3-3220', 'especificaciones' => '3.30 GHz, 2 cores, 4 threads', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoProcesador, 'codigo_inventario' => null, 'nombre_periferico' => 'Intel Core i5', 'marca' => 'Intel', 'modelo' => 'Core i5-3470', 'especificaciones' => '3.20 GHz, 4 cores, 4 threads', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoProcesador, 'codigo_inventario' => null, 'nombre_periferico' => 'Intel Core 2 Duo', 'marca' => 'Intel', 'modelo' => 'Core 2 Duo E7500', 'especificaciones' => '2.93 GHz, 2 cores', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoProcesador, 'codigo_inventario' => null, 'nombre_periferico' => 'Intel Core i7', 'marca' => 'Intel', 'modelo' => 'Core i7-3770', 'especificaciones' => '3.40 GHz, 4 cores, 8 threads', 'created_at' => $now, 'updated_at' => $now],

            // DISCOS DUROS
            ['tipo_hardware_id' => $tipoDisco, 'codigo_inventario' => null, 'nombre_periferico' => 'Disco Duro 500GB', 'marca' => 'Seagate', 'modelo' => 'Barracuda', 'especificaciones' => '500GB SATA 7200RPM', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoDisco, 'codigo_inventario' => null, 'nombre_periferico' => 'SSD 240GB', 'marca' => 'Kingston', 'modelo' => 'A400', 'especificaciones' => '240GB SATA III SSD', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoDisco, 'codigo_inventario' => null, 'nombre_periferico' => 'Disco Duro 1TB', 'marca' => 'Western Digital', 'modelo' => 'Blue', 'especificaciones' => '1TB SATA 7200RPM', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoDisco, 'codigo_inventario' => null, 'nombre_periferico' => 'SSD 480GB', 'marca' => 'Crucial', 'modelo' => 'BX500', 'especificaciones' => '480GB SATA III SSD', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoDisco, 'codigo_inventario' => null, 'nombre_periferico' => 'Disco Duro 160GB', 'marca' => 'Seagate', 'modelo' => 'Barracuda', 'especificaciones' => '160GB SATA 7200RPM', 'created_at' => $now, 'updated_at' => $now],

            // MEMORIAS RAM
            ['tipo_hardware_id' => $tipoRam, 'codigo_inventario' => null, 'nombre_periferico' => 'RAM 4GB DDR3', 'marca' => 'Kingston', 'modelo' => 'DDR3', 'especificaciones' => '4GB DDR3 1600MHz', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoRam, 'codigo_inventario' => null, 'nombre_periferico' => 'RAM 8GB DDR3', 'marca' => 'Corsair', 'modelo' => 'Vengeance', 'especificaciones' => '8GB DDR3 1600MHz', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoRam, 'codigo_inventario' => null, 'nombre_periferico' => 'RAM 16GB DDR4', 'marca' => 'ASUS', 'modelo' => 'ROG', 'especificaciones' => '16GB DDR4 3200MHz Dual Channel', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoRam, 'codigo_inventario' => null, 'nombre_periferico' => 'RAM 2GB DDR2', 'marca' => 'Kingston', 'modelo' => 'DDR2', 'especificaciones' => '2GB DDR2 800MHz', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoRam, 'codigo_inventario' => null, 'nombre_periferico' => 'RAM 4GB DDR2', 'marca' => 'Generic', 'modelo' => 'DDR2', 'especificaciones' => '4GB DDR2 800MHz (2x2GB)', 'created_at' => $now, 'updated_at' => $now],

            // UNIDADES ÓPTICAS
            ['tipo_hardware_id' => $tipoUnidadOptica, 'codigo_inventario' => null, 'nombre_periferico' => 'DVD-RW', 'marca' => 'LG', 'modelo' => 'GH24', 'especificaciones' => 'Grabadora DVD-RW SATA', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoUnidadOptica, 'codigo_inventario' => null, 'nombre_periferico' => 'DVD-ROM', 'marca' => 'Samsung', 'modelo' => 'SH-D162', 'especificaciones' => 'Lectora DVD-ROM SATA', 'created_at' => $now, 'updated_at' => $now],

            // TARJETAS DE RED
            ['tipo_hardware_id' => $tipoTarjetaRed, 'codigo_inventario' => null, 'nombre_periferico' => 'Tarjeta Red Ethernet', 'marca' => 'Realtek', 'modelo' => 'RTL8111', 'especificaciones' => 'Gigabit Ethernet 10/100/1000', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoTarjetaRed, 'codigo_inventario' => null, 'nombre_periferico' => 'Tarjeta Red PCI', 'marca' => 'TP-Link', 'modelo' => 'TG-3468', 'especificaciones' => 'Gigabit Ethernet PCI Express', 'created_at' => $now, 'updated_at' => $now],

            // TARJETAS DE VIDEO
            ['tipo_hardware_id' => $tipoTarjetaVideo, 'codigo_inventario' => null, 'nombre_periferico' => 'GeForce GT 730', 'marca' => 'NVIDIA', 'modelo' => 'GT 730', 'especificaciones' => '2GB GDDR5', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoTarjetaVideo, 'codigo_inventario' => null, 'nombre_periferico' => 'Video Integrado', 'marca' => 'Intel', 'modelo' => 'HD Graphics', 'especificaciones' => 'Gráficos integrados Intel HD', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoTarjetaVideo, 'codigo_inventario' => null, 'nombre_periferico' => 'Radeon HD 5450', 'marca' => 'AMD', 'modelo' => 'HD 5450', 'especificaciones' => '1GB DDR3', 'created_at' => $now, 'updated_at' => $now],

            // TARJETAS DE AUDIO
            ['tipo_hardware_id' => $tipoTarjetaAudio, 'codigo_inventario' => null, 'nombre_periferico' => 'Audio Integrado', 'marca' => 'Realtek', 'modelo' => 'ALC887', 'especificaciones' => 'Audio HD 7.1', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoTarjetaAudio, 'codigo_inventario' => null, 'nombre_periferico' => 'Audio Integrado', 'marca' => 'Realtek', 'modelo' => 'ALC662', 'especificaciones' => 'Audio HD 5.1', 'created_at' => $now, 'updated_at' => $now],

            // TARJETAS WIFI
            ['tipo_hardware_id' => $tipoTarjetaWifi, 'codigo_inventario' => null, 'nombre_periferico' => 'Adaptador WiFi USB', 'marca' => 'TP-Link', 'modelo' => 'TL-WN725N', 'especificaciones' => 'WiFi N 150Mbps USB', 'created_at' => $now, 'updated_at' => $now],
            ['tipo_hardware_id' => $tipoTarjetaWifi, 'codigo_inventario' => null, 'nombre_periferico' => 'Adaptador WiFi PCI', 'marca' => 'TP-Link', 'modelo' => 'TL-WN881ND', 'especificaciones' => 'WiFi N 300Mbps PCI Express', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('hardware')->insert($hardware);
    }
}

