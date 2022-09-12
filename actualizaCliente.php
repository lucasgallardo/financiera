<?php
	require_once("librerias/conexion.php");
	$result = mysqli_query($conexion,"UPDATE clientes set " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  cliente_id=".$_POST["id"]) or die(mysqli_error($conexion));
	
	// echo $_POST["column"];
	// echo $_POST["editval"];
	// echo $_POST["id"];
	// echo "hola";
?>