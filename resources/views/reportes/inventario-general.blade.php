<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario General de Equipos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 7px;
            padding: 15px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: none;
        }
        .header-table td {
            border: none;
            padding: 5px;
            vertical-align: middle;
        }
        .logo-cell {
            width: 100px;
            text-align: center;
        }
        .logo-cell img {
            max-width: 80px;
            height: auto;
        }
        .title-cell {
            text-align: center;
            font-weight: bold;
        }
        .title-cell h1 {
            font-size: 11pt;
            margin: 2px 0;
        }
        .title-cell h2 {
            font-size: 9pt;
            font-weight: normal;
            margin: 2px 0;
        }
        .date-cell {
            width: 150px;
            text-align: center;
            font-size: 7pt;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }
        .header h1 {
            font-size: 12px;
            margin-bottom: 3px;
        }
        .header h2 {
            font-size: 9px;
            font-weight: normal;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        th, td {
            border: 1px solid #000;
            padding: 2px;
            text-align: left;
            font-size: 6px;
        }
        th {
            background-color: #333;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 7px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .rotate {
            writing-mode: vertical-rl;
            text-orientation: mixed;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('imagenes/logo.png') }}" alt="Logo DRAT">
            </td>
            <td class="title-cell">
                <h1>DIRECCIÓN REGIONAL DE AGRICULTURA TACNA</h1>
                <h2>INVENTARIO GENERAL DE EQUIPOS DE CÓMPUTO</h2>
                @if($unidad)
                <h2>{{ $unidad->nombre }}</h2>
                @endif
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
                <th rowspan="2">N°</th>
                <th rowspan="2">CÓDIGO<br>PATRIMONIAL</th>
                <th rowspan="2">TIPO</th>
                <th rowspan="2">MARCA</th>
                <th rowspan="2">MODELO</th>
                <th rowspan="2">SERIE</th>
                <th colspan="3">ESPECIFICACIONES</th>
                <th rowspan="2">USUARIO</th>
                <th rowspan="2">UNIDAD</th>
                <th rowspan="2">ESTADO</th>
                <th rowspan="2">OBSERVACIONES</th>
            </tr>
            <tr>
                <th>CPU</th>
                <th>RAM</th>
                <th>HDD</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipos as $index => $equipo)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $equipo->codigo_patrimonial ?? 'N/A' }}</td>
                <td>{{ $equipo->tipoEquipo->nombre ?? 'N/A' }}</td>
                <td>{{ $equipo->marca ?? 'N/A' }}</td>
                <td>{{ $equipo->modelo ?? 'N/A' }}</td>
                <td>{{ $equipo->numero_serie ?? 'N/A' }}</td>
                <td>{{ $equipo->procesador ?? 'N/A' }}</td>
                <td>{{ $equipo->ram_gb ? $equipo->ram_gb . 'GB' : 'N/A' }}</td>
                <td>{{ $equipo->almacenamiento_gb ? $equipo->almacenamiento_gb . 'GB' : 'N/A' }}</td>
                <td>{{ $equipo->usuario->name ?? 'Sin asignar' }}</td>
                <td>{{ $equipo->unidadOrganizacional->nombre ?? 'N/A' }}</td>
                <td>{{ $equipo->estado }}</td>
                <td>{{ $equipo->observaciones ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="13" class="no-data" style="padding:8px; text-align:center;">Registro: no tiene registros</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total de equipos: {{ count($equipos) }} | Generado el {{ date('d/m/Y H:i:s') }}</p>
        <p>Sistema de Inventario TIC - DRAT</p>
    </div>
</body>
</html>
