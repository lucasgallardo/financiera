<?php 
session_start();
include_once ('../librerias/conexion.php'); 
include_once('../librerias/operaciones.php');

$listado=mysqli_query($conexion,"SELECT cliente_nombre,cliente_monto,cliente_id,cliente_cuotas FROM clientes WHERE cliente_usuario='".$_SESSION['usuario_id']."'") or die(mysqli_error($conexion));
?>
<div class="jumbotron">
  <div class="container">
    <h3>Detalles Total financiado</h3>
    <table class="table table-striped table-bordered">
    	<thead>
    		<tr>
    			<th>Nombre</th>
    			<th>Monto Financiado</th>
                <th>Pagado por cliente</th>
                <th>Restante</th>
    		</tr>
    	</thead>
    	<tbody>
    	<?php 
    	while ($row=mysqli_fetch_array($listado)) { ?>
    		<tr>
    			<td><?php echo $row["cliente_nombre"]; ?></td>
    			<td><?php echo "$ ".$row["cliente_monto"]; ?></td>
                <td><?php echo "$ ".round(totalDevuelto($row["cliente_id"],$conexion)); ?></td>
                <td><?php echo "$ ".round(totalRestante($row["cliente_id"],$conexion)); ?></td>
    		</tr>
    	<?php } ?>
    	</tbody>
    </table>
  </div>
</div>