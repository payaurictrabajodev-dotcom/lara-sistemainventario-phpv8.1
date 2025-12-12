<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'nombre_completo',
        'grado_academico',
        'cargo',
        'telefono',
        'email'
    ];

    // Relaciones
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function impresoras()
    {
        return $this->hasMany(Impresora::class);
    }

    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }
}
