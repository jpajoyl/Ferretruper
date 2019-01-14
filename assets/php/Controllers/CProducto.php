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
	include_once 'Response.php';
	if($method!="" && $objectSession->getEmpleadoActual()!=null){
		if(!strcmp($method,"registrarProducto")){
			$idProveedor=$_POST['idProveedor'];
			$idProducto=$_POST['idProducto'];
			$nombre=$_POST['nombre'];
			$descripcion=$_POST['descripcion'];
			$referenciaFabrica=$_POST['referenciaFabrica'];
			$clasificacionTributaria=$_POST['clasificacionTributaria'];
			$utilidad=$_POST['utilidad'];
			$iva=$_POST['iva'];
			$CodigoDeBarras=$_POST['CodigoDeBarras'];

			$proveedor=Proveedor::obtenerProveedor($idProveedor,false);
			if($proveedor!=false){
				if(Producto::obtenerProducto($idProducto)==false){
					try {
						$producto = new Producto($idProducto, $nombre, $descripcion, $referenciaFabrica, $iva, $clasificacionTributaria, $utilidad, "1", $CodigoDeBarras);
						$productoxproveedor=$proveedor->añadirProductoxproveedor($idProducto);
						echo SUCCESS;
					} catch (Exception $e) {
						echo ERROR;
						$conexion=null;
						$statement=null;
					}
				}else{
					echo ALREADY_EXIST;
				}
			}else{
				echo NOT_FOUND;
			}
		}else if(!strcmp($method,"editarProducto")){
			$idProducto=$_POST['idProducto'];
			$nombre=$_POST['nombre'];
			$descripcion=$_POST['descripcion'];
			$referenciaFabrica=$_POST['referenciaFabrica'];
			$clasificacionTributaria=$_POST['clasificacionTributaria'];
			$utilidad=$_POST['utilidad'];
			$iva=$_POST['iva'];
			$CodigoDeBarras=$_POST['CodigoDeBarras'];

			$producto=Producto::obtenerProducto($idProducto);
			if($producto!=false){
				try {
					$producto->editarProducto($CodigoDeBarras, $nombre, $descripcion, $referenciaFabrica, $iva, $clasificacionTributaria, $utilidad);
					echo SUCCESS;
				} catch (Exception $e) {
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
			
		}else if(!strcmp($method,"desactivarProducto")){
			$idProducto=$_POST['idProducto'];
			$producto=Producto::obtenerProducto($idProducto);
			if($producto!=false){
				try {
					$producto->desactivarProducto();
					echo SUCCESS;
				} catch (Exception $e) {
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
		}else if(!strcmp($method,"buscarNombre")){
			$nombre=$_POST['nombre'];
			$productos=Producto::buscarPorNombre($nombre);
			if($productos!=false){
				$data=array();
				while ($producto = $productos->fetch(PDO::FETCH_ASSOC)){
					$data['info'][]=$producto;
				}
				echo json_encode($data);
			}
		}else if(!strcmp($method,"buscarProducto")){
			$idProducto=$_POST['idProducto'];
			$producto=Producto::obtenerProducto($idProducto,true);
			if($producto!=false){
				echo json_encode($producto);
			}
		}
	}
 ?>