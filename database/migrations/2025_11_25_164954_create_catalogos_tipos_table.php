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
        // Catálogo de tipos de hardware/componentes
        Schema::create('tipos_hardware', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // CASE, MOTHERBOARD, PROCESADOR, etc.
            $table->string('categoria')->default('Componente'); // Componente o Periferico
            $table->string('descripcion')->nullable();
            $table->integer('orden')->default(0); // Para ordenar en formularios
            $table->timestamps();
        });

        // Catálogo de categorías de software
        Schema::create('categorias_software', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Sistema Operativo, Ofimática, Navegador Web, etc.
            $table->string('descripcion')->nullable();
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias_software');
        Schema::dropIfExists('tipos_hardware');
    }
};
