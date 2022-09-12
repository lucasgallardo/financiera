<?php 
include ('conexion.php');

if (isset($_POST['enviar'])) {
	$usuario_nombre=mysqli_real_escape_string($conexion,$_POST['usuario_nombre']);
	$usuario_clave=mysqli_real_escape_string($conexion,$_POST['password']);
	$usuario_clave2=mysqli_real_escape_string($conexion,$_POST['repassword']);
	$usuario_id=mysqli_real_escape_string($conexion,$_POST['idCliente']);
	$nueva_clave=crypt($usuario_clave,$usuario_nombre);

$actualizo=mysqli_query($conexion,"UPDATE usuarios SET user_pass='$nueva_clave' WHERE user_id='$usuario_id' AND user_name='$usuario_nombre'") or die(mysqli_error($conexion));
header('Location: ../index.php?mensaje=actualizada');
}
?>