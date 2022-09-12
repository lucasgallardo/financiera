<?php
session_start();
include ('../librerias/conexion.php');

if (isset($_POST['contrasenia'])) {
    $pass=crypt($_POST['contrasenia'],$_SESSION['usuario_nombre']);
    
	$buscoUsuario=mysqli_query($conexion,"SELECT su_user_id,su_pass FROM super_usuario WHERE su_user_id='".$_SESSION["usuario_id"]."' ") or die(mysqli_error($conexion));
    $row=mysqli_fetch_array($buscoUsuario);
    if (mysqli_num_rows($buscoUsuario)<1) {
        header('Location: ../nuevoAdministrador.php');
    }else{
        $buscoPass=mysqli_query($conexion,"SELECT su_user_id,su_pass FROM super_usuario WHERE su_pass='$pass' AND su_user_id='".$_SESSION["usuario_id"]."' ") or die(mysqli_error($conexion));
        if(mysqli_num_rows($buscoPass)<1){
            header('Location: ../clientes.php?mensaje=errorContrasenia');
        }else{
            $guardoEstado= mysqli_query($conexion, "UPDATE super_usuario SET su_logueado='si' WHERE su_user_id='".$_SESSION['usuario_id']."' ") or die(mysqli_error($conexion));
            header('Location: ../clientes.php');
        }
    }
}
?>