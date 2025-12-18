<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SecuenciaUnidad extends Model
{
    use HasFactory;

    protected $table = 'secuencias_unidad';

    protected $fillable = [
        'unidad_organizacional_id',
        'ultimo_numero'
    ];

    protected $casts = [
        'unidad_organizacional_id' => 'integer',
        'ultimo_numero' => 'integer',
    ];

    /**
     * Relación con UnidadOrganizacional
     */
    public function unidadOrganizacional()
    {
        return $this->belongsTo(UnidadOrganizacional::class);
    }

    /**
     * Obtiene el siguiente número de secuencia para una unidad organizacional
     *
     * @param int $unidadOrganizacionalId
     * @return int
     */
    public static function obtenerSiguienteNumero($unidadOrganizacionalId)
    {
        return DB::transaction(function () use ($unidadOrganizacionalId) {
            // Buscar o crear la secuencia para la unidad
            $secuencia = self::firstOrCreate(
                ['unidad_organizacional_id' => $unidadOrganizacionalId],
                ['ultimo_numero' => 0]
            );

            // Incrementar el número
            $secuencia->ultimo_numero += 1;
            $secuencia->save();

            return $secuencia->ultimo_numero;
        });
    }

    /**
     * Resetea la secuencia de una unidad organizacional
     *
     * @param int $unidadOrganizacionalId
     * @return void
     */
    public static function resetearSecuencia($unidadOrganizacionalId)
    {
        self::updateOrCreate(
            ['unidad_organizacional_id' => $unidadOrganizacionalId],
            ['ultimo_numero' => 0]
        );
    }

    /**
     * Obtiene el número actual sin incrementar
     *
     * @param int $unidadOrganizacionalId
     * @return int
     */
    public static function obtenerNumeroActual($unidadOrganizacionalId)
    {
        $secuencia = self::where('unidad_organizacional_id', $unidadOrganizacionalId)->first();
        return $secuencia ? $secuencia->ultimo_numero : 0;
    }
}
