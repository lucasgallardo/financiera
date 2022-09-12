<?php 
include ('librerias/conexion.php');

if (isset($_POST['actualizar'])) {
	$id=$_POST['cliente_id'];
	$modelo = mysqli_real_escape_string($conexion,$_POST['modelo']);
	$numerodecuotas = mysqli_real_escape_string($conexion,$_POST['cuotas']);
	$monto =mysqli_real_escape_string($conexion,$_POST['monto']);
	$interes = mysqli_real_escape_string($conexion,$_POST['interes']);
	$cuotaTotal = mysqli_real_escape_string($conexion,$_POST['cuotaTotal']);
    $agencia = mysqli_real_escape_string($conexion,$_POST['agencia']);


		      	//busco modelo de auto
			    // or die(mysqli_error($conexion));    
	if ($buscador=mysqli_query($conexion,"SELECT auto_id,auto_modelo FROM autos WHERE auto_modelo='$modelo'")) {
		$coincidencias=mysqli_num_rows($buscador);
		if ($coincidencias<1) {          
			$guardoModelo=mysqli_query($conexion,"INSERT INTO autos (auto_modelo) VALUES ('$modelo')") or die(mysqli_error($conexion)) or die(mysqli_error($conexion));
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

				//actualizo datos del cliente
	$actualizo=mysqli_query($conexion,"UPDATE clientes SET cliente_cuotas='$numerodecuotas',cliente_monto='$monto',cliente_interes='$interes',cliente_idAuto='$modelo',cliente_cuota_total='$cuotaTotal', cliente_idAgencia='$agencia' WHERE cliente_id='$id' ") or die(mysqli_error($conexion));

				//actualizo cuotas si se modificó el precio
	if ($cuotaTotal!=$reg['cliente_cuota_total']) {
		$consulta=mysqli_query($conexion,"UPDATE ordenes SET ordenes_monto='$cuotaTotal' WHERE ordenes_id_cliente='$id' AND ordenes_estado='no' ") or die(mysqli_error($conexion));
	}
	if($actualizo){
			        //echo "<div class='alert alert-success'>Datos actualizados correctamente</div>"; 
					//echo "<META HTTP-EQUIV='REFRESH' CONTENT='2;URL=detallesCliente.php?accion=".$id."'>";
					//echo "actualizado correctamente";
		header("Location: detallesCliente.php?accion=$id&actualizado=si");
	}else{
		header("Location: detallesCliente.php?accion=$id&actualizado=no");
	}

}				
?>
