<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed simplified inventory data
        $this->call([
            // Catálogos base (primero)
            TiposHardwareSeeder::class,
            CategoriasSoftwareSeeder::class,
            TipoComponenteSeeder::class,

            // Estructura organizacional
            TipoUnidadOrganizacionalSeeder::class,
            UnidadOrganizacionalSeeder::class,

            // Usuarios y roles
            RolesSeeder::class,
            UsuariosSeeder::class,

            // Responsables
            ResponsablesSeeder::class,

            // Catálogos de equipos
            TiposEquipoSeeder::class,
            TiposImpresoraSeeder::class,
            TiposInsumoSeeder::class,

            // Inventario (Hardware, Software, Componentes)
            HardwareSeeder::class,
            SoftwareSeeder::class,
            ComponentesSeeder::class,

            // Equipos e impresoras (último porque dependen de los demás)
            // EquiposSeeder::class,
            // ImpresorasSeeder::class,
        ]);
    }
}
