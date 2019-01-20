<?php 

if(!isset($include)){
	include_once '../Conexion.php';
	include_once 'SesionEmpleado.php';
	include_once '../Models/Usuario.php';
	include_once '../Models/Proveedor.php';
	include_once '../Models/Producto.php';
	$objectSession =new SesionEmpleado();
	$method = isset($_GET['method'])?$_GET['method']:"";
}

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
			echo 1;
		}
	}
}

?>