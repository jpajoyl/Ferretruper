<?php 

include '../Conexion.php';
include 'Usuario.php';
include 'Cliente.php';
include 'Compra.php';
include 'Empleado.php';
include 'Proveedor.php';
// include 'Factura.php';
include 'Abono.php';
include 'FacturaCompra.php';
include 'Venta.php';
include 'TipoVenta.php';
include '../Controllers/Response.php';
/*$ce = Factura::obtenerFactura(1);
$ce->imprimirFacturaPOS();*/
// $r = FacturaCompra::facturaCompraPorComprobanteEgreso(3);
$r=Compra::obtenerComprasPorIdProveedor(52);
echo $r->rowCount();
if($r->rowCount()>0){
	while ($producto = $r->fetch(PDO::FETCH_ASSOC)) {
		//$array['data'][]=$producto;
		echo $producto['compras_id_compra']."<br>";
	}
}

 ?>