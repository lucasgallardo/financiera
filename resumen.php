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
    <script>
        $(function(){
        $('#totalFinanciado').click(function(){
            $('#info').load('resumenes/totalFinanciado.php');
        })                
        $('#capitalMensual').click(function(){
            $('#info').load('resumenes/capitalMensual.php');
        })
        $('#intereses').click(function(){
            $('#info').load('resumenes/intereses.php');
        })
        $('#totalMensual').click(function(){
            $('#info').load('resumenes/totalMensual.php');
        });
    });
    </script>
</head>
<body>
    <?php echo panel("resumen"); ?>
    <div class="container-fluid">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Resumen de movimientos</h3>
            </div>
            <div class="panel-body">

                <?php $totales=mostrarResumen($conexion,$_SESSION['usuario_id']); ?>
                <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td class="alert alert-info">Total Financiado: $<?php echo $totales['totalPrestado']." "; ?><span id="totalFinanciado" name="button" class="glyphicon glyphicon-zoom-in"></span></td>
                        <td class="alert alert-info">Capital Mensual: $<?php echo $totales['totalDevuelto']." "; ?><span id="capitalMensual" name="button" class="glyphicon glyphicon-zoom-in"></span></td>
                        <td class="alert alert-info">Intereses: $<?php echo $totales['intereses']." "; ?><span id="intereses" name="button" class="glyphicon glyphicon-zoom-in"></span></td>
                        <td class="alert alert-info">Total Mensual: $<?php echo $totales['totalMensual']." "; ?><span id="totalMensual" name="button" class="glyphicon glyphicon-zoom-in"></span></td>                        
                    </tr>
                </tbody>                                
            </table>
        </div>
    </div>
    <div id="info"></div>
</div>
<script src="js/bootstrap.min.js"></script>
<?php
  } else {header ("Location: salir.php");}
?>
</body>
</html>