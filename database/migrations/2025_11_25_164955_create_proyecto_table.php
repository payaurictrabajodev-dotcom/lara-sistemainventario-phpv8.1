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
        // Simplified tables without FK constraints or pivot tables
        Schema::create('tipos_unidad_organizacional', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('unidades_organizacionales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_unidad_id')->nullable()->constrained('tipos_unidad_organizacional')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('unidades_organizacionales')->onDelete('cascade');
            $table->string('nombre');
            $table->string('codigo')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // Roles are created in the users migration to ensure correct order/flow


        Schema::create('hardware', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_hardware_id')->nullable()->constrained('tipos_hardware')->nullOnDelete();
            $table->string('codigo_inventario')->unique()->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('nombre_periferico');
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('especificaciones')->nullable();
            $table->timestamps();
        });

        Schema::create('software', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_software_id')->nullable()->constrained('categorias_software')->nullOnDelete();
            $table->string('nombre_programa');
            $table->string('version')->nullable();
            $table->string('licencia')->nullable();
            $table->timestamps();
        });

        Schema::create('tipos_equipo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidad_organizacional_id')->nullable()->constrained('unidades_organizacionales')->nullOnDelete();
            $table->foreignId('tipo_equipo_id')->nullable()->constrained('tipos_equipo')->nullOnDelete();
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete(); // Responsable directo (legacy)
            $table->foreignId('responsable_id')->nullable()->constrained('responsables')->nullOnDelete();

            // CÓDIGOS DE IDENTIFICACIÓN
            $table->string('codigo_patrimonial')->unique()->nullable();
            $table->string('codigo_inventario')->nullable();
            $table->string('numero_serie')->nullable();

            // INFORMACIÓN BÁSICA
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('direccion_ip')->nullable();
            $table->string('mac')->nullable(); // Dirección MAC del equipo
            $table->date('fecha_compra')->nullable();
            $table->date('fecha_fabricacion')->nullable();
            $table->date('fecha_asignacion')->nullable();
            $table->date('fecha_registro')->nullable();

            // ESTADO Y OBSERVACIONES
            $table->string('estado')->default('Operativo');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });

        Schema::create('tipos_impresora', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('tipos_insumo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        Schema::create('tipos_componente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('impresoras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidad_organizacional_id')->nullable()->constrained('unidades_organizacionales')->nullOnDelete();
            $table->string('codigo_patrimonial')->nullable();
            $table->string('numero_serie')->nullable();
            $table->foreignId('tipo_impresora_id')->nullable()->constrained('tipos_impresora')->nullOnDelete();
            $table->foreignId('tipo_insumo_id')->nullable()->constrained('tipos_insumo')->nullOnDelete();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('direccion_ip')->nullable();
            $table->string('estado')->default('Operativo');
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('responsable_id')->nullable()->constrained('responsables')->nullOnDelete();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });



        // Pivot table: equipos <-> hardware (muchos a muchos)
        Schema::create('equipo_hardware', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->cascadeOnDelete();
            $table->foreignId('hardware_id')->constrained('hardware')->cascadeOnDelete();
            $table->date('fecha_asignacion')->nullable();
            $table->string('estado_asignacion')->default('Activo');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->unique(['equipo_id', 'hardware_id']);
        });

        // Pivot table: equipos <-> software (muchos a muchos)
        Schema::create('equipo_software', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->cascadeOnDelete();
            $table->foreignId('software_id')->constrained('software')->cascadeOnDelete();
            $table->date('fecha_instalacion')->nullable();
            $table->string('serial_asignado')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->unique(['equipo_id', 'software_id']);
        });

        // Componentes: tabla independiente con código patrimonial
        Schema::create('componentes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_patrimonial')->unique();
            $table->string('nombre');
            $table->foreignId('tipo_componente_id')->nullable()->constrained('tipos_componente')->nullOnDelete();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('especificaciones')->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('estado')->default('Disponible'); // Disponible, En Uso, Dañado
            $table->foreignId('unidad_organizacional_id')->nullable()->constrained('unidades_organizacionales')->nullOnDelete();
            $table->foreignId('responsable_id')->nullable()->constrained('responsables')->nullOnDelete();
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });

        // Pivot table: equipos <-> componentes (muchos a muchos)
        Schema::create('equipo_componente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->cascadeOnDelete();
            $table->foreignId('componente_id')->constrained('componentes')->cascadeOnDelete();
            $table->date('fecha_asignacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->unique(['equipo_id', 'componente_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop in reverse order considering foreign key dependencies
        Schema::dropIfExists('equipo_componente');
        Schema::dropIfExists('equipo_software');
        Schema::dropIfExists('equipo_hardware');
        Schema::dropIfExists('componentes');
        Schema::dropIfExists('impresoras');
        Schema::dropIfExists('equipos');
        Schema::dropIfExists('software');
        Schema::dropIfExists('hardware');
        Schema::dropIfExists('tipos_insumo');
        Schema::dropIfExists('tipos_impresora');
        Schema::dropIfExists('tipos_equipo');
        Schema::dropIfExists('unidades_organizacionales');
        Schema::dropIfExists('tipos_unidad_organizacional');
    }
};
