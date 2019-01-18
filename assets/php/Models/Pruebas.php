<?php 

include '../Conexion.php';
include 'Compra.php';
include 'Usuario.php';
include 'Proveedor.php';
include 'ComprobanteEgreso.php';
include 'FacturaCompra.php';
/*$ce = ComprobanteEgreso::obtenerComprobanteEgreso(3);
$ce->imprimirComprobante();
*/
$r = FacturaCompra::facturaCompraPorComprobanteEgreso(3);

if($r->rowCount()>0){
	while ($producto = $r->fetch(PDO::FETCH_ASSOC)) {
		//$array['data'][]=$producto;
		echo $producto['compras_id_compra']."<br>";
	}
}

 ?>