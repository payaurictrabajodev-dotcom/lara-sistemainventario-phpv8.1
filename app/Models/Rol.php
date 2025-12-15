<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación: Un rol puede tener muchos usuarios
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    /**
     * Relación: Un rol puede tener muchas vistas/permisos
     */
    public function vistas()
    {
        return $this->belongsToMany(VistaSistema::class, 'rol_vista', 'rol_id', 'vista_id')
            ->withTimestamps();
    }
}
