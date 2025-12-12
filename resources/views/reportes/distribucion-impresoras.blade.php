<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 8pt; padding: 15px; }
        
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; border: none; }
        .header-table td { border: none; padding: 5px; vertical-align: middle; }
        .logo-cell { width: 100px; text-align: center; }
        .logo-cell img { max-width: 80px; height: auto; }
        .title-cell { text-align: center; font-weight: bold; }
        .title-cell h4 { font-size: 11pt; margin: 2px 0; }
        .title-cell h5 { font-size: 9pt; font-weight: normal; margin: 2px 0; }
        .date-cell { width: 150px; text-align: center; font-size: 8pt; }
        
        .header { text-align: center; margin-bottom: 15px; }
        .header h4 { font-size: 10pt; margin-bottom: 5px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 3px; font-size: 7pt; }
        th { font-weight: bold; text-align: center; }
        td { text-align: center; }
        td.left { text-align: left; }
        /* Column sizing: hacer celdas un poco más pequeñas y dar más espacio a USUARIO */
        .col-num { width: 4%; }
        .col-codigo { width: 12%; }
        .col-tipo { width: 14%; }
        .col-modelo { width: 14%; }
        .col-oficina { width: 10%; }
        .col-insumo { width: 8%; }
        .col-estado { width: 8%; }
        .col-usuario { width: 30%; text-align: left; font-size: 7pt; }
        
        .area-header { font-weight: bold; font-size: 9pt; }
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
                <th class="col-num">N°</th>
                <th class="col-codigo">CÓDIGO DE INVENTARIO</th>
                <th class="col-tipo">TIPO DE IMPRESORAS</th>
                <th class="col-modelo">MODELO DE IMPRESORA</th>
                <th class="col-oficina">OFICINA</th>
                <th class="col-insumo">TIPO INSUMO</th>
                <th class="col-estado">ESTADO</th>
                <th class="col-usuario">USUARIO</th>
            </tr>
        </thead>
        <tbody>
            @php $contador = 1; @endphp
            @foreach($impresoras_por_area as $nombreArea => $impresorasArea)
                @if($impresorasArea->count() > 0)
                    <!-- Encabezado de Área -->
                    <tr class="area-header">
                        <td colspan="8">{{ strtoupper($nombreArea) }}</td>
                    </tr>
                    
                    @foreach($impresorasArea as $impresora)
                    <tr>
                        <td>{{ $contador++ }}</td>
                        <td>{{ $impresora->codigo_patrimonial }}</td>
                        <td class="left">
                            {{ $impresora->tipoImpresora ? $impresora->tipoImpresora->nombre : '' }}
                            @if($impresora->es_multifuncional)
                                (Multifuncional)
                            @endif
                        </td>
                        <td class="left">{{ $impresora->marca }} {{ $impresora->modelo }}</td>
                        <td class="left">{{ $impresora->unidadOrganizacional ? $impresora->unidadOrganizacional->codigo : '' }}</td>
                        <td>{{ $impresora->tipoInsumo ? $impresora->tipoInsumo->nombre : '' }}</td>
                        <td>{{ $impresora->estado }}</td>
                        <td class="left" style="font-size: 7pt;">{{ $impresora->responsable ? $impresora->responsable->nombre_completo : '' }}</td>
                    </tr>
                    @endforeach
                @endif
            @endforeach

            {{-- Fila cuando no hay impresoras en todo el conjunto --}}
            @if(collect($impresoras_por_area)->flatten(1)->count() == 0)
                <tr>
                    <td colspan="8" class="no-data" style="padding:8px; text-align:center;">Registro: no tiene registros</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="text-align: right; margin-top: 20px; font-weight: bold;">
        <p>Total: {{ $impresoras_por_area->flatten(1)->count() }} impresoras</p>
    </div>
</body>
</html>
