<?php 
include ('conexion.php');

if (isset($_POST["guardar"])) {
            $nombreAuto=mysqli_real_escape_string($conexion,$_POST['nombre']);
            $save=mysqli_query($conexion,"INSERT INTO autos(auto_modelo) VALUES ('$nombreAuto')") or die(mysqli_error($conexion));
            //if(mysqli_affected_rows($save)>0){
                header("Location: ../autos.php?mensaje=guardado");
            //}
          }

 ?>