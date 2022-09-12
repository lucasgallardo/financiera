<?php
/// aqui puedo hacer invocaciones a la base de datos o lo que se me ocurra
$id=$_POST['id'];

	echo "hola mundo";

?>
<?php 

//modifica el estado de cualquier cuota, independiente de la fecha
// include_once ('conexion.php');
// $fechaActual=date('Y-m-d');
// $idOrdenes= $_REQUEST['accion'];
// //busco estado de la orden y cambio su estado
// $buscoOrden= mysqli_query($conexion,"SELECT ordenes_estado FROM ordenes WHERE ordenes_id='$idOrdenes' ") or die("Buscar orden ".mysqli_error($conexion));
// $reg=mysqli_fetch_array($buscoOrden);
// //dependiendo del estado en el que esté, lo modifico
// if ($reg["ordenes_estado"]=='no') {
// 	$actualiza= mysqli_query($conexion,"UPDATE ordenes SET ordenes_estado='si', ordenes_fecha_pagada='$fechaActual' WHERE ordenes_id='$idOrdenes' ") or die(mysqli_error($conexion));
// }elseif ($reg["ordenes_estado"]=='si') {
// 	$actualiza= mysqli_query($conexion,"UPDATE ordenes SET ordenes_estado='no', ordenes_fecha_pagada=null WHERE ordenes_id='$idOrdenes' ") or die(mysqli_error($conexion));
// }
// //busco id cliente para enviarlo como parametro
// $buscoCliente= mysqli_query($conexion,"SELECT cliente_id FROM ordenes,clientes WHERE ordenes_id='$idOrdenes' AND ordenes_id_cliente=cliente_id") or die(mysqli_query($conexion));
// $row=mysqli_fetch_array($buscoCliente);
// $cliente_id=$row['cliente_id'];
// header("Location: ../detallesCliente.php?accion=$cliente_id#pagos");

?>