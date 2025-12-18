<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponenteEquipo extends Model
{
    use HasFactory;

    protected $table = 'componentes_equipo';

    protected $fillable = [
        'equipo_id',
        'nombre',
        'observaciones',
    ];

    protected $casts = [
        'equipo_id' => 'integer',
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }
}
