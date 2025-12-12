<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    use HasFactory;

    protected $table = 'componentes';

    protected $fillable = [
        'codigo_patrimonial',
        'nombre',
        'tipo_componente_id',
        'marca',
        'modelo',
        'especificaciones',
        'numero_serie',
        'estado',
        'unidad_organizacional_id',
        'responsable_id',
        'usuario_id',
        'observaciones',
    ];

    /**
     * Relación: Un componente pertenece a un tipo de componente
     */
    public function tipoComponente()
    {
        return $this->belongsTo(TipoComponente::class, 'tipo_componente_id');
    }

    /**
     * Relación: Un componente pertenece a una unidad organizacional
     */
    public function unidadOrganizacional()
    {
        return $this->belongsTo(UnidadOrganizacional::class, 'unidad_organizacional_id');
    }

    /**
     * Relación: Un componente pertenece a un responsable
     */
    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'responsable_id');
    }

    /**
     * Relación: Un componente pertenece a un usuario (quien lo registró)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación: Un componente puede estar en muchos equipos
     */
    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_componente')
            ->withPivot('fecha_asignacion', 'observaciones')
            ->withTimestamps();
    }

}
