<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impresora extends Model
{
    use HasFactory;

    protected $table = 'impresoras';

    protected $fillable = [
        'unidad_organizacional_id',
        'codigo_patrimonial',
        'tipo_impresora_id',
        'tipo_insumo_id',
        'marca',
        'modelo',
        'numero_serie',
        'direccion_ip',
        'estado',
        'usuario_id',
        'responsable_id',
        'observaciones',
    ];

    protected $casts = [
        'unidad_organizacional_id' => 'integer',
        'tipo_impresora_id' => 'integer',
        'tipo_insumo_id' => 'integer',
        'usuario_id' => 'integer',
        'responsable_id' => 'integer',
    ];

    /**
     * Relación: Una impresora pertenece a una unidad organizacional
     */
    public function unidadOrganizacional()
    {
        return $this->belongsTo(UnidadOrganizacional::class, 'unidad_organizacional_id');
    }

    /**
     * Relación: Una impresora pertenece a un tipo de impresora
     */
    public function tipoImpresora()
    {
        return $this->belongsTo(TipoImpresora::class, 'tipo_impresora_id');
    }

    /**
     * Relación: Una impresora pertenece a un tipo de insumo
     */
    public function tipoInsumo()
    {
        return $this->belongsTo(TipoInsumo::class, 'tipo_insumo_id');
    }

    /**
     * Relación: Una impresora puede tener un usuario responsable
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Alias para usuario responsable
     */
    public function usuarioResponsable()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación: Una impresora pertenece a un responsable
     */
    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'responsable_id');
    }
}
