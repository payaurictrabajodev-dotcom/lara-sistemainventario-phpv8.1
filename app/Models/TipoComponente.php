<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoComponente extends Model
{
    use HasFactory;

    protected $table = 'tipos_componente';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación: Un tipo de componente tiene muchos componentes
     */
    public function componentes()
    {
        return $this->hasMany(Componente::class, 'tipo_componente_id');
    }
}
