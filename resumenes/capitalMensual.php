<?php 
session_start();
include_once ('../librerias/conexion.php'); 
$mesActual=date('m');
$listado=mysqli_query($conexion,"SELECT cliente_nombre,cliente_cuota_total,cliente_monto,cliente_interes FROM clientes,ordenes WHERE ordenes_estado='si' AND MONTH(ordenes_fecha_pagada)='$mesActual' AND cliente_id=ordenes_id_cliente AND cliente_usuario='".$_SESSION['usuario_id']."'") or die(mysqli_error($conexion));
?>
<div class="jumbotron">
	<div class="container">
	    <h3>Detalles Capital Mensual</h3>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Capital mensual</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				while ($row=mysqli_fetch_array($listado)) { 
					$capitalMensual=$row["cliente_cuota_total"]-(($row["cliente_monto"]*$row["cliente_interes"])/100);
					?>
					<tr>
						<td><?php echo $row["cliente_nombre"]; ?></td>
						<td><?php echo "$ ".$capitalMensual; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
