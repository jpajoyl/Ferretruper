<?php 
	if(!isset($include)){
		include_once '../Conexion.php';
		include_once 'SesionEmpleado.php';
		include_once '../Models/Producto.php';
		$objectSession =new SesionEmpleado();
		$method = isset($_GET['method'])?$_GET['method']:"";
	}
	include_once 'Response.php';
	if($method!="" && $objectSession->getEmpleadoActual()!=null){
		if(!strcmp($method,"registrarProducto")){
			$idProducto=$_POST['idProducto'];
			$nombre=$_POST['nombre'];
			$descripcion=$_POST['descripcion'];
			$referenciaFabrica=$_POST['referenciaFabrica'];
			$clasificacionTributaria=$_POST['clasificacionTributaria'];
			$utilidad=$_POST['utilidad'];
			$iva=$_POST['iva'];
			$CodigoDeBarras=$_POST['CodigoDeBarras'];

			if(Producto::obtenerProducto($idProducto)==false){
				try {
					$producto = new Producto($idProducto, $nombre, $descripcion, $referenciaFabrica, $iva, $clasificacionTributaria, $utilidad, "1", $CodigoDeBarras);
					// productoxproveedor = new ProductoXProveedor(params);
					echo SUCCESS;
				} catch (Exception $e) {
					echo ERROR;
					$conexion=null;
					$statement=null;
				}
			}else{
				echo ALREADY_EXIST;
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
				// $producto->actualizarProducto($id_usuario, $nombre, $direccion, $ciudad, $telefono, $clasificacion, $digitoDeVerificacion, $email, $celular);
				if($producto){
					echo SUCCESS;
				}else{
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
			
		}else if(!strcmp($method,"desactivarProducto")){
			$idProducto=$_POST['idProducto'];
			$producto=Producto::obtenerProducto($idProducto);
			if($producto!=false){
				//$producto->desactivarUsuario();
				if($producto){
					echo SUCCESS;
				}else{
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
		}
	}
 ?>