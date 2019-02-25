<?php 
	if(!isset($include)){
		include_once '../Conexion.php';
		include_once 'SesionEmpleado.php';
		include_once '../Models/Inventario.php';
		include_once '../Models/Usuario.php';
		include_once '../Models/Proveedor.php';
		include_once '../Models/Producto.php';
		include_once '../Models/Compra.php';
		include_once '../Models/ProductoXCompra.php';
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
			$iva=$_POST['iva'];
			$codigoDeBarras=$_POST['codigoDeBarras'];
			$precioCompra=$_POST['precioCompra'];
			$numeroUnidades=$_POST['numeroUnidades'];
			$compra=unserialize($_COOKIE['compra']);

			$proveedor=Proveedor::obtenerProveedor($idProveedor,false);
			if($proveedor!=false){
				$buscarProductoxcompra=ProductoXCompra::obtenerProductoXCompraConIdProductoIdCompra($compra->getIdCompra(),$idProducto);
				if($buscarProductoxcompra==false){
					$producto=Producto::obtenerProducto($idProducto);
					if($producto==false){
						try {
							$producto = new Producto($idProducto, $nombre, $descripcion, $referenciaFabrica, $iva, $clasificacionTributaria, 1, $codigoDeBarras);
							$productoxcompra = new ProductoXCompra($precioCompra, $numeroUnidades, $compra->getIdCompra(),$idProducto);
							echo SUCCESS;
						} catch (Exception $e) {
							echo $e->getMessage();
							$conexion=null;
							$statement=null;
						}
					}else{
						$inventariosProveedor=Inventario::obtenerInventarios($idProveedor,false);
						if($inventariosProveedor->rowCount()>0){
							$existencia=false;
							while ($productoInventario = $inventariosProveedor->fetch(PDO::FETCH_ASSOC)) {
								if($productoInventario['productos_id_producto']==$idProducto){
									$existencia=true;
									break;
								}
							}
							if(!$existencia){
								if($producto->getNombre()!=$nombre){
									echo ERROR;
								}else{
									$producto->editarProducto($codigoDeBarras, $nombre, $descripcion, $referenciaFabrica, $iva, $clasificacionTributaria);
									$productoxcompra = new ProductoXCompra($precioCompra, $numeroUnidades, $compra->getIdCompra(),$idProducto);
									echo SUCCESS;
								}
							}else{
								echo ALREADY_EXIST;
							}
						}else{
							if($producto->getNombre()!=$nombre){
								echo ERROR;
							}else{
								$producto->editarProducto($codigoDeBarras, $nombre, $descripcion, $referenciaFabrica, $iva, $clasificacionTributaria);
								$productoxcompra = new ProductoXCompra($precioCompra, $numeroUnidades, $compra->getIdCompra(),$idProducto);
								echo SUCCESS;
							}
						}
					}
				}else{
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
		}else if(!strcmp($method,"editarProducto")){
			$idProducto=$_POST['idProducto'];
			$nombre=$_POST['nombre'];
			$descripcion=$_POST['descripcion'];
			$referenciaFabrica=$_POST['referenciaFabrica'];
			$iva=$_POST['iva'];
			$codigoDeBarras=$_POST['CodigoDeBarras'];

			$producto=Producto::obtenerProducto($idProducto);
			if($producto!=false){
				try {
					$producto->editarProducto($codigoDeBarras, $nombre, $descripcion, $referenciaFabrica, $iva, "GRAVADO");
					echo SUCCESS;
				} catch (Exception $e) {
					echo $e->getMessage();
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
		}else if(!strcmp($method,"reactivarProducto")){
			$idProducto=$_POST['idProducto'];
			$producto=Producto::obtenerProducto($idProducto,false,true);
			if($producto!=false){
				try {
					$producto->desactivarProducto(false);
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
		}else if(!strcmp($method,"verProductos")){
			echo json_encode(Producto::verProductos($_GET));
		}else if(!strcmp($method,"verProductosInventario")){
			echo json_encode(Producto::verProductosInventario($_GET));
		}else if(!strcmp($method,"verProductosDeshabilitados")){
			echo json_encode(Producto::verProductosInventario($_GET,true));
		}
	}
 ?>