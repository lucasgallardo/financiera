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
    <script src="js/actualizaDatos.js"></script>

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
        var mensaje = "QUIERE BORRAR EL AUTO?";
        if(confirm(mensaje)){
          window.location="librerias/borrarAuto.php?Id="+id;
        }else{

        }
      }
    </script>

  </head>
  <body>
    <?php echo panel("autos"); ?>
    <div class="container-fluid">
    <?php
                  if(isset($_REQUEST['mensaje'])){
                    if ($_REQUEST['mensaje']=='borrado') {
                        //echo "<div class='alert alert-success cartel'>Datos actualizados correctamente</div>";
                        echo "<script>alertify.log(\"Dato borrado correctamente!\");</script>";   

                        
                   }elseif ($_REQUEST['mensaje']=='error') {
                        echo "<div class='alert alert-danger'>No se puede borrar un auto asociado a un cliente</div>";
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
                }
            }
            ?>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Autos</h3>
        </div>
        <div class="panel-body">
          <table class="table table-hover table-striped table-bordered">
            <thead>
              <tr>
                <th>Modelo de auto</th>
                <th>Administrar</th>
              </tr> 
            </thead>
            <tbody>
              <tr>
                <form action="librerias/guardaAuto.php" method="POST" >
                  <td><div class="form-group">
                    <div class="col-md-8">
                      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Modelo de auto" required autofocus>
                    </div>
                  </div>
                </td>
                <td><button type="submit" name="guardar" class="btn btn-success" >Guardar <span class="glyphicon glyphicon-save"></span></button></td>
              </form>
            </tr>
            <?php
            $rs = mysqli_query( $conexion,"SELECT auto_id,auto_modelo FROM autos ORDER BY auto_modelo ASC") or die(mysqli_error($conexion)); ?>

            <?php while ($resultado=mysqli_fetch_array($rs)) { ?>
              <tr>
                <td><div class="col-md-8">
                  <div class="campos" contenteditable="true" onBlur="guardaAuto(this,'auto_modelo','<?php echo $resultado['auto_id'] ?>')" onClick="showEdit(this);"><?php echo $resultado["auto_modelo"]; ?></div>
                  </div></td>                
                  <td><?php echo '<button class="btn btn-danger"><span class="glyphicon glyphicon-trash" onclick="eliminar('.$resultado['auto_id'].')"/></span></button>'; ?></td>
                  </tr>

<?php
} ?>
</tbody>                                
</table>
</div>
</div>
</div>
<script src="js/bootstrap.min.js"></script>
<?php
} else {header ("Location: salir.php");}
?>
</body>
</html>
