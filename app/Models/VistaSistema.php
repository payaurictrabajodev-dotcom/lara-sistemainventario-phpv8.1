<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VistaSistema extends Model
{
    use HasFactory;

    protected $table = 'vistas_sistema';

    protected $fillable = [
        'nombre',
        'ruta',
        'icono',
        'modulo',
        'orden',
        'es_menu',
        'parent_id'
    ];

    protected $casts = [
        'es_menu' => 'boolean',
        'orden' => 'integer'
    ];

    /**
     * Relación con roles
     */
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_vista', 'vista_id', 'rol_id')
            ->withTimestamps();
    }

    /**
     * Vista padre (para submenús)
     */
    public function parent()
    {
        return $this->belongsTo(VistaSistema::class, 'parent_id');
    }

    /**
     * Vistas hijas (submenús)
     */
    public function children()
    {
        return $this->hasMany(VistaSistema::class, 'parent_id')->orderBy('orden');
    }
}
