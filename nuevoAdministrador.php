<?php 
session_start();
include ('librerias/cabecera.php');
include ('librerias/conexion.php');
include ('librerias/operaciones.php');
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
		<?php echo panel("clientes"); ?>
		<div class="container-fluid">
		    <?php if (isset($_POST['guardo'])) {
				$pass=mysqli_real_escape_string($conexion, $_POST["contrasenia"]);
                $pass2=mysqli_real_escape_string($conexion, $_POST["recontrasenia"]);
                $contrasenia=crypt($pass,$_SESSION['usuario_nombre']);
                $idUser=$_SESSION['usuario_id'];
                $guardo=mysqli_query($conexion, "INSERT INTO super_usuario (su_user_id,su_pass,su_logueado) VALUE ('$idUser','$contrasenia','si')") or die(mysqli_error($conexion));
                header("Location: clientes.php");
                //exit;
			}
		    ?>
		    <?php echo "<div class='alert alert-danger text-center'>".$_SESSION['usuario_nombre']." todavia no crea su clave de administrador, cree una para poder borrar clientes</div>"; ?>
			<div class="row">
				<div class="col-xs-6 col-md-4"></div>
				<div class="col-xs-12 col-md-4">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h3 class="panel-title text-center">Nueva Clave Administrador</h3>
						</div>
						<div class="panel-body">
							<form class="form-inline" role="form" onSubmit="return validarPasswd()" action="" method="POST">
								<div class="form-group">
									<label class="sr-only" for="ejemplo_password">Contraseña</label>
									<input type="password" class="form-control" id="usuario_clave" name="contrasenia" placeholder="Contraseña" autofocus="">
									<input type="password" class="form-control" id="usuario_clave2" name="recontrasenia" placeholder="Contraseña">
								</div>
								<button type="submit" class="btn btn-success" name="guardo">Entrar</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-4"></div>
			</div>
		</div>
		<script src="js/bootstrap.min.js"></script>
		<?php
		
        } else {header ("Location: salir.php");}
		?>
	</body>
</html>