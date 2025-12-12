<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadOrganizacional extends Model
{
    use HasFactory;

    protected $table = 'unidades_organizacionales';

    protected $fillable = [
        'tipo_unidad_id',
        'parent_id',
        'nombre',
        'codigo',
        'descripcion',
    ];

    protected $with = ['tipoUnidad'];

    /**
     * Relación: Una unidad pertenece a un tipo
     */
    public function tipoUnidad()
    {
        return $this->belongsTo(TipoUnidadOrganizacional::class, 'tipo_unidad_id');
    }

    /**
     * Relación: Una unidad puede tener un padre
     */
    public function parent()
    {
        return $this->belongsTo(UnidadOrganizacional::class, 'parent_id');
    }

    /**
     * Relación: Una unidad puede tener muchos hijos
     */
    public function children()
    {
        return $this->hasMany(UnidadOrganizacional::class, 'parent_id')->with('children');
    }

    /**
     * Obtener todos los descendientes recursivamente
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Obtener todos los ancestros
     */
    public function ancestors()
    {
        $ancestors = collect([]);
        $parent = $this->parent;
        
        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }
        
        return $ancestors;
    }

    /**
     * Relación: Una unidad puede tener muchos equipos
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'unidad_organizacional_id');
    }

    /**
     * Relación: Una unidad puede tener muchas impresoras
     */
    public function impresoras()
    {
        return $this->hasMany(Impresora::class, 'unidad_organizacional_id');
    }

    /**
     * Relación: Una unidad puede tener muchos registros de equipos
     */
    public function registrosEquipos()
    {
        return $this->hasMany(RegistroEquipo::class, 'unidad_organizacional_id');
    }
}
