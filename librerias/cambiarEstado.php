<?php 
//modifica el estado de una cuota del mes actual
include ('conexion.php');

$idCliente = $_REQUEST['id'];
$mesActual=date('m');
$anioActual=date('Y');
$fechaActual=date('Y-m-d');

$buscaCuota=mysqli_query($conexion,"SELECT ordenes_estado FROM ordenes WHERE ordenes_id_cliente='$idCliente' AND MONTH(ordenes_fecha)='$mesActual' ") or die(mysqli_error($conexion));
    $row=mysqli_fetch_array($buscaCuota);
if ($row["ordenes_estado"]=='si') {
	$actualizo=mysqli_query($conexion,"UPDATE ordenes SET ordenes_estado='no' WHERE ordenes_id_cliente='$idCliente' AND MONTH(ordenes_fecha)='$mesActual' AND YEAR(ordenes_fecha)='$anioActual' ") or die(mysqli_error($conexion));
	header("Location: ../home.php?actualizado=si");
}elseif ($row["ordenes_estado"]=='no') {
	$actualizo=mysqli_query($conexion,"UPDATE ordenes SET ordenes_estado='si', ordenes_fecha_pagada='$fechaActual' WHERE ordenes_id_cliente='$idCliente' AND MONTH(ordenes_fecha)='$mesActual' AND YEAR(ordenes_fecha)='$anioActual'") or die(mysqli_error($conexion));
	header("Location: ../home.php?actualizado=si");
}

?>