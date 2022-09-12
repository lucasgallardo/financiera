<?php 
session_start();
include ('librerias/conexion.php');

$salir=mysqli_query($conexion, "UPDATE super_usuario SET su_logueado='no' WHERE su_user_id='".$_SESSION['usuario_id']."' ") or die(mysqli_error($conexion));

header('Location: clientes.php');
 ?>