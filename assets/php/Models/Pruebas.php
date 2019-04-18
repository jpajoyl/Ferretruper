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
/*$ce = ComprobanteEgreso::obtenerComprobanteEgreso(1);
$ce->imprimirComprobante(false);
$ce = Factura::obtenerFactura(1);
$ce->facturaPOSPDF();
$ce->imprimirFacturaCarta();*/
//$venta=Venta::obtenerVenta(13);
//$Factura=$venta->efectuarVenta(1,64);
$ce = Factura::obtenerFactura(2);
$ce->facturaPOSPDF();


 ?>