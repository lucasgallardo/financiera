<?php
$HOST = "localhost";
$USER = "root";
$PASS = "1234";
$DB = "financiera";

function conectar(){
	global $HOST, $USER, $PASS, $DB;
	$cnx = mysqli_connect($HOST, $USER, $PASS, $DB);
	if (mysqli_connect_errno()) {
		//creadorDB($HOST,$USER,$PASS);
		echo "Conexión fallida: ".mysqli_connect_error();
		exit();
	}
	//mysql_select_db($DB, $cnx) or die (" Base de datos: '<strong>".$DB."</strong>' no encontrada.");
	return $cnx;
}

$conexion = conectar();

?>