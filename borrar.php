<?php
$monto=40000;
$numerodecuotas=36;
$interes=4.2;

$valorCuota = $monto/$numerodecuotas;
$valorInteres = ($monto * $interes)/100;
$cuotaTotal = round($valorCuota+$valorInteres,0,PHP_ROUND_HALF_EVEN);

      echo "$cuotaTotal";
?>