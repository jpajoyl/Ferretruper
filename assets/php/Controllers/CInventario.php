<?php 

if(!isset($include)){
	if (!isset($_SESSION)) {
		$objectSession =new SesionEmpleado();
		include_once '../Conexion.php';
		include_once 'SesionEmpleado.php';
		include_once '../Models/Usuario.php';
		include_once '../Models/Producto.php';
		$method = isset($_GET['method'])?$_GET['method']:"";
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
				
			}
		}
	}
}






?>