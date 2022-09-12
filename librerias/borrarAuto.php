<?php 
include ('conexion.php');
$buscoCliente=mysqli_query($conexion,"SELECT cliente_idAuto FROM clientes WHERE cliente_idAuto = '".$_REQUEST["Id"]."' ") or die(mysqli_error($conexion));
if(mysqli_num_rows($buscoCliente)>0){
	header("Location: ../autos.php?mensaje=error");
}else{
	$borraAuto=mysqli_query($conexion,"DELETE FROM autos WHERE auto_id='".$_REQUEST["Id"]."' ") or die(msyqli_error($conexion));
	header("Location: ../autos.php?mensaje=borrado");
}
?>