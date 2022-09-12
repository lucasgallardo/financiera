<?php
session_start();
include ('librerias/conexion.php');
if (isset($_SESSION['usuario_nombre'])) {
	$salir=mysqli_query($conexion, "UPDATE super_usuario SET su_logueado='no' WHERE su_user_id='".$_SESSION['usuario_id']."' ") or die(mysqli_error($conexion));
    session_destroy();
    header("location:index.php");
}  else {
	header("location:index.php");
    echo "Operación Incorrecta";
}

?>