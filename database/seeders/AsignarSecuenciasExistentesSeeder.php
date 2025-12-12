<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Equipo;
use App\Models\SecuenciaUnidad;

class AsignarSecuenciasExistentesSeeder extends Seeder
{
    /**
     * Asigna números de secuencia a equipos existentes que no tienen
     */
    public function run(): void
    {
        // Obtener todos los equipos sin número de secuencia
        $equipos = Equipo::whereNull('numero_secuencia')
            ->orWhere('numero_secuencia', 0)
            ->orderBy('unidad_organizacional_id')
            ->orderBy('created_at')
            ->get();

        $this->command->info("Encontrados {$equipos->count()} equipos sin número de secuencia");

        foreach ($equipos as $equipo) {
            if ($equipo->unidad_organizacional_id) {
                // Obtener el siguiente número de secuencia para la unidad
                $numeroSecuencia = SecuenciaUnidad::obtenerSiguienteNumero($equipo->unidad_organizacional_id);
                
                // Actualizar el equipo sin disparar eventos (para evitar duplicados)
                DB::table('equipos')
                    ->where('id', $equipo->id)
                    ->update(['numero_secuencia' => $numeroSecuencia]);

                $this->command->info("Equipo ID {$equipo->id}: Asignado número {$numeroSecuencia} para unidad {$equipo->unidad_organizacional_id}");
            } else {
                $this->command->warn("Equipo ID {$equipo->id} sin unidad organizacional asignada");
            }
        }

        $this->command->info("Proceso completado");
    }
}
