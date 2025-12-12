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
        // Crear tabla de secuencias por unidad
        Schema::create('secuencias_unidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidad_organizacional_id')
                  ->constrained('unidades_organizacionales')
                  ->cascadeOnDelete()
                  ->unique();
            $table->integer('ultimo_numero')->default(0);
            $table->timestamps();
        });

        // Agregar campo numero_secuencia a equipos
        Schema::table('equipos', function (Blueprint $table) {
            $table->integer('numero_secuencia')->nullable()->after('id');
            $table->index(['unidad_organizacional_id', 'numero_secuencia']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropIndex(['unidad_organizacional_id', 'numero_secuencia']);
            $table->dropColumn('numero_secuencia');
        });

        Schema::dropIfExists('secuencias_unidad');
    }
};
