<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;

    protected $table = 'software';

    protected $fillable = [
        'categoria_software_id',
        'nombre_programa',
        'version',
        'licencia',
    ];

    protected $casts = [
        'categoria_software_id' => 'integer',
    ];

    /**
     * Relación con CategoriaSoftware
     */
    public function categoriaSoftware()
    {
        return $this->belongsTo(CategoriaSoftware::class, 'categoria_software_id');
    }

    /**
     * Equipos que tienen este software (muchos a muchos)
     */
    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_software', 'software_id', 'equipo_id')
            ->withTimestamps()
            ->withPivot('fecha_instalacion', 'serial_asignado', 'observaciones');
    }
}
