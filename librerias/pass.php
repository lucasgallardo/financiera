<?php 
include_once ('libreria/conexion.php');

 function claves()
 {
 	$busca = mysqli_query($conexion, "SELECT llave_valor FROM llaves") or die(mysql_error($conexion));
 	if ($row=mysqli_fetch_array($busca) {
 		$clave = $row("llave_valor");
 		return $clave;
 	}
 	
 }
?>