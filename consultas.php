<?php 
include ('librerias/conexion.php');
function mostrarMonto($id){


	echo "ohola";
$buscaOrdenes=mysqli_query($conexion,"SELECT ordenes_monto FROM ordenes WHERE ordenes_id_cliente='$id' ORDER BY ordenes_fecha DESC LIMIT 1") or die(mysqli_error($conexion));
					$resultado=mysqli_fetch_array($buscaOrdenes);
						return $resultado["ordenes_monto"];
	//echo "hola loco";
}

echo mostrarMonto(43);

 ?>