<?php 

include '../Conexion.php';
include 'Compra.php';
include 'Usuario.php';
include 'Proveedor.php';
include 'ComprobanteEgreso.php';

$ce = ComprobanteEgreso::obtenerComprobanteEgreso(2);
$ce->imprimirComprobante();







 ?>