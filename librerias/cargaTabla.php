<?php
include_once ('conexion.php');

	$consulta = mysqli_query($conexion, "SELECT * FROM clientes") or die(mysql_error($conexion));

	//guardamos en un array multidimensional todos los datos de la consulta
	$i=0;
	$tabla = "";
	
	while($row = mysqli_fetch_array($consulta))
	{
		$id = $row['cliente_id'];
		$link = "<a href='detalleCliente.php?accion=<?php echo $id; ?>'>Detalles</a>";
		$tabla.='{"nombre":"'.$link.'","direccion":"'.$row['cliente_direccion'].'","telefono":"'.$row['cliente_telefono'].'","pagado":"'.$row['cliente_pagado'].'"},';	
		$i++;
	}
	$tabla = substr($tabla,0, strlen($tabla) - 1);

	echo '{"data":['.$tabla.']}';	
	
?>