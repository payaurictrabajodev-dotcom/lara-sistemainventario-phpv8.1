<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 7pt; padding: 10px; }

        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; border: none; }
        .header-table td { border: none; padding: 5px; vertical-align: middle; }
        .logo-cell { width: 100px; text-align: center; }
        .logo-cell img { max-width: 80px; height: auto; }
        .title-cell { text-align: center; font-weight: bold; }
        .title-cell h4 { font-size: 11pt; margin: 2px 0; }
        .title-cell h5 { font-size: 9pt; font-weight: normal; margin: 2px 0; }
        .date-cell { width: 150px; text-align: center; font-size: 7pt; }

        .header { text-align: center; margin-bottom: 10px; }
        .header h4 { font-size: 9pt; margin-bottom: 5px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        th, td { border: 1px solid #000; padding: 2px; font-size: 6.5pt; text-align: center; }
        th { background-color: #dadada; font-weight: bold; }

        .area-header { background-color: #e8e8e8; font-weight: bold; text-align: left; font-size: 7pt; }
        .subtotal { background-color: #f5f5f5; font-weight: bold; }

        td.left { text-align: left; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('imagenes/logo.png') }}" alt="Logo DRAT">
            </td>
            <td class="title-cell">
                <h4>DIRECCIÓN REGIONAL DE AGRICULTURA TACNA</h4>
                <h5>{{ strtoupper($titulo) }}</h5>
            </td>
            <td class="date-cell">
                @php
                    $fecha = \Carbon\Carbon::now();
                    $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                    $fecha_formato = $fecha->format('d') . ' de ' . $meses[(int)$fecha->format('n')] . ' del ' . $fecha->format('Y');
                @endphp
                <div style="font-weight: bold;">FECHA</div>
                <div>{{ $fecha_formato }}</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width:3%">N°</th>
                <th style="width:10%">OFICINAS</th>
                <th style="width:10%">CÓDIGO PC</th>
                <th style="width:8%">TIPO DE PC</th>
                <th style="width:6%">AÑO FAB.</th>
                <th style="width:14%">PROCESADORES</th>
                <th style="width:6%">DD HH</th>
                <th style="width:8%">MEMORIAS</th>
                <th style="width:10%">PLACAS</th>
                <th style="width:10%">TIPO MONITORES</th>
                <th style="width:8%">CÓD. MONITORES</th>
                <th style="width:7%">RESPONSABLES</th>
            </tr>
        </thead>
        <tbody>
            @php $contador = 1; @endphp
            @foreach($equipos_por_oficina as $unidadId => $equiposUnidad)
                @if($equiposUnidad->count() > 0)
                    @php
                        $primeraUnidad = $equiposUnidad->first()->unidadOrganizacional;
                        $nombreArea = $primeraUnidad && $primeraUnidad->parent ? $primeraUnidad->parent->nombre : ($primeraUnidad ? $primeraUnidad->nombre : 'Sin área');
                    @endphp

                    <!-- Encabezado de Área/Oficina -->
                    <tr class="area-header">
                        <td colspan="12">{{ $nombreArea }}</td>
                    </tr>

                    @foreach($equiposUnidad as $equipo)
                    @php
                        // Debug: verificar si hardware existe
                        $hardwareCount = $equipo->hardware ? $equipo->hardware->count() : 0;

                        // Obtener primer hardware de cada tipo usando tipo_hardware_id
                        $procesador = null;
                        $disco = null;
                        $memoria = null;
                        $placas = collect();
                        $monitor = null;

                        if ($equipo->hardware && $hardwareCount > 0) {
                            $procesador = $equipo->hardware->first(function($hw) {
                                if (!$hw->tipoHardware) return false;
                                $nombreTipo = strtoupper($hw->tipoHardware->nombre);
                                return $nombreTipo === 'PROCESADOR' ||
                                       $nombreTipo === 'CPU' ||
                                       stripos($nombreTipo, 'PROCESADOR') !== false;
                            });

                            $disco = $equipo->hardware->first(function($hw) {
                                if (!$hw->tipoHardware) return false;
                                $nombreTipo = strtoupper($hw->tipoHardware->nombre);
                                return $nombreTipo === 'DD HH' ||
                                       $nombreTipo === 'DISCO DURO' ||
                                       $nombreTipo === 'DISCO' ||
                                       stripos($nombreTipo, 'DISCO') !== false ||
                                       stripos($nombreTipo, 'HDD') !== false ||
                                       stripos($nombreTipo, 'SSD') !== false;
                            });

                            $memoria = $equipo->hardware->first(function($hw) {
                                if (!$hw->tipoHardware) return false;
                                $nombreTipo = strtoupper($hw->tipoHardware->nombre);
                                return $nombreTipo === 'MEMORIA' ||
                                       $nombreTipo === 'MEMORIAS' ||
                                       $nombreTipo === 'MEMORIA RAM' ||
                                       $nombreTipo === 'RAM' ||
                                       stripos($nombreTipo, 'MEMORIA') !== false;
                            });

                            $placas = $equipo->hardware->filter(function($hw) {
                                if (!$hw->tipoHardware) return false;
                                $nombreTipo = strtoupper($hw->tipoHardware->nombre);
                                return stripos($nombreTipo, 'TARJETA') !== false ||
                                       stripos($nombreTipo, 'VIDEO') !== false ||
                                       stripos($nombreTipo, 'RED') !== false;
                            });
                        }

                        // Buscar monitor primero en hardware, luego en componentes
                        $monitor = null;
                        if ($equipo->hardware && $equipo->hardware->count() > 0) {
                            $monitor = $equipo->hardware->first(function($hw) {
                                if (!$hw->tipoHardware) return false;
                                $nombreTipo = strtoupper($hw->tipoHardware->nombre);
                                return $nombreTipo === 'MONITOR' ||
                                       stripos($nombreTipo, 'MONITOR') !== false;
                            });
                        }

                        // Si no hay monitor en hardware, buscar en componentes
                        if (!$monitor && $equipo->componentes && $equipo->componentes->count() > 0) {
                            $monitor = $equipo->componentes->first(function($comp) {
                                return $comp->tipoComponente &&
                                       strtoupper($comp->tipoComponente->nombre) === 'MONITOR';
                            });
                        }

                        // Obtener responsable del equipo
                        $responsable = $equipo->responsable ? $equipo->responsable->nombre_completo : '';
                    @endphp
                    <tr>
                        <td>{{ $contador++ }}</td>
                        <td class="left">{{ $equipo->unidadOrganizacional ? $equipo->unidadOrganizacional->nombre : '' }}</td>
                        <td>{{ $equipo->codigo_patrimonial }}</td>
                        <td>{{ $equipo->tipoEquipo ? $equipo->tipoEquipo->nombre : '' }}</td>
                        <td>{{ $equipo->fecha_fabricacion ? $equipo->fecha_fabricacion->format('Y') : '' }}</td>

                        <!-- PROCESADORES -->
                        <td class="left" style="font-size: 6pt;">
                            @if($procesador)
                                {{ $procesador->marca ?? '' }} {{ $procesador->modelo ?? '' }} {{ $procesador->especificaciones ?? '' }}
                      
                            @endif
                        </td>

                        <!-- DD HH (Disco Duro) -->
                        <td style="font-size: 6pt;">
                            @if($disco)
                                {{ $disco->especificaciones ?? ($disco->modelo ?? ($disco->marca ?? '')) }}
                      
                            @endif
                        </td>

                        <!-- MEMORIAS -->
                        <td style="font-size: 6pt;">
                            @if($memoria)
                                {{ $memoria->especificaciones ?? ($memoria->modelo ?? ($memoria->marca ?? '')) }}
                      
                            @endif
                        </td>

                        <!-- PLACAS (Video, Red, etc.) -->
                        <td class="left" style="font-size: 5.5pt;">
                            @if($placas->count() > 0)
                                @foreach($placas->take(2) as $placa)
                                    {{ $placa->tipoHardware->nombre ?? '' }}: {{ $placa->marca ?? '' }} {{ $placa->modelo ?? '' }}@if(!$loop->last)<br>@endif
                                @endforeach
                      
                            @endif
                        </td>

                        <!-- TIPO MONITORES -->
                        <td class="left" style="font-size: 6pt;">
                            @if($monitor)
                                {{ $monitor->marca ?? '' }} {{ $monitor->tamanio ?? $monitor->modelo ?? $monitor->especificaciones ?? $monitor->nombre ?? '' }}
                      
                            @endif
                        </td>

                        <!-- CÓD. MONITORES (Código Patrimonial del Monitor) -->
                        <td style="font-size: 6pt;">
                            @if($monitor)
                                {{ $monitor->codigo_inventario ?? $monitor->codigo_patrimonial ?? '' }}
                      
                            @endif
                        </td>

                        <!-- RESPONSABLES -->
                        <td class="left" style="font-size: 5.5pt;">
                            {{ $responsable }}
                        </td>
                    </tr>
                    @endforeach

                    <!-- Subtotal por oficina -->
                    <tr class="subtotal">
                        <td colspan="2">Subtotal</td>
                        <td colspan="10" class="left">{{ $equiposUnidad->count() }} equipos</td>
                    </tr>
                @endif
            @endforeach
            {{-- Fila cuando no hay registros en todo el conjunto --}}
            @if(collect($equipos_por_oficina)->flatten(1)->count() == 0)
                <tr>
                    <td colspan="12" class="no-data" style="padding:8px; text-align:center;">Registro: no tiene registros</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="text-align: right; margin-top: 10px; font-weight: bold;">
        <p>Total General: {{ $equipos_por_oficina->flatten(1)->count() }} equipos</p>
    </div>
</body>
</html>
