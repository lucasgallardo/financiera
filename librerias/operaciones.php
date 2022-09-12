<?php 

function transformaFecha($date){

    $dia = explode("-", $date, 3);
    $year = $dia[0];
    $month = (string) (int) $dia[1];
    $day = (string) (int) $dia[2];

    $dias = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
    $tomadia = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

    $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

    return $day . "-" . $month . "-" . $year;
}
function fechaDB($fecha){
    $date = explode("/", $fecha, 3);
    $year = $date[2];
    $month = $date[1];
    $day = $date[0];

    return  $year."-".$month."-".$day;
}

function mostrarEstado($estado){
	if ($estado=="si") {
		//return "<div class='alert alert-success' style='font-size: 10px;'>Pagado</div>";
        return "<button type='button' class='btn btn-success' id='btn-pagar'>Pagado</button>";
	}else{
		//return "<div class='alert alert-warning' style='font-size: 10px;'>Sin pagar</div>";
        return "<button type='button' class='btn btn-warning' id='btn-pagar'>Sin pagar</button>";
	}
}

function buscaAuto($idAuto,$conexion){
    $buscaAuto=mysqli_query($conexion,"SELECT auto_modelo FROM autos WHERE auto_id='$idAuto'") or die(mysqli_error($conexion));
    $encontrado=mysqli_fetch_array($buscaAuto);
    return $encontrado["auto_modelo"];
}

function buscaAgencia($idAgencia,$conexion){
    $buscaAgencia=mysqli_query($conexion,"SELECT agencia_nombre FROM agencias WHERE agencia_id='$idAgencia'") or die(mysqli_error($conexion));
    $encontrado=mysqli_fetch_array($buscaAgencia);
    return $encontrado["agencia_nombre"];
}

function mostrarResumen($conexion,$usuario_id)
{    
    $mesActual=date('m');
    $buscarValores=mysqli_query($conexion,"SELECT cliente_monto,cliente_id,cliente_cuotas,cliente_cuota_total,cliente_interes FROM clientes WHERE cliente_usuario='$usuario_id' ") or die(mysqli_error($conexion));
    while($res=mysqli_fetch_array($buscarValores)){
        $totalPrestado=$totalPrestado+$res["cliente_monto"]; //suma el capital total prestado
        $clienteId=$res['cliente_id'];
        //busco las ordenes de un cliente 
        $buscaOrdenes=mysqli_query($conexion,"SELECT ordenes_monto FROM ordenes WHERE ordenes_id_cliente='$clienteId' AND MONTH(ordenes_fecha_pagada)='$mesActual' AND ordenes_estado='si'") or die(mysqli_error($conexion));
        while ($row=mysqli_fetch_array($buscaOrdenes)) {
            $intereses=$intereses+(($res["cliente_monto"]*$res["cliente_interes"])/100);
            $totalDevuelto=$totalDevuelto+round($res["cliente_monto"]/$res["cliente_cuotas"],1,PHP_ROUND_HALF_EVEN);
        }
        $buscaTodasOrdenes=mysqli_query($conexion,"SELECT ordenes_monto FROM ordenes WHERE ordenes_id_cliente='$clienteId' AND ordenes_estado='si'") or die(mysqli_error($conexion));
        //$buscaTodasOrdenes=mysqli_query($conexion,"SELECT cliente_cuota_total FROM clientes,ordenes WHERE cliente_id=ordenes_id_cliente AND ordenes_estado='si' AND ordenes_numero<=cliente_cuotas") or die(mysqli_error($conexion));
        while ($resultado=mysqli_fetch_array($buscaTodasOrdenes)) {
            $capitalTotalDevuelto=$capitalTotalDevuelto+round($res["cliente_monto"]/$res["cliente_cuotas"],1,PHP_ROUND_HALF_EVEN);
            //$capitalTotalDevuelto=$capitalTotalDevuelto+$resultado["cliente_cuota_total"];
        }

        $totalDevuelto=$totalDevuelto+$totalDevueltoCliente;
        $totalMensual=$totalDevuelto+$intereses;
    }

    return array(
        'totalPrestado'=> $totalPrestado-$capitalTotalDevuelto,
        'totalDevuelto'=> $totalDevuelto,
        'intereses'=> $intereses,
        'totalMensual'=> $totalMensual
        );
}

function cuotasPagadas($clienteId,$conexion){
    $buscoCuotas=mysqli_query($conexion,"SELECT ordenes_estado FROM ordenes WHERE ordenes_estado='si' AND ordenes_id_cliente = '$clienteId' ") or die(mysqli_error($conexion));
    return mysqli_num_rows($buscoCuotas);    
}

function estadoPago($idCliente,$conexion){
$mesActual=date('m');

    $buscaCuota=mysqli_query($conexion,"SELECT ordenes_estado FROM ordenes WHERE ordenes_id_cliente='$idCliente' AND MONTH(ordenes_fecha)='$mesActual' ");
    $row=mysqli_fetch_array($buscaCuota);

    if ($row["ordenes_estado"]=='si') {
        return "<td class='alert alert-info miAlert'><a href='detallesCliente.php?accion=".$idCliente."#pagos'><label>Pagó</label></a></td>";
        //return "<td class='alert alert-info miAlert'><label>Pagó</label></td>";
    }else{
        //return "<td class='alert alert-danger miAlert'><a href='librerias/cambiarEstado.php?id=".$idCliente."'><label>No Pagó&nbsp</label></a><input type='checkbox' align='right' name='seleccionados[]' value=".$idCliente."></td>";
        return "<td class='alert alert-danger miAlert'><label>No Pagó&nbsp</label><input type='checkbox' align='right' name='seleccionados[]' value=".$idCliente."></td>";
    }
}

