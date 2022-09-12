<?php 
session_start();
include ('librerias/cabecera.php');
include ('librerias/conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <?php echo head(); ?>
  <!-- Custom styles for this template -->
  <link href="css/signin.css" rel="stylesheet">
</head>

<body>
  <?php
  if(isset($_REQUEST['mensaje'])){
    if ($_REQUEST['mensaje']=='actualizada') {
      echo "<div class='alert alert-success'>Clave actualizada, ingrese con su nueva clave</div>";

    }elseif ($_REQUEST['mensaje']=='enviado') {
      echo "<div class='alert alert-success'>Se envió un mail al correo asociado a su usuario para que pueda actualizar la clave</div>";
                //echo "<script>alertify.error(\"Error al actualizar los datos!\");</script>";   
    }
  }
  ?>
  <?php 
    if(isset($_POST['enviar'])) { // comprobamos que se hayan enviado los datos del formulario
      $usuario_nombre = mysqli_real_escape_string($conexion,$_POST['username']);
      $semilla = $usuario_nombre;
      $usuario_clave = mysqli_real_escape_string($conexion,$_POST['password']);
      $usuario_clave = crypt($usuario_clave,$semilla);

      //echo "$usuario_nombre | $usuario_clave";
            // comprobamos que los datos ingresados en el formulario coincidan con los de la BD
      $sql = mysqli_query($conexion,"SELECT user_id, user_name, user_pass FROM usuarios WHERE user_name='$usuario_nombre' AND user_pass='$usuario_clave'");
      if($row = mysqli_fetch_array($sql)) {
                $_SESSION['usuario_id'] = $row['user_id']; // creamos la sesion "usuario_id" y le asignamos como valor el campo usuario_id
                $_SESSION['usuario_nombre'] = $row["user_name"]; // creamos la sesion "usuario_nombre" y le asignamos como valor el campo usuario_nombre
                header("Location: home.php"); //redirecciona a home
              }else { ?>

               <div class="alert alert-warning">Usuario inexistente</div>                    

               <?php }
             }
             ?>
             <div class="container">
              <form class="form-signin" action="" method="POST">
                <h2 class="form-signin-heading">Ingresar</h2>
                <label for="inputEmail" class="sr-only">Usuario</label>
                <input type="text" id="usuario_nombre" name="username" class="form-control" placeholder="Nombre de usuario" required autofocus>
                <label for="inputPassword" class="sr-only">Contraseña</label>
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Contraseña" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="enviar">Ingresar</button>
              </form>
              <a href="recuperaClave.php">Olvidé mi contraseña</a>
            </div> <!-- /container -->


            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
          </body>
          </html>
