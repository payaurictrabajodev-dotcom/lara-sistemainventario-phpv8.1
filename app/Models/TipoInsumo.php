<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInsumo extends Model
{
    use HasFactory;

    protected $table = 'tipos_insumo';

    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación: Un tipo de insumo puede tener muchas impresoras
     */
    public function impresoras()
    {
        return $this->hasMany(Impresora::class, 'tipo_insumo_id');
    }
}
