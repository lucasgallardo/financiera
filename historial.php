<?php 
session_start();
include ('librerias/cabecera.php');
include ('librerias/conexion.php');
include ('librerias/operaciones.php');
if(isset($_SESSION['usuario_nombre'])){
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <?php echo head(); ?>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/base.css">
    <script src="js/jquery-1.12.3.js"></script>
    <script src="js/jquery-ui.min.js"></script>

    <script>
      $(function() {
        $.datepicker.regional['es'] = 
        {
          closeText: 'Seleccionar', 
          prevText: 'Previo', 
          nextText: 'Próximo',
          currentText: 'Cancelar',
          monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
          'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
          monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
          'Jul','Ago','Sep','Oct','Nov','Dic'],
          monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
          dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
          dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
          dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
          dateFormat: 'dd/mm/yy', firstDay: 0, 
          initStatus: 'Selecciona la fecha', isRTL: false};
          $.datepicker.setDefaults($.datepicker.regional['es']);
          $('.date-picker').datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'mm-yy',
            onClose: function(dateText, inst) { 
              $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
          });
        });
    </script>
  </head>
  <body>
    <?php echo panel("historial"); ?>
    <div class="container-fluid">

      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Historial de Pagos</h3>
        </div>
        <div class="panel-body">
        <form action="" method="POST" >
          <label for="startDate">Date :</label>
          <input name="buscado" id="startDate" class="date-picker" />
          <button type="submit" name="buscar" class="btn btn-info" >Buscar</button>
        </form>
        <?php 
          if (isset($_POST["buscar"])) {
            //$mesBuscado=$_POST[""];
            $fecha=$_POST["buscado"];
            $date= explode("-",$fecha,2);
            $mes= $date[0];
            $anio= $date[1];

            $rs = mysqli_query( $conexion,"SELECT cliente_id,cliente_nombre,cliente_celular,cliente_cuotas,cliente_cuota_total,cliente_idAuto,ordenes_fecha_pagada,ordenes_numero FROM clientes,ordenes WHERE MONTH(ordenes_fecha_pagada)='$mes' AND YEAR(ordenes_fecha_pagada)='$anio' AND ordenes_id_cliente=cliente_id AND cliente_usuario='".$_SESSION['usuario_id']."' ORDER BY cliente_id ASC") or die(mysqli_error($conexion)); ?>
            <hr size="10"/>
            <div class="col-md-12 text-center">
              <h3><?php echo "Movimientos de caja del mes de ".nombreMes($mes)." de ".$anio; ?></h3>
            </div>

            <table class="table table-hover table-striped table-bordered">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Modelo de auto</th>
                <th>Teléfono</th>
                <th>Valor Cuota</th>
                <th>N° de cuota</th>
                <th>Pagado el día:</th>
              </tr> 
            </thead>
            <tbody>
              <?php while ($resultado=mysqli_fetch_array($rs)) { ?>
                <tr>
                <td><?php echo $resultado["cliente_nombre"]; ?></td>
                <td><?php echo buscaAuto($resultado['cliente_idAuto'],$conexion); ?></td>
                <td><?php echo $resultado["cliente_celular"]; ?></td>
                <td><?php echo $resultado["cliente_cuota_total"]; ?></td>
                <?php $totaPagado=$totaPagado+$resultado["cliente_cuota_total"]; ?>
                <td><?php echo $resultado["ordenes_numero"]; ?></td>
                <td><?php echo transformaFecha($resultado["ordenes_fecha_pagada"]); ?></td>
              </tr>

              <?php
                } ?>
              <tr class="success">
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo "Total: $".totalPagadoHistorial($mes,$anio,$_SESSION['usuario_id'],$conexion); ?></td>
                <td></td>
                <td></td>
              </tr>         
            </tbody>                                
          </table>

          <?php } ?>
        </div>
      </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <?php
  } else {header ("Location: salir.php");}
  ?>
</body>
</html>