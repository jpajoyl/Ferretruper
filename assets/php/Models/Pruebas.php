<?php 

include '../Conexion.php';
include 'Usuario.php';
include 'Cliente.php';
include 'Compra.php';
include 'Empleado.php';
include 'Proveedor.php';
include 'Factura.php';
include 'Abono.php';
include 'FacturaCompra.php';
include 'Venta.php';
include 'TipoVenta.php';
include '../Controllers/Response.php';
include 'comprobanteEgreso.php';
$ce = Factura::obtenerFactura(1);
$ce->imprimirFacturaCarta();
 ?>