<?php 

if(!isset($include)){
	include_once '../Conexion.php';
	include_once 'SesionEmpleado.php';
	include_once '../Models/Inventario.php';
	include_once '../Models/Usuario.php';
	include_once '../Models/Proveedor.php';
	include_once '../Models/Producto.php';
	include_once '../Models/FacturaCompra.php';
	include_once '../Models/Compra.php';
	include_once '../Models/ProductoXCompra.php';
	include_once '../Models/comprobanteEgreso.php';
	$objectSession =new SesionEmpleado();
	$method = isset($_GET['method'])?$_GET['method']:"";
	date_default_timezone_set("America/Bogota");
}
include_once 'Response.php';
if($method!="" && $objectSession->getEmpleadoActual()!=null){
	if (!strcmp($method,"buscarFacturaCompra")) {
		$idProveedor=$_POST['idProveedor'];
		$listaCompras=Compra::obtenerComprasPorIdProveedor($idProveedor);
			if($listaCompras->rowCount()>0){
				while ($compras = $listaCompras->fetch(PDO::FETCH_ASSOC)) {
					$array['data'][]=$compras;
				}
				echo json_encode($array);
			}else{
				echo NOT_FOUND;
			}
	}elseif (!strcmp($method,"emitirComprobante")) {
		$arrayIdFacturaCompra=$_GET['id-facturas'];
		$ids = preg_split('[-]', $arrayIdFacturaCompra);
		array_pop( $ids );
		if (count($ids)>0) {
			$comprobanteEgreso=new ComprobanteEgreso(date('Y-m-d'));
			for ($i=0; $i <count($ids) ; $i++) {
				$factura=FacturaCompra::obtenerFacturaCompraPorIdFacturaCompra($ids[$i]);
				$factura->asociarComprobanteEgreso($comprobanteEgreso->getNumeroConsecutivo());
			}
			$comprobanteEgreso->imprimirComprobante(false);
			echo SUCCESS;
		}else{
			echo ERROR;
		}

	}

}





 ?>