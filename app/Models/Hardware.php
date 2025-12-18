<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    use HasFactory;

    protected $table = 'hardware';

    protected $fillable = [
        'tipo_hardware_id',
        'codigo_inventario',
        'numero_serie',
        'nombre_periferico',
        'marca',
        'modelo',
        'especificaciones',
    ];

    protected $casts = [
        'tipo_hardware_id' => 'integer',
    ];

    /**
     * Relación con TipoHardware
     */
    public function tipoHardware()
    {
        return $this->belongsTo(TipoHardware::class, 'tipo_hardware_id');
    }

    /**
     * Equipos que tienen este hardware (muchos a muchos)
     */
    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_hardware', 'hardware_id', 'equipo_id')
            ->withTimestamps()
            ->withPivot('fecha_asignacion', 'estado_asignacion', 'observaciones');
    }
}