function totalDevuelto($idCliente,$conexion){
    $buscoOrdenes=mysqli_query($conexion,"SELECT cliente_monto,cliente_cuotas FROM clientes,ordenes WHERE cliente_id='$idCliente' AND ordenes_id_cliente=$idCliente AND ordenes_estado='si' ") or die(mysqli_error($conexion));

    while ($row=mysqli_fetch_array($buscoOrdenes)) {
        $sumaPagada=$sumaPagada+($row["cliente_monto"]/$row["cliente_cuotas"]);
    }
    return $sumaPagada;
}

function totalRestante($idCliente,$conexion){
    $buscoOrdenes=mysqli_query($conexion,"SELECT cliente_monto,cliente_cuotas FROM clientes,ordenes WHERE cliente_id='$idCliente' AND ordenes_id_cliente=$idCliente AND ordenes_estado='si' ") or die(mysqli_error($conexion));

    while ($row=mysqli_fetch_array($buscoOrdenes)) {
        $sumaPagada=$sumaPagada+($row["cliente_monto"]/$row["cliente_cuotas"]);
        $monto=$row["cliente_monto"];
    }
    $resto=$monto-$sumaPagada;
    return $resto;
}

function totalPagadoHistorial($mes,$anio,$usuarioId,$conexion){
    $rs = mysqli_query( $conexion,"SELECT cliente_cuota_total FROM clientes,ordenes WHERE MONTH(ordenes_fecha_pagada)='$mes' AND YEAR(ordenes_fecha_pagada)='$anio' AND ordenes_id_cliente=cliente_id AND cliente_usuario='$usuarioId' ORDER BY cliente_id ASC") or die(mysqli_error($conexion));

    while ($resultado=mysqli_fetch_array($rs)) {
        $total=$total+$resultado["cliente_cuota_total"];
    }
    return $total;
}

function totalAltasHistorial($mes,$anio,$usuarioId,$conexion){
    $rs = mysqli_query( $conexion,"SELECT cliente_monto,cliente_cuotas FROM clientes WHERE MONTH(cliente_alta)='$mes' AND YEAR(cliente_alta)='$anio' AND cliente_usuario='$usuarioId' ORDER BY cliente_id ASC") or die(mysqli_error($conexion));

    while ($resultado=mysqli_fetch_array($rs)) {
        //$valorCuota = $resultado["cliente_monto"]/$resultado["cliente_cuotas"];
        //$total=$total+round(($resultado["cliente_monto"]/$resultado["cliente_cuotas"]),0,PHP_ROUND_HALF_EVEN);
        $total=$total+$resultado["cliente_monto"];
    }
    return $total;
}

function comprobarEstado($idCliente,$conexion){
    $buscaEstado=mysqli_query($conexion,"SELECT cliente_estado FROM clientes,ordenes WHERE cliente_id='$idCliente' AND ordenes_id_cliente=cliente_id AND ordenes_numero=cliente_cuotas AND ordenes_estado='si' ") or die(mysqli_error($conexion));
    $row=mysqli_fetch_array($buscaEstado);
    if(mysqli_num_rows($buscaEstado)>0){
        if ($row['cliente_estado']=='no') {
        $actualiza=mysqli_query($conexion,"UPDATE clientes SET cliente_estado='si' WHERE cliente_id='$idCliente' ") or die(mysqli_error($conexion));
        }
        return "<div class='alert alert-info text-center'>Prestamo finalizado</div>";
    }
}

function superUsuario($conexion,$usuarioId){
    $buscoUsuario=mysqli_query($conexion,"SELECT * FROM super_usuario WHERE su_user_id='$usuarioId' ") or die(mysqli_error($conexion));
    $row=mysqli_fetch_array($buscoUsuario);
    if($row["su_logueado"]=="si"){
        return TRUE;
    }else{
        return FALSE;
    }
}

function existeClave($conexion,$usuarioId){
    $buscoUsuario=mysqli_query($conexion,"SELECT su_user_id FROM super_usuario WHERE su_user_id='$usuarioId' ") or die(mysqli_error($conexion));
    $row=mysqli_fetch_array($buscoUsuario);
    if (mysqli_num_rows($buscoUsuario)<1) {
        return TRUE;
    }
}

function nombreMes($mes) {    

    switch ($mes) {
        case 1:
        return "Enero";
        break;
        case 2:
        return "Febrero";
        break;
        case 3:
        return "Marzo";
        break;
        case 4:
        return "Abril";
        break;
        case 5:
        return "Mayo";
        break;
        case 6:
        return "Junio";
        break;
        case 7:
        return "Julio";
        break;
        case 8:
        return "Agosto";
        break;
        case 9:
        return "Septiembre";
        break;
        case 10:
        return "Octubre";
        break;
        case 11:
        return "Noviembre";
        case 12:
        return "Diciembre";
        break;
        default:
        return "";
        break;
    }
}