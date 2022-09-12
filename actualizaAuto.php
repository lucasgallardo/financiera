<?php
	require_once("librerias/conexion.php");
	$result = mysqli_query($conexion,"UPDATE autos set " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  auto_id=".$_POST["id"]) or die(mysqli_error($conexion));
	
?>