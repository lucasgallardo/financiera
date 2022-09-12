<?php 
include ('conexion.php');
// $buscoCliente=mysqli_query($conexion,"SELECT cliente_idAuto FROM clientes WHERE cliente_idAuto = '".$_REQUEST["Id"]."' ") or die(mysqli_error($conexion));
// if(mysqli_num_rows($buscoCliente)>0){
// 	header("Location: ../clientes.php?mensaje=error");
// }else{
	$borraAuto=mysqli_query($conexion,"DELETE FROM clientes WHERE cliente_id='".$_REQUEST["Id"]."' ") or die(msyqli_error($conexion));
	$borrarOrdenes=mysqli_query($conexion,"DELETE FROM ordenes WHERE ordenes_id_cliente='".$_REQUEST["Id"]."' ") or die(mysqli_error($conexion));
	if(isset($_REQUEST["ir"]) and $_REQUEST["ir"]=='home'){
		header("Location: ../home.php?mensaje=borrado");
	}else{
		header("Location: ../clientes.php?mensaje=borrado");
	}
//}
?>