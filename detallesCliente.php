<?php 
session_start();
include ('librerias/conexion.php');
include ('librerias/cabecera.php');
include ('librerias/operaciones.php');
if(isset($_SESSION['usuario_nombre'])){
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo head(); ?>
	<link rel="stylesheet" href="css/autocomplete.css"></link>
	<script src="js/actualizaDatos.js"></script>
	<script type="text/javascript" src="js/calculador.js"></script>
	<script src="js/jquery-1.12.3.js"></script>
	<script src="js/autocomplete.jquery.js"></script>  
	<script>
		$(document).ready(function(){
        /* Una vez que se cargo la pagina , llamo a todos los autocompletes y
        * los inicializo */
        $('.autocomplete').autocomplete();
    });
</script>
<script>
      function eliminar(id){
        var mensaje = "QUIERE BORRAR EL CLIENTE Y TODOS SUS PAGOS?";
        if(confirm(mensaje)){
          window.location="librerias/borrarCliente.php?Id="+id+"&ir=home";
        }else{

        }
      }
    </script>

</head>
<body>
	<?php echo panel("detallesCliente"); ?>
	<div class="container-fluid">

		<?php 
		$id = $_REQUEST['accion']; 
		$buscaCliente=mysqli_query($conexion,"SELECT * FROM clientes WHERE cliente_id='$id'") or die(mysqli_error($conexion));
		$reg=mysqli_fetch_array($buscaCliente);
		if ($_REQUEST['actualizado']=='si') {
			echo "<div class='alert alert-success cartel'>Datos actualizados correctamente</div>";
			?>
			<script type="text/javascript">
				$(".cartel").fadeTo(2000, 500).slideUp(500, function(){
					$(".cartel").alert('close');
				});
			</script>
			<?php
		}elseif ($_REQUEST['actualizado']=='no') {
			echo "<div class='alert alert-danger'>Error al actualizar los datos:</div>";
			?>
			<script type="text/javascript">
				$(".cartel").fadeTo(2000, 500).slideUp(500, function(){
					$(".cartel").alert('close');
				});
			</script>
			<?php
		}
		?>
		<?php echo comprobarEstado($id,$conexion);?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Datos Personales</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" method="POST">
					<div class="row">
						<div class="col-sm-6 col-lg-4">
							<div class="form-group">
								<label for="nombre" class="col-md-4 control-label">Nombre:</label>
								<div class="col-md-8">
									<div class="campos" contenteditable="true" onBlur="guardaCliente(this,'cliente_nombre','<?php echo $reg['cliente_id'] ?>')" onClick="showEdit(this);"><?php echo $reg['cliente_nombre'] ?></div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-4">
							<div class="form-group">
								<label for="nombre" class="col-md-4 control-label">DNI:</label>
								<div class="col-md-8">
									<div class="campos" contenteditable="true" onBlur="guardaCliente(this,'cliente_dni','<?php echo $reg['cliente_id'] ?>')" onClick="showEdit(this);"><?php echo $reg['cliente_dni'] ?></div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-4">
							<div class="form-group">
								<label for="nombre" class="col-md-4 control-label">Direcci??n:</label>
								<div class="col-md-8">
									<div class="campos" contenteditable="true" onBlur="guardaCliente(this,'cliente_direccion','<?php echo $reg['cliente_id'] ?>')" onClick="showEdit(this);"><?php echo $reg['cliente_direccion'] ?></div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-4">
							<div class="form-group">
								<label for="nombre" class="col-md-4 control-label">Tel??fono Fijo:</label>
								<div class="col-md-8">
									<div class="campos" contenteditable="true" onBlur="guardaCliente(this,'cliente_fijo','<?php echo $reg['cliente_id'] ?>')" onClick="showEdit(this);"><?php echo $reg['cliente_fijo'] ?></div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-4">
							<div class="form-group">
								<label for="nombre" class="col-md-4 control-label">Celular:</label>
								<div class="col-md-8">
									<div class="campos" contenteditable="true" onBlur="guardaCliente(this,'cliente_celular','<?php echo $reg['cliente_id'] ?>')" onClick="showEdit(this);"><?php echo $reg['cliente_celular'] ?></div>
								</div>
							</div>
						</div>
					</div><!-- /.row this actually does not appear to be needed with the form-horizontal -->
				</form>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Informaci??n Pr??stamo</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" action="actualizaMontos.php" role="form" method="POST">
					<div class="row">
				<?php //busco el model del auto
				$idAuto=$reg['cliente_idAuto'];
				$idAgencia=$reg['cliente_idAgencia'];
					//$buscaAuto=mysqli_query($conexion,"SELECT auto_modelo FROM autos WHERE auto_id='".$reg['cliente_idAuto']."'") or die(mysqli_error($conexion));
					//$encontrado=mysqli_fetch_array($buscaAuto);
				?>
				<div class="col-md-4">
					<div class="form-group">
						<div class="autocomplete">
							<label for="modelo" class="col-md-4 control-label">Modelo de Auto:</label>
							<div class="col-md-8">
								<input  type="text" class="form-control" name="modelo" autocomplete="off" placeholder="Modelo de Auto" value="<?php echo buscaAuto($idAuto,$conexion); ?>" data-source="buscadorAuto.php?search=" />
							</div>
						</div>
					</div>     
					<div class="form-group">
						<label for="text" class="col-md-4 control-label">Patente:</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="patente" name="patente" value="<?php echo $reg['cliente_patente'] ?>" placeholder="Patente del Auto">
						</div>
					</div>    
					<div class="form-group">
						<label for="celular" class="col-md-4 control-label">A??o:</label>
						<div class="col-md-8">
							<input type="number" class="form-control" id="anio" name="anio" value="<?php echo $reg['cliente_anio'] ?>" placeholder="A??o del auto">
						</div>
					</div>
					<div class="form-group">
			          <div class="autocomplete">
			            <label for="modelo" class="col-md-4 control-label">Agencia:</label>
			            <div class="col-md-8">
			              <input  type="text" class="form-control" name="agencia" autocomplete="off" placeholder="Agencia" value="<?php echo buscaAgencia($idAgencia,$conexion); ?>" data-source="buscadorAgencia.php?search=" />
			            </div>
			          </div>
			        </div>
				</div>
				

				<div class="col-md-4">
					<div class="form-group">
						<label for="interes" class="col-md-4 control-label">Inter??s:</label>
						<div class="col-md-8">
							<input type="number" step="any" class="form-control" id="interes" onkeyup="calculaCuota()" name="interes" value="<?php echo $reg['cliente_interes'] ?>" placeholder="Porcentaje de Inter??s">
						</div>
					</div>
					<div class="form-group">
						<label for="monto" class="col-md-4 control-label">Monto a Financiar:</label>
						<div class="col-md-8">
							<input type="number" class="form-control" id="monto" onkeyup="calculaCuota()" name="monto" value="<?php echo $reg['cliente_monto'] ?>" placeholder="Monto a Prestar">
						</div>
					</div>
					<div class="form-group">
						<label for="cuotas" class="col-md-4 control-label">N?? de Cuotas:</label>
						<div class="col-md-8">
							<input type="number" class="form-control" id="cuotas" onkeyup="calculaCuota()" name="cuotas" value="<?php echo $reg['cliente_cuotas'] ?>" placeholder="Cantidad de Cuotas">
						</div>
					</div>   

					<div class="form-group">
						<label for="cuota" class="col-md-4 control-label">Valor de la Cuota:</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="cuotaTotal" name="cuotaTotal" value="<?php echo $reg['cliente_cuota_total'] ?>" placeholder="Cuota final" required>
						</div>
					</div>
				</div>

				<input type="hidden" name="cliente_id" value="<?php echo $reg['cliente_id'] ?>">
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<div class="col-md-8">
							<button type="submit" name="actualizar" class="btn btn-info">Guardar</button>
						</div>
					</div>
				</div>     
			</div>
		</form>
	</div>
</div>
<div class="panel panel-primary" id="pagos">
	<div class="panel-heading">
		<h3 class="panel-title">Pagos mensuales</h3>
	</div>
	<div class="panel-body">
		<?php 
		$buscaOrdenes = mysqli_query($conexion,"SELECT * FROM ordenes WHERE ordenes_id_cliente = '$id'") or die(mysqli_error($conexion)); ?>
		<div class="row show-grid">
			<?php while ($row=mysqli_fetch_array($buscaOrdenes)) { ?>
				<div class="col-md-1"><?php 
					echo "Pago: ".$row['ordenes_numero']."<br>";
					echo "Monto: ".$row['ordenes_monto']."<br>";
					echo "<a href='librerias/modificarEstado.php?accion=".$row['ordenes_id']."'>".mostrarEstado($row['ordenes_estado'])."</a><br>";					
					echo "<br>";
					echo transformaFecha($row['ordenes_fecha']);
					?></div>
					<?php }
					?>
				</div>
			</div>
		</div>
		<hr>
	<!--<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Borrar Informaci??n del cliente y sus respectivos pagos</h3>
			</div>
			<div class="panel-body">
			<?php //echo '<button class="btn btn-danger">Borrar <span class="glyphicon glyphicon-trash" onclick="eliminar('.$reg['cliente_id'].')"/></span></button>'; ?>
	<!--	</div>
		</div> -->
		
		<script src="js/bootstrap.min.js"></script>
<?php
} else {header ("Location: salir.php");}
?>
	</body>
	</html>
