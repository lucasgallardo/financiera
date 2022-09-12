<?php
session_start();
include ('librerias/conexion.php');
include ('librerias/cabecera.php')
?>

<!DOCTYPE html>
<html>
<head>
<?php echo head(); ?>
    
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
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
    <?php echo panel("registro"); ?>
        <div class="container-fluid">


    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Usuario Nuevo</h3>
    </div>
    <div class="panel-body">

        <div class="panel-body">
        </div>

        <?php
        if (isset($_POST['submit'])) {
          $usuario_nombre = mysqli_real_escape_string($conexion,$_POST['usuario_nombre']);
          $usuario_email = mysqli_real_escape_string($conexion,$_POST['usuario_email']);
          $usuario_clave = mysqli_real_escape_string($conexion,$_POST['usuario_clave']);
          $usuario_tipo = mysqli_real_escape_string($conexion,$_POST['usuario_tipo']);
         //comprueba que el usuario no esté repetido
          $sql = mysqli_query($conexion,"SELECT user_name FROM usuarios WHERE user_name='$usuario_nombre'") or die(mysqli_error($conexion));

          if (mysqli_num_rows($sql)>0) {
            ?>
            <div class="alert alert-info">El nombre de usuario elegido ya existe</div>
            <?php

        } else {
            // if($usuario_tipo=='Administrador'){
            //     $usuario_tipo=1;
            // }elseif($usuario_tipo=='Cajero'){
            //     $usuario_tipo=2;
            // }
            $usuario_tipo=1;
            $semilla = $usuario_nombre;
            $usuario_clave = crypt($usuario_clave,$semilla);
            $reg = mysqli_query($conexion,"INSERT INTO usuarios(user_name,user_pass,user_type) VALUES ('$usuario_nombre','$usuario_clave','$usuario_tipo')") or die(mysqli_error($conexion));
            if ($reg) {
                ?>
                <div class="alert alert-success">Usuario creado correctamente!!</div>       
                <meta http-equiv="Refresh" content="2" url="home.php" />
                <?php               
            } else {
                ?>
                <div class="alert alert-danger">Error al guardar los datos</div>
                <?php
            }   
        }
    } 
    ?>

    <form method="POST" onSubmit="return validarPasswd()" class="form-horizontal" action="" role="form">
        <div class="col-md-6">
            <div class="form-group">
                <label for="nombre" class="col-md-4 control-label">Nombre de usuario:</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" id="nombre" name="usuario_nombre" placeholder="Nombre de Usuario" required autofocus>
              </div>
          </div>
          <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Correo Electrónico:</label>
            <div class="col-md-8">
              <input type="email" class="form-control" id="nombre" name="usuario_email" placeholder="Correo electrónico">
          </div>
      </div>
            <!-- <div class="form-group">
                <label for="text" class="col-lg-2 control-label">Tipo de usuario: </label>
                <div class="col-xs-3">
                    <select class="form-control" name="usuario_tipo">
                        <option selected="selected">Administrador</option>
                        <option>Cajero</option>                        
                    </select>  
                </div>
            </div> -->
            <div class="form-group">
                <label for="pass1" class="col-md-4 control-label">Contraseña: </label>
                <div class="col-md-8">
                    <input type="password" class="form-control" id="usuario_clave" name="usuario_clave" required="" placeholder="Contraseña">
                </div>
            </div>
            <div class="form-group">
                <label for="pass1" class="col-md-4 control-label">Reingresar Contraseña: </label>
                <div class="col-md-8">
                    <input type="password" class="form-control" id="usuario_clave2" name="usuario_clave2" required="" placeholder="Contraseña">
                </div>
            </div>
            <div class="text-right">
                <div class="form-group">
                  <div class="col-md-10">
                    <button type="submit" name="submit" class="btn btn-info btn-lg">Registrarse</button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>

<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>