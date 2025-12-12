<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUnidadOrganizacional extends Model
{
    use HasFactory;

    protected $table = 'tipos_unidad_organizacional';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación: Un tipo puede tener muchas unidades organizacionales
     */
    public function unidades()
    {
        return $this->hasMany(UnidadOrganizacional::class, 'tipo_unidad_id');
    }
}
