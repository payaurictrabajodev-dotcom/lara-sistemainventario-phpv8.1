<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabla de vistas/permisos del sistema
        Schema::create('vistas_sistema', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre descriptivo de la vista
            $table->string('ruta'); // Ruta en Angular, ej: /admin/equipos/listar
            $table->string('icono')->nullable(); // Icono de PrimeNG
            $table->string('modulo')->nullable(); // Agrupación: Dashboard, Equipos, Inventario, etc.
            $table->integer('orden')->default(0); // Orden de visualización
            $table->boolean('es_menu')->default(true); // Si aparece en el menú lateral
            $table->foreignId('parent_id')->nullable()->constrained('vistas_sistema')->nullOnDelete(); // Para submenús
            $table->timestamps();
        });

        // Tabla pivote: roles <-> vistas (muchos a muchos)
        Schema::create('rol_vista', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rol_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('vista_id')->constrained('vistas_sistema')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['rol_id', 'vista_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_vista');
        Schema::dropIfExists('vistas_sistema');
    }
};
