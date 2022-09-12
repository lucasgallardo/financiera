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
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/alertify.core.css" />
    <link rel="stylesheet" href="css/alertify.default.css" id="toggleCSS" />
    <script src="js/jquery-1.12.3.js"></script>

    <script type="text/javascript" src="js/alertify.min.js"></script>
    <script>
      function reset () {
        $("#toggleCSS").attr("href", "css/alertify.bootstrap.css");
        alertify.set({
          labels : {
            ok     : "OK",
            cancel : "Cancel"
          },
          delay : 5000,
          buttonReverse : false,
          buttonFocus   : "ok"
        });
      }
    </script>

    <script>
      function eliminar(id){
        var mensaje = "QUIERE BORRAR EL CLIENTE Y TODOS SUS PAGOS?";
        if(confirm(mensaje)){
          window.location="librerias/borrarCliente.php?Id="+id;
        }else{

        }
      }
    </script>
  </head>
  <body>
    <?php echo panel("clientes"); ?>
    <div class="container-fluid"> 
      <?php
      if(isset($_REQUEST['mensaje'])){
        if ($_REQUEST['mensaje']=='borrado') {
                        //echo "<div class='alert alert-success cartel'>Datos actualizados correctamente</div>";
          echo "<script>alertify.log(\"Dato borrado correctamente!\");</script>";   


        }elseif ($_REQUEST['mensaje']=='error') {
          echo "<div class='alert alert-danger'>No se pudo borrar la información del cliente</div>";
                    //echo "<script>alertify.error(\"Error al borrar los datos!\");</script>";   
          ?>
          <script type="text/javascript">
            $(".cartel").fadeTo(2000, 500).slideUp(500, function(){
              $(".cartel").alert('close');
            });
          </script>
          <?php
        }elseif($_REQUEST['mensaje']=='guardado'){
          echo "<script>alertify.success(\"DATO GUARDADO CORRECTAMENTE!\");</script>";
        }elseif ($_REQUEST['mensaje']=='errorContrasenia') {
            echo "<div class='alert alert-danger'>Contraseña erronea</div>";
        }
      }
      ?>
      <?php if (superUsuario($conexion,$_SESSION["usuario_id"])) { //comprueba que este logueado para borrar usuarios?>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Clientes</h3>
        </div>
        <div class="panel-body">
        <a href="adminSalir.php"><button class="btn btn-warning btn-sm">Salir</button></a>
          <table class="table table-hover table-striped table-bordered">
            <thead>
              <tr>
                <th>Nombre Del Cliente</th>
                <th>Borrar</th>
              </tr> 
            </thead>
            <tbody>
            <?php
            $rs = mysqli_query( $conexion,"SELECT cliente_id,cliente_nombre FROM clientes WHERE cliente_usuario='".$_SESSION["usuario_id"]."' ORDER BY cliente_id ASC") or die(mysqli_error($conexion)); ?>

            <?php while ($resultado=mysqli_fetch_array($rs)) { ?>
              <tr>
                <td><div class="col-md-8">
                  <a href="detallesCliente.php?accion=<?php echo $resultado['cliente_id'] ?>"><?php echo $resultado["cliente_nombre"]; ?></a>
                  </div></td>                
<td><?php echo '<button class="btn btn-danger"><span class="glyphicon glyphicon-trash" onclick="eliminar('.$resultado['cliente_id'].')"/></span></button>'; ?></td>
</tr>

<?php
} ?>
</tbody>                                
</table>
</div>
</div>
<?php }else{ //si no está logueado como administrador
  echo "<div class='alert alert-danger text-center'>".$_SESSION['usuario_nombre']." debe ingresar su clave de administrador</div>"; 
  if(existeClave($conexion,$_SESSION['usuario_id'])){
    echo "<div class='alert alert-danger text-center'>Todavía no define una clave de administrador, <a href='nuevoAdministrador.php'>defina una aquí</a></div>";
  }
  ?>
  <div class="row">
  <div class="col-xs-6 col-md-4"></div>
  <div class="col-xs-12 col-md-4">
    <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title text-center">Clave Administrador</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" role="form" action="su/loginSU.php" method="POST">          
            <div class="form-group">
              <label class="sr-only" for="ejemplo_password">Contraseña</label>
              <input type="password" class="form-control" id="ejemplo_password_2" name="contrasenia" placeholder="Contraseña">
            </div>            
            <button type="submit" class="btn btn-success">Entrar</button>
          </form>
        </div>
  </div>
  </div>
  <div class="col-xs-6 col-md-4"></div>
</div>

<?php } ?> 
</div>
<script src="js/bootstrap.min.js"></script>
<?php
} else {header ("Location: salir.php");}
?>
</body>
</html>
