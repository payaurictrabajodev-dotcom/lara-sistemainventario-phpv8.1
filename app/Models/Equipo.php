<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';

    protected $fillable = [
        'numero_secuencia',
        'unidad_organizacional_id',
        'tipo_equipo_id',
        'usuario_id',
        'responsable_id',
        'codigo_patrimonial',
        'codigo_inventario',
        'numero_serie',
        'marca',
        'modelo',
        'direccion_ip',
        'fecha_compra',
        'fecha_fabricacion',
        'fecha_asignacion',
        'fecha_registro',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_compra' => 'date',
        'fecha_fabricacion' => 'date',
        'fecha_asignacion' => 'date',
        'fecha_registro' => 'date',
    ];

    /**
     * Relación: Un equipo pertenece a una unidad organizacional
     */
    public function unidadOrganizacional()
    {
        return $this->belongsTo(UnidadOrganizacional::class, 'unidad_organizacional_id');
    }

    /**
     * Relación: Un equipo pertenece a un tipo de equipo
     */
    public function tipoEquipo()
    {
        return $this->belongsTo(TipoEquipo::class, 'tipo_equipo_id');
    }

    /**
     * Relación: Un equipo pertenece a un usuario responsable
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación: Un equipo pertenece a un responsable
     */
    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'responsable_id');
    }

    /**
     * Relación muchos a muchos con Hardware
     */
    public function hardware()
    {
        return $this->belongsToMany(Hardware::class, 'equipo_hardware', 'equipo_id', 'hardware_id')
            ->withTimestamps()
            ->withPivot('fecha_asignacion', 'estado_asignacion', 'observaciones');
    }

    /**
     * Relación muchos a muchos con Software
     */
    public function software()
    {
        return $this->belongsToMany(Software::class, 'equipo_software', 'equipo_id', 'software_id')
            ->withTimestamps()
            ->withPivot('fecha_instalacion', 'serial_asignado', 'observaciones');
    }

    /**
     * Relación muchos a muchos con Componentes
     */
    public function componentes()
    {
        return $this->belongsToMany(Componente::class, 'equipo_componente')
            ->withPivot('fecha_asignacion', 'observaciones')
            ->withTimestamps();
    }

    /**
     * Boot method para generar automáticamente el número de secuencia
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($equipo) {
            // Si tiene unidad organizacional asignada, generar número de secuencia
            if ($equipo->unidad_organizacional_id && !$equipo->numero_secuencia) {
                $equipo->numero_secuencia = SecuenciaUnidad::obtenerSiguienteNumero($equipo->unidad_organizacional_id);
            }
        });

        static::updating(function ($equipo) {
            // Si se cambia la unidad organizacional, asignar nuevo número de secuencia
            if ($equipo->isDirty('unidad_organizacional_id') && $equipo->unidad_organizacional_id) {
                $equipo->numero_secuencia = SecuenciaUnidad::obtenerSiguienteNumero($equipo->unidad_organizacional_id);
            }
        });
    }

    /**
     * Obtiene el número de secuencia formateado
     */
    public function getNumeroSecuenciaFormateadoAttribute()
    {
        if (!$this->numero_secuencia) {
            return 'N/A';
        }
        return str_pad($this->numero_secuencia, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Obtiene el código completo del equipo (Unidad + Secuencia)
     */
    public function getCodigoCompletoAttribute()
    {
        $codigoUnidad = $this->unidadOrganizacional->codigo ?? 'SIN-UNIDAD';
        $secuencia = $this->numero_secuencia_formateado;
        return "{$codigoUnidad}-{$secuencia}";
    }
}
