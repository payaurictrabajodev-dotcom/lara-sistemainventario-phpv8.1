<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Equipo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            padding: 15px;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }
        .main-table td, .main-table th {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }
        .main-table .no-border {
            border: none !important;
        }
        .logo-cell {
            width: 100px;
            text-align: center;
            vertical-align: middle;
        }
        .logo-cell img {
            max-width: 95px;
            height: auto;
        }
        .header-cell {
            text-align: center;
            font-weight: bold;
        }
        .header-cell h1 {
            font-size: 11px;
            margin: 2px 0;
        }
        .header-cell h2 {
            font-size: 9px;
            font-weight: normal;
            margin: 2px 0;
        }
        .numero-cell {
            width: 60px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
        }
        .info-label {
            padding: 3px 5px;
            font-size: 8px;
            text-transform: uppercase;
            width: 25%;
        }
        .info-value {
            padding: 3px 5px;
            font-size: 9px;
        }
        .section-header {
            font-weight: 700;
            text-align: center;
            padding: 5px;
            font-style: italic;
            font-size: 9px;
            text-transform: uppercase;
        }
        .table-header {
            /* background-color: #f0f0f0; */
            font-weight: 700;
            text-align: center;
            padding: 4px;
            font-size: 8px;
        }
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <table style="width: 100%; padding-bottom: 10px;">
          <!-- Fila 1: Logo, Encabezado, Número -->
        <tr>
            <td class="logo-cell no-border" rowspan="2">
                <img src="<?php echo e(public_path('imagenes/logo.png')); ?>" alt="Logo DRAT">
            </td>
            <td class="header-cell no-border" rowspan="2" colspan="2">
                <h1>DIRECCIÓN REGIONAL DE AGRICULTURA TACNA</h1>
                <h2>UNIDAD DE LOGÍSTICA - TECNOLOGÍA DE LA INFORMACIÓN</h2>
            </td>
            <td class="numero-cell no-border">
                N° <?php echo e($equipo->numero_secuencia ? str_pad($equipo->numero_secuencia, 3, '0', STR_PAD_LEFT) : '000'); ?>

            </td>
        </tr>
        
        <!-- Fila 2: Fecha -->
        <tr>
            
        </tr>
        
        <tr>
            <?php
                $fecha = \Carbon\Carbon::now();
                $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                $fecha_formato = $fecha->format('d') . ' de ' . $meses[(int)$fecha->format('n')] . ' del ' . $fecha->format('Y');
            ?>
            <td class="info-label no-border">FECHA</td>
            <td colspan="3" class="info-value no-border"><?php echo e($fecha_formato); ?></td>
        </tr>
        <!-- Fila 3: Nombre de Usuario -->
        <tr>
            <td class="info-label no-border">NOMBRE DE USUARIO</td>
            <td colspan="3" class="info-value no-border"><?php echo e($equipo->responsable->nombre_completo ?? '-'); ?></td>
        </tr>
        
        <!-- Fila 4: Dependencia -->
        <tr>
            <td class="info-label no-border">DEPENDENCIA</td>
            <td colspan="3" class="info-value no-border">
                <?php if($equipo->unidadOrganizacional): ?>
                    <?php if($equipo->unidadOrganizacional->parent): ?>
                        <?php echo e($equipo->unidadOrganizacional->parent->codigo ?? ''); ?> - <?php echo e($equipo->unidadOrganizacional->nombre); ?>

                    <?php else: ?>
                        <?php echo e($equipo->unidadOrganizacional->nombre); ?>

                    <?php endif; ?>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
        </tr>
        
    </table>
    
    <table class="main-table">
      
        <!-- Fila 5: Encabezado de Tabla de Periféricos -->
        <tr>
            <th class="table-header" style="width: 25%;">PERIFÉRICO</th>
            <th class="table-header" style="width: 30%;">MODELO</th>
            <th class="table-header" style="width: 20%;">MARCA</th>
            <th class="table-header" style="width: 25%;">CÓD. INVENTARIO</th>
        </tr>
        
        <!-- Fila 6: Equipo Principal -->
        <tr>
            <td><strong><?php echo e(strtoupper($equipo->tipoEquipo->nombre ?? 'EQUIPO DE COMPUTO')); ?></strong></td>
            <td><?php echo e($equipo->modelo ?? 'N/A'); ?></td>
            <td><?php echo e($equipo->marca ?? 'N/A'); ?></td>
            <td><strong><?php echo e($equipo->codigo_patrimonial ?? 'N/A'); ?></strong></td>
        </tr>
        
        <!-- Filas: Componentes -->
        <?php $__empty_1 = true; $__currentLoopData = $equipo->componentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e(strtoupper($comp->tipoComponente->nombre ?? $comp->nombre ?? $comp->tipo ?? 'COMPONENTE')); ?></td>
            <td><?php echo e($comp->modelo ?? 'N/A'); ?></td>
            <td><?php echo e($comp->marca ?? 'N/A'); ?></td>
            <td><?php echo e($comp->codigo_patrimonial ?? 'S/N'); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="4" class="no-data" style="padding: 8px;">No hay componentes adicionales asignados</td>
        </tr>
        <?php endif; ?>
        
        <!-- Sección Hardware -->
        <?php if($equipo->hardware->count() > 0): ?>
        <tr>
            <td colspan="4" class="section-header">ESPECIFICACIONES TÉCNICAS DE HARDWARE</td>
        </tr>
        <tr>
            <th class="table-header" style="width: 20%;">ITEM</th>
            <th class="table-header" style="width: 25%;">PERIFÉRICO</th>
            <th class="table-header" style="width: 20%;">MARCA</th>
            <th class="table-header" style="width: 35%;">ESPECIFICACIONES</th>
        </tr>
        <?php $__currentLoopData = $equipo->hardware; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(strtoupper($hw->tipoHardware->nombre ?? $hw->tipo ?? 'HARDWARE')); ?></td>
            <td><?php echo e($hw->nombre_periferico); ?></td>
            <td><?php echo e($hw->marca ?? 'N/A'); ?></td>
            <td><?php echo e($hw->especificaciones ?? 'N/A'); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <tr>
            <td colspan="4" class="section-header">ESPECIFICACIONES TÉCNICAS DE HARDWARE</td>
        </tr>
        <tr>
            <td colspan="4" class="no-data" style="padding: 8px;">No tiene especificaciones de hardware registradas</td>
        </tr>
        <?php endif; ?>
        
        <!-- Sección Software -->
        <?php if($equipo->software->count() > 0): ?>
        <tr>
            <td colspan="4" class="section-header">ESPECIFICACIONES TÉCNICAS DE SOFTWARE</td>
        </tr>
        <tr>
            <th class="table-header" style="width: 25%;">SOFTWARE Y APLICATIVOS</th>
            <th class="table-header" style="width: 35%;">PROGRAMA</th>
            <th class="table-header" style="width: 15%;">VERSIÓN</th>
            <th class="table-header" style="width: 25%;">LICENCIA</th>
        </tr>
        <?php $__currentLoopData = $equipo->software; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(strtoupper($sw->categoriaSoftware->nombre ?? $sw->tipo_software ?? 'SOFTWARE')); ?></td>
            <td><?php echo e($sw->nombre_programa); ?></td>
            <td><?php echo e($sw->version ?? 'N/A'); ?></td>
            <td><?php echo e($sw->licencia ?? ($sw->tipo_licencia ?? 'N/A')); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <tr>
            <td colspan="4" class="section-header">ESPECIFICACIONES TÉCNICAS DE SOFTWARE</td>
        </tr>
        <tr>
            <td colspan="4" class="no-data" style="padding: 8px;">No tiene especificaciones de software registradas</td>
        </tr>
        <?php endif; ?>
        
        <!-- Fila: Observaciones -->
        <tr>
            <td class="info-label">OBSERVACIONES</td>
            <td colspan="3" class="info-value"><?php echo e($equipo->observaciones ?? 'Ninguna'); ?></td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\www\proyecto_inventario_drat\lara-sistemainventario-utiv8.1\resources\views/reportes/ficha-equipo.blade.php ENDPATH**/ ?>