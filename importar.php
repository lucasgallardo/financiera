<?php
include ('librerias/conexion.php');
//obtenemos el archivo .csv
$tipo = $_FILES['archivo']['type'];
 
$tamanio = $_FILES['archivo']['size'];
 
$archivotmp = $_FILES['archivo']['tmp_name'];
 
//cargamos el archivo
$lineas = file($archivotmp);
 
//inicializamos variable a 0, esto nos ayudará a indicarle que no lea la primera línea
$i=0;
 
//Recorremos el bucle para leer línea por línea
foreach ($lineas as $linea_num => $linea)
{ 
   //abrimos bucle
   /*si es diferente a 0 significa que no se encuentra en la primera línea 
   (con los títulos de las columnas) y por lo tanto puede leerla*/
   if($i != 0) 
   { 
       //abrimos condición, solo entrará en la condición a partir de la segunda pasada del bucle.
       /* La funcion explode nos ayuda a delimitar los campos, por lo tanto irá 
       leyendo hasta que encuentre un ; */
       $datos = explode(";",$linea);
 
       //Almacenamos los datos que vamos leyendo en una variable
       $modelo = trim($datos[1]);
       $patente = trim($datos[2]);
       $usuarioAgencia = trim($datos[3]);
       $diaVencimiento = trim($datos[4]);
       $monto = trim($datos[5]);
       $numerodecuotas = trim($datos[6]);
       $nombre = trim($datos[10]);
       //$fechaImportada = trim($datos[14]);
       $interes = 4.2;//trim($datos[15]);
       $dni ="";
       $direccion ="";
       $telefonoFijo ="";
       $celular = "";
       $anio = "";
       //transformo fecha*******************************//
      $fecha = date('Y-m-d');
      //*************************************************//
      if ($usuarioAgencia=='JOSE ' or $usuarioAgencia=='JOSE') {
        $usuarioAgencia="jose";
      }elseif ($usuarioAgencia=='JUAN') {
        $usuarioAgencia="juan";
      }else{
        $usuarioAgencia="alberto";
      }
      echo "usuario: $clienteUsuario <br>";
      //*******************************************************************************//
      //calculo valor de la cuota
      $valorCuota = $monto/$numerodecuotas;
      $valorInteres = ($monto * $interes)/100;
      $cuotaTotal = round($valorCuota+$valorInteres,0,PHP_ROUND_HALF_EVEN);

       //*************************************************************************************//
       //busco modelo de auto
      if ($buscador=mysqli_query($conexion,"SELECT auto_id,auto_modelo FROM autos WHERE auto_modelo='$modelo'")) {
        $coincidencias=mysqli_num_rows($buscador);
        if ($coincidencias<1) {          
          $guardoModelo=mysqli_query($conexion,"INSERT INTO autos (auto_modelo) VALUES ('$modelo')") or die(mysqli_error($conexion)) or die(mysqli_error($conexion));
          $buscador=mysqli_query($conexion,"SELECT auto_id,auto_modelo FROM autos WHERE auto_modelo ='$modelo'") or die(mysqli_error($conexion));          
        }
        $row=mysqli_fetch_array($buscador);
        $modelo = $row['auto_id'];
      }

      //************************************************************************//
      //busco usuario
      $buscador=mysqli_query($conexion,"SELECT user_id FROM usuarios WHERE user_name='$usuarioAgencia'") or die(mysqli_error($conexion));
        // $coincidencias=mysqli_num_rows($buscador);
        // if ($coincidencias<1) {          
        //   $guardoModelo=mysqli_query($conexion,"INSERT INTO autos (auto_modelo) VALUES ('$modelo')") or die(mysqli_error($conexion)) or die(mysqli_error($conexion));
        //   $buscador=mysqli_query($conexion,"SELECT auto_id,auto_modelo FROM autos WHERE auto_modelo ='$modelo'") or die(mysqli_error($conexion));          
        // }
        $row=mysqli_fetch_array($buscador);
        $clienteUsuario = $row['user_id'];

      //*****************************************************************************//

      $guarda=mysqli_query($conexion,"INSERT INTO 
        clientes(cliente_nombre,cliente_dni,cliente_direccion,cliente_fijo,cliente_celular,cliente_idAuto,cliente_cuotas,cliente_monto,cliente_interes,cliente_patente,cliente_anio,cliente_cuota_total,cliente_inicio,cliente_usuario,cliente_estado,cliente_dia_vencimiento) 
        VALUES('$nombre','$dni','$direccion','$telefonoFijo','$celular','$modelo','$numerodecuotas','$monto','$interes','$patente','$anio','$cuotaTotal','$fecha','$clienteUsuario','no',$diaVencimiento)") or die(mysqli_error($conexion));
      if($guarda){
        echo "Datos guardados correctamente $nombre - Dato n°: $i<br>";
      }else{
        echo "Error al guardaar los datos de $nombre<br>";
      }
      $buscaId=mysqli_query($conexion,"SELECT * FROM clientes ORDER BY cliente_id DESC LIMIT 1") or die(mysqli_error($conexion));
      $row=mysqli_fetch_array($buscaId);      
      $cliente_id=$row['cliente_id'];
      $cuotas=$row["cliente_cuotas"];
      $monto=$row['cliente_monto'];
      //$fecha=date('Y-m-d');

      for ($i=1; $i <= $cuotas; $i++) { 
        $guarda=mysqli_query($conexion,"INSERT INTO ordenes (ordenes_id_cliente,ordenes_monto,ordenes_fecha,ordenes_estado,ordenes_numero) VALUES ('$cliente_id','$cuotaTotal','$fecha','no','$i')") or die(mysqli_error($conexion));
        $nuevafecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
        $fecha = date ( 'Y-m-d' , $nuevafecha );
      }
 
       //guardamos en base de datos la línea leida
       //mysql_query("INSERT INTO datos(nombre,edad,profesion) VALUES('$nombre','$edad','$profesion')");
 
       //cerramos condición
   }
 
   /*Cuando pase la primera pasada se incrementará nuestro valor y a la siguiente pasada ya 
   entraremos en la condición, de esta manera conseguimos que no lea la primera línea.*/
   $i++;
   //cerramos bucle
}

      
    
?>