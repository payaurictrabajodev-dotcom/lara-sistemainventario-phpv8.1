<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoHardware extends Model
{
    use HasFactory;

    protected $table = 'tipos_hardware';

    protected $fillable = [
        'nombre',
        'categoria',
        'descripcion',
        'orden',
    ];

    protected $casts = [
        'orden' => 'integer',
    ];

    /**
     * Relación con Hardware
     */
    public function hardware()
    {
        return $this->hasMany(Hardware::class, 'tipo_hardware_id');
    }
}
