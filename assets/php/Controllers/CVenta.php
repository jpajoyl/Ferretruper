<?php 
	if(!isset($include)){
		include_once '../Conexion.php';
		include_once 'SesionEmpleado.php';
		include_once '../Models/Inventario.php';
		include_once '../Models/Usuario.php';
		include_once '../Models/Cliente.php';
		include_once '../Models/Producto.php';
		include_once '../Models/Factura.php';
		include_once '../Models/Venta.php';
		include_once '../Models/ProductoXVenta.php';

		$objectSession =new SesionEmpleado();
		$method = isset($_GET['method'])?$_GET['method']:"";
		date_default_timezone_set("America/Bogota");
	}
	include_once 'Response.php';
	if($method!="" && $objectSession->getEmpleadoActual()!=null){
		if(!strcmp($method,"obtenerVenta")){
			if(isset($_COOKIE['venta'])){
				// unset($_COOKIE["venta"]);
				// setcookie("venta", "",time() - 3600, "/");
				$venta=unserialize($_COOKIE['venta']);
				if($venta instanceof Venta){
					$data['response']=SUCCESS;
					$productosxventa=$venta->verProductosxVenta();
					if($productosxventa->rowCount()>0){
						while ($productoxventa = $productosxventa->fetch(PDO::FETCH_ASSOC)) {
							$data['productosxventa'][]=$productoxventa;
						}
					}else{
						$data['productosxventa']=NOT_FOUND;
					}
					$data['totalVenta']=$venta->getTotal();
					echo json_encode($data);
				}else{
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
		}else if(!strcmp($method,"seleccionarProducto")){
			if(isset($_COOKIE['venta'])){
				$venta=unserialize($_COOKIE['venta']);
				if($venta instanceof Venta){
					$idProducto=$_POST['idProducto'];
					$unidades=$_POST['unidades'];
					$totalVenta = isset($_POST['totalVenta'])?$_POST['totalVenta']:0;
					$seleccionarProducto=$venta->seleccionarProducto($idProducto,$unidades);
					unset($_COOKIE["venta"]);
					setcookie("venta", "",time() - 3600, "/");
					$serializeVenta=serialize($venta);
					setcookie("venta", $serializeVenta,time() + 3600, "/");
					echo $seleccionarProducto;
				}
			}else{
				try {
					$venta = new Venta(date('Y-m-d'));
					$idProducto=$_POST['idProducto'];
					$unidades=$_POST['unidades'];
					$totalVenta = isset($_POST['totalVenta'])?$_POST['totalVenta']:0;
					$seleccionarProducto=$venta->seleccionarProducto($idProducto,$unidades);
					$serializeVenta=serialize($venta);
					setcookie("venta", $serializeVenta,time() + 3600, "/");
					echo $seleccionarProducto;
				} catch (Exception $e) {
					echo ERROR;
				}
			}
		}else if(!strcmp($method,"deseleccionarProducto")){
			if(isset($_COOKIE['venta'])){
				$venta=unserialize($_COOKIE['venta']);
				if($venta instanceof Venta){
					$idProductoXVenta=$_POST['idProductoXVenta'];
					$deseleccionarProducto=$venta->desseleccionarProducto($idProductoXVenta);
					unset($_COOKIE["venta"]);
					setcookie("venta", "",time() - 3600, "/");
					$serializeVenta=serialize($venta);
					setcookie("venta", $serializeVenta,time() + 3600, "/");
					echo $deseleccionarProducto;
				}
			}else{
				echo ERROR;
			}
		}
	}
 ?>