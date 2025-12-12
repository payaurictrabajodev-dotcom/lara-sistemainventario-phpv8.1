<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoImpresora extends Model
{
    use HasFactory;

    protected $table = 'tipos_impresora';

    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación: Un tipo de impresora puede tener muchas impresoras
     */
    public function impresoras()
    {
        return $this->hasMany(Impresora::class, 'tipo_impresora_id');
    }
}
