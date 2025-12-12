<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaSoftware extends Model
{
    use HasFactory;

    protected $table = 'categorias_software';

    protected $fillable = [
        'nombre',
        'descripcion',
        'orden',
    ];

    /**
     * Relación con Software
     */
    public function software()
    {
        return $this->hasMany(Software::class, 'categoria_software_id');
    }
}
