<?php include('librerias/cabecera.php') ?>
<!DOCTYPE html>
<html>
  <head>
  <?php echo head(); ?>
   <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
     <script type="text/javascript">
        function validarPasswd(){
            var p1 = document.getElementById("password").value;
            var p2 = document.getElementById("repassword").value;
            if (p1 != p2) {
              alert("Las contraseñas deben de coincidir");
              return false;
          } else {
            return true; 
        }
    }
</script> 
  </head>

<?php 
$usuario_nombre=$_REQUEST['uo'];
$user_id=$_REQUEST['ui'];
$date=date('m-Y');
$tk=$_REQUEST['tk'];
$token=crypt($usuario_nombre,$date);
if ($tk==$token) { ?>
	<div class="container">
            <form class="form-signin" action="librerias/actualizaClave.php" method="POST">
              <h2 class="form-signin-heading">Ingresar Nueva Contraseña</h2>
              <label for="inputEmail" class="sr-only">Contraseña</label>
              <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Contraseña" required autofocus>
              <label for="inputPassword" class="sr-only">Reingrese Contraseña</label>
              <input type="password" id="inputPassword2" name="repassword" class="form-control" placeholder="Reingrese Contraseña" required>
              <input type="hidden" name="idCliente" value="<?php echo $user_id; ?>">
              <input type="hidden" name="usuario_nombre" value="<?php echo $usuario_nombre; ?>"> 
              <button class="btn btn-lg btn-primary btn-block" type="submit" name="enviar">Ingresar</button>
            </form>
          </div> <!-- /container -->
<?php }else{
	header('Location:index.php');
} ?>

</html>