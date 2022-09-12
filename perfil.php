<?php 
session_start();
include ('librerias/conexion.php');
include ('librerias/cabecera.php');

if(isset($_SESSION['usuario_nombre'])){
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <?php echo head(); ?>
    <script type="text/javascript">
        function validarPasswd(){
            var p1 = document.getElementById("usuario_clave").value;
            var p2 = document.getElementById("usuario_clave2").value;
            if (p1 != p2) {
              alert("Las contraseñas deben de coincidir");
              return false;
          } else {
            return true; 
        }
    }
</script>
  </head>
  <body>
  <?php echo panel("perfil"); ?>
    <div class="container-fluid">      
      <?php  
//hago la consulta para traer al usuario conectado en la sesion
      $consulta=mysqli_query($conexion,"SELECT * FROM usuarios WHERE user_id='".$_SESSION['usuario_id']."'") OR die(mysqli_error($conexion));
      $row=mysqli_fetch_array($consulta);
      $usuario_nombre = $row["user_name"];
      $usuario_correo = $row["user_email"];
      $usuario_clave = $row["user_pass"];


      if(isset($_POST['datos'])){
        $usuario_correo=mysqli_real_escape_string($conexion,$_POST['correo']);
        $usuario_nombre=mysqli_real_escape_string($conexion,$_POST['nombre']);
     
          $actualizo=mysqli_query($conexion,"UPDATE usuarios SET user_name='$usuario_nombre', user_email='$usuario_correo' WHERE user_id='".$_SESSION['usuario_id']."'") OR die(mysqli_error($conexion));
          if ($actualizo) {
            ?>
            <div class="alert alert-success">Datos actualizados correctamente!!</div>       
            <meta http-equiv="Refresh" content="2" url="perfil.php" />
            <?php               
          } else {
            ?>
            <div class="alert alert-danger">Error al guardar los datos</div>
            <?php
          }
      } 

  if (isset($_POST['submit'])) {

  //if (isset($_SESSION['usuario_nombre'])) { //compruebo que esté la sesion iniciada
    $usuario_clave_nueva = mysqli_real_escape_string($conexion,$_POST['passNueva']);
    $usuario_clave_confirmar = mysqli_real_escape_string($conexion,$_POST['passConfirmar']);

    if ($usuario_clave_nueva != $usuario_clave_confirmar) {
      ?>
      <div class="alert alert-danger">Las contraseñas no coinciden</div>
      <?php
    } else {
      //$usuario_nombre = $_SESSION['usuario_nombre'];
      //$usuario_clave_nueva = mysql_real_escape_string($_POST['passNueva']);
      $usuario_clave_nueva = crypt($usuario_clave_nueva,$usuario_nombre);
      $sql=mysqli_query($conexion,"UPDATE usuarios SET user_pass='".$usuario_clave_nueva."' WHERE user_id='".$$_POST['usuario_id']."'") or die(mysqli_error($conexion));
      if ($sql) {
        ?>
        <div class="alert alert-success">Contraseña actualizada correctamente!!</div>       
        <meta http-equiv="Refresh" content="2" url="perfil.php" />
        <?php               
      } else {
        ?>
        <div class="alert alert-danger">Error al actualizar la contraseña</div>
        <?php
      }

    }
  // } else {
  //   header('location:index.php');
  // }
} 

?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Datos de Usuario</h3>
  </div>
  <div class="panel-body">
    <p class="help-block">Modifique sus datos desde aquí.</p>
    <form action="" method="POST" class="form-horizontal" role="form">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Nombre:</label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre y Apellido" value="<?php echo $usuario_nombre; ?>" required autofocus>
            </div>
          </div>
          <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">E-mail:</label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo electrónico" value="<?php echo $usuario_correo; ?>">
            </div>
          </div>                          
          <div class="text-right">
            <div class="form-group">
              <div class="col-md-10">
                <button type="submit" name="datos" class="btn btn-primary">Guardar cambios</button>
              </div>
            </div>
          </div>
        </form>

        <form action="" method="POST" class="form-horizontal" role="form">
          <p class="help-block">Modifique su contraseña desde aquí.</p>
          <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Contraseña Nueva:</label>
            <div class="col-md-8">
              <input type="password" class="form-control" id="passNueva" name="passNueva" placeholder="Contraseña nueva">
            </div>
          </div>
          <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Confirmar Contraseña:</label>
            <div class="col-md-8">
              <input type="password" class="form-control" id="passConfirmar" name="passConfirmar" placeholder="Reingrese contraseña">
            </div>
          </div>
          <div class="text-right">
            <div class="form-group">
              <div class="col-md-10">
                <button type="submit" name="submit" class="btn btn-primary">Cambiar Contraseña</button>
              </div>
            </div>
          </div>
        </form>
        <hr>
        <a href="registro.php"> <button class="btn btn-default">Registrar nuevo usuario</button></a>
      </div>
    </div>



    <?php

  } else {header ("Location: salir.php");}
  ?>  
</body>
</html>