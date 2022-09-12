<?php 
include ('conexion.php');
$mesActual=date('m');
$anioActual=date('Y');
$fechaActual=date('Y-m-d');

if (isset($_POST["guardar"]) and isset($_POST["seleccionados"])) {
	$idOrden = $_POST['seleccionados'];

	foreach ($idOrden as $id) {
		$actualizaCuotas=mysqli_query($conexion,"UPDATE ordenes SET ordenes_estado='si',ordenes_fecha_pagada='$fechaActual' WHERE MONTH(ordenes_fecha)='$mesActual' AND YEAR(ordenes_fecha)='$anioActual' AND ordenes_id_cliente='$id' ") or die(mysqli_error($conexion));
		header("Location: ../home.php?actualizado=si");
	}
}else{
	header("Location: ../home.php?actualizado=no");
}

?>