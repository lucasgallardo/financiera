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

  <link rel="stylesheet" href="css/autocomplete.css">
  <link rel="stylesheet" href="css/jquery-ui.css">

  <script type="text/javascript" src="js/calculador.js"></script>
  <script src="js/jquery-1.12.3.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script src="js/autocomplete.jquery.js"></script>
  
  <script>
       $(function() {
   
//Array para dar formato en español
 $.datepicker.regional['es'] = 
 {
 closeText: 'Cerrar', 
 prevText: 'Previo', 
 nextText: 'Próximo',
 
 monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
 'Jul','Ago','Sep','Oct','Nov','Dic'],
 monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
 dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
 dateFormat: 'dd/mm/yy', firstDay: 0, 
 initStatus: 'Selecciona la fecha', isRTL: false};
$.datepicker.setDefaults($.datepicker.regional['es']);

//miDate: fecha de comienzo D=días | M=mes | Y=año
//maxDate: fecha tope D=días | M=mes | Y=año
   $( "#datepicker" ).datepicker();
 });
  </script>

  <script>
    $(document).ready(function(){
        /* Una vez que se cargo la pagina , llamo a todos los autocompletes y
        * los inicializo */
        $('.autocomplete').autocomplete();
      });
    </script>

  </head>
  <body>
    <?php echo panel("clienteNuevo"); ?>

    <div class="container-fluid">
     <?php  
     if (isset($_POST['guardar'])) {
      $nombre = mysqli_real_escape_string($conexion,$_POST['nombre']);
      $dni = mysqli_real_escape_string($conexion,$_POST['dni']);
      $direccion = mysqli_real_escape_string($conexion,$_POST['direccion']);      
      $telefonoFijo = mysqli_real_escape_string($conexion,$_POST['telefonoFijo']);
      $celular = mysqli_real_escape_string($conexion,$_POST['celular']);      
      $modelo = mysqli_real_escape_string($conexion,$_POST['modelo']);
      $patente = mysqli_real_escape_string($conexion,$_POST['patente']);
      $anio = mysqli_real_escape_string($conexion,$_POST['anio']);
      $numerodecuotas = mysqli_real_escape_string($conexion,$_POST['cuotas']);
      $monto =mysqli_real_escape_string($conexion,$_POST['monto']);
      $interes = mysqli_real_escape_string($conexion,$_POST['interes']);
      $cuotaTotal = mysqli_real_escape_string($conexion,$_POST['cuotaTotal']);
      $fecha = fechaDB(mysqli_real_escape_string($conexion,$_POST['fechaInicio']));
      $agencia = mysqli_real_escape_string($conexion,$_POST['agencia']);
      $fechaAlta = date('Y-m-d');
      
    //busco modelo de auto
    // or die(mysqli_error($conexion));    
      if ($buscador=mysqli_query($conexion,"SELECT auto_id,auto_modelo FROM autos WHERE auto_modelo='$modelo'")) {
        $coincidencias=mysqli_num_rows($buscador);
        if ($coincidencias<1) {          
          $guardoModelo=mysqli_query($conexion,"INSERT INTO autos (auto_modelo) VALUES ('$modelo')") or die(mysqli_error($conexion));
          $buscador=mysqli_query($conexion,"SELECT auto_id,auto_modelo FROM autos WHERE auto_modelo ='$modelo'") or die(mysqli_error($conexion));
        }
        $row=mysqli_fetch_array($buscador);
        $modelo = $row['auto_id'];
      }

      //busca agencia
      if ($buscador2=mysqli_query($conexion,"SELECT agencia_id,agencia_nombre FROM agencias WHERE agencia_nombre='$agencia'")) {
        $coincidencias2=mysqli_num_rows($buscador2);
        if ($coincidencias2<1) {          
          $guardoAgencia2=mysqli_query($conexion,"INSERT INTO agencias (agencia_nombre) VALUES ('$agencia')") or die(mysqli_error($conexion));
          $buscador2=mysqli_query($conexion,"SELECT agencia_id,agencia_nombre FROM agencias WHERE agencia_nombre ='$agencia'") or die(mysqli_error($conexion));
        }
        $row2=mysqli_fetch_array($buscador2);
        $agencia = $row2['agencia_id'];
      }

      $guarda=mysqli_query($conexion,"INSERT INTO 
        clientes(cliente_nombre,cliente_dni,cliente_direccion,cliente_fijo,cliente_celular,cliente_idAuto,cliente_idAgencia,cliente_cuotas,cliente_monto,cliente_interes,cliente_patente,cliente_anio,cliente_cuota_total,cliente_inicio,cliente_usuario,cliente_estado,cliente_alta) 
        VALUES('$nombre','$dni','$direccion','$telefonoFijo','$celular','$modelo','$agencia','$numerodecuotas','$monto','$interes','$patente','$anio','$cuotaTotal','$fecha','".$_SESSION['usuario_id']."','no','$fechaAlta')");
      if($guarda){
        echo "<div class='alert alert-success'>Datos guardados correctamente</div>";
      }else{
        echo "<div class='alert alert-danger'>Error al guardar los datos: ".mysqli_error($conexion)."</div>";
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
    }
    ?>
    <div class="text-center">
      <h1>Cliente nuevo</h1>
      <p class="lead">Ingrese los datos del nuevo cliente</p>
    </div>
    <form class="form-horizontal" role="form" action="" method="POST">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Nombre:</label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre y Apellido" required autofocus>
            </div>
          </div>
          <div class="form-group">
            <label for="direccion" class="col-md-4 control-label">DNI:</label>
            <div class="col-md-8">
              <input type="number" class="form-control" id="dni" name="dni" placeholder="D.N.I.">
            </div>
          </div>
          <div class="form-group">
            <label for="direccion" class="col-md-4 control-label">Dirección:</label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección">
            </div>
          </div>
          <div class="form-group">
            <label for="telefonoFijo" class="col-md-4 control-label">Teléfono Fijo:</label>
            <div class="col-md-8">
              <input type="number" class="form-control" id="telefonoFijo" name="telefonoFijo" placeholder="Teléfono Fijo">
            </div>
          </div>          
          <div class="form-group">
            <label for="celular" class="col-md-4 control-label">Celular:</label>
            <div class="col-md-8">
              <input type="number" class="form-control" id="celular" name="celular" placeholder="Teléfono Celular">
            </div>
          </div>          
        </div>

        <div class="col-md-4">
         <div class="form-group">
          <div class="autocomplete">
            <label for="modelo" class="col-md-4 control-label">Modelo de Auto:</label>
            <div class="col-md-8">
              <input  type="text" class="form-control" name="modelo" autocomplete="off" placeholder="Modelo de Auto" value="" data-source="buscadorAuto.php?search=" />
            </div>
          </div>
        </div>     
        <div class="form-group">
          <label for="text" class="col-md-4 control-label">Patente:</label>
          <div class="col-md-8">
            <input type="text" class="form-control" id="patente" name="patente" placeholder="Patente del Auto">
          </div>
        </div>    
        <div class="form-group">
          <label for="celular" class="col-md-4 control-label">Año:</label>
          <div class="col-md-8">
            <input type="number" class="form-control" id="anio" name="anio" placeholder="Año del auto">
          </div>
        </div>
        <div class="form-group">
          <label for="celular" class="col-md-4 control-label"><abbr title="Fecha de la primer cuota">Fecha de Inicio:</abbr></label>
          <div class="col-md-8">
            <input type="text" class="form-control" id="datepicker" name="fechaInicio" placeholder="Fecha de inicio">
          </div>
        </div>
        <div class="form-group">
          <div class="autocomplete">
            <label for="modelo" class="col-md-4 control-label">Agencia:</label>
            <div class="col-md-8">
              <input  type="text" class="form-control" name="agencia" autocomplete="off" placeholder="Agencia" value="" data-source="buscadorAgencia.php?search=" />
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="interes" class="col-md-4 control-label">Porcentaje Interés:</label>
          <div class="col-md-8">
            <input type="number" step="any" class="form-control" id="interes" onkeyup="calculaCuota()" name="interes" placeholder="Porcentaje de Interés">
          </div>
        </div>
        <div class="form-group">
          <label for="monto" class="col-md-4 control-label">Monto a Financiar:</label>
          <div class="col-md-8">
            <input type="number" class="form-control" id="monto" onkeyup="calculaCuota()" name="monto" placeholder="Monto a Prestar">
          </div>
        </div>
        <div class="form-group">
          <label for="cuotas" class="col-md-4 control-label">N° de Cuotas:</label>
          <div class="col-md-8">
            <input type="number" class="form-control" id="cuotas" onkeyup="calculaCuota()" name="cuotas" placeholder="Cantidad de Cuotas">
          </div>
        </div>   

        <div class="form-group">
          <label for="cuota" class="col-md-4 control-label">Valor de la Cuota:</label>
          <div class="col-md-8">
            <input type="text" class="form-control" id="cuotaTotal" name="cuotaTotal" placeholder="Cuota final" required>
          </div>
        </div>

      </div>
      <div class="text-right">
        <div class="form-group">
          <div class="col-md-10">
            <button type="submit" name="guardar" class="btn btn-info btn-lg">Guardar</button>
          </div>
        </div>
      </div>      
    </form>
  </div><!-- /.container -->

  <script src="js/bootstrap.min.js"></script>
  <?php
    } else {header ("Location: salir.php");}
  ?>
</body>
</html>