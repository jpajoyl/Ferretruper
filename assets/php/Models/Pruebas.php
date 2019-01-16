<?php 

include '../Conexion.php';
include 'Compra.php';
include 'Usuario.php';
include 'Proveedor.php';
include 'ComprobanteEgreso.php';

$ce = ComprobanteEgreso::obtenerComprobanteEgreso(3);
$ce->imprimirComprobante();







 ?>