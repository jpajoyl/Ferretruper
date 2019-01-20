<?php 

if(!isset($include)){
	include_once '../Conexion.php';
	include_once 'SesionEmpleado.php';
	include_once '../Models/Usuario.php';
	include_once '../Models/Proveedor.php';
	include_once '../Models/Producto.php';
	include_once '../Models/Compra.php';
	$objectSession =new SesionEmpleado();
	$method = isset($_GET['method'])?$_GET['method']:"";
	date_default_timezone_set("America/Bogota");
}
include_once 'Response.php';	
if($method!="" && $objectSession->getEmpleadoActual()!=null){
	if(!strcmp($method,"verProductos")){
		$listaProductos=Producto::verProductos();
		if($listaProductos->rowCount()>0){
			while ($producto = $listaProductos->fetch(PDO::FETCH_ASSOC)) {
				$array['data'][]=$producto;
			}
			echo json_encode($array);
		}else{
			echo NOT_FOUND;
		}
	}else if(!strcmp($method,"iniciarCompra")){
		$numeroFactura=$_POST['numeroFactura'];
		$idProveedor=$_POST['idProveedor'];
		$proveedor=Proveedor::obtenerProveedor($idProveedor,false);
		if($proveedor!=false){
			$fecha=getdate();
			$fechaHoy=$fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'];
			try {
				$compra = new Compra($numeroFactura, $fechaHoy, 0, 0, $proveedor);
				echo SUCCESS;
			} catch (Exception $e) {
				echo ERROR;
			}
			
			
		}
	}
}

?>