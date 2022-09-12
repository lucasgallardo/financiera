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
    if(isset($_POST['enviar'])) { // comprobamos que se hayan enviado los datos del formulario
      $usuario_nombre = mysqli_real_escape_string($conexion,$_POST['username']);
      $date=date('m-Y');
      $semilla = $usuario_nombre;
      $usuario_clave = crypt($usuario_clave,$semilla);

      $sql = mysqli_query($conexion,"SELECT user_id, user_name, user_email FROM usuarios WHERE user_name='$usuario_nombre'") or die(mysqli_error($conexion));
      if($row = mysqli_fetch_array($sql)) { 
        $token=crypt($usuario_nombre,$date);
        $user_id=$row["user_id"];
        $destinatario = $row["user_email"]; 
        $asunto = "Recuperar clave de $usuario_nombre"; 
        $cuerpo = ' 
        <html> 
        <head> 
         <title>Recuperación de clave</title> 
       </head> 
       <body> 
        <h1>Recuperación de clave</h1> 
        <p> 
        <b>Ingrese al siguiente link para ingresar una nueva clave</b>. http://financiera.96.lt/clave.php?tk='.$token.'&ui='.$user_id.'&uo='.$usuario_nombre.'
        </p> 
      </body> 
      </html> 
      '; 

//para el envío en formato HTML 
      $headers = "MIME-Version: 1.0\r\n"; 
      $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
      $headers .= "From: Lucas <lucagallardo@gmail.com>\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
//$headers .= "Reply-To: mariano@desarrolloweb.com\r\n"; 

//ruta del mensaje desde origen a destino 
//$headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 

//direcciones que recibián copia 
//$headers .= "Cc: maria@desarrolloweb.com\r\n"; 

//direcciones que recibirán copia oculta 
//$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

      mail($destinatario,$asunto,$cuerpo,$headers); 

                header("Location: index.php?mensaje=enviado"); //redirecciona a home
              }else { ?>

               <div class="alert alert-warning">Usuario inexistente</div>                    

               <?php }
             }
             ?>
             <div class="container">
              <form class="form-signin" action="" method="POST">
                <h2 class="form-signin-heading">Recuperar Clave</h2>
                <label for="inputEmail" class="sr-only">Usuario</label>
                <input type="text" id="usuario_nombre" name="username" class="form-control" placeholder="Nombre de usuario" required autofocus>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="enviar">Ingresar</button>
              </form>
            </div> <!-- /container -->


            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
          </body>
          </html>
