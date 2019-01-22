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
			try {
				$consultaCompra=Compra::obtenerCompraNumeroFacturaXProveedor($numeroFactura,$idProveedor);
				if($consultaCompra==false){
					$fecha=getdate();
					$fechaHoy=$fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'];
					try {
						$compra = new Compra($numeroFactura, $fechaHoy, 0, 0, $idProveedor);
						$data=array();
						$data['response']=SUCCESS;
						$data['nombre']=$proveedor->getNombre();
						$data['id_compra']=$compra->getIdCompra();
						$serializeCompra=serialize($compra);
						setcookie("compra", $serializeCompra,time() + 3600, "/");
						echo json_encode($data);
					} catch (Exception $e) {
						echo ERROR;
					}
				}else{
					$data=array();
					$data['response']=ALREADY_EXIST;
					$data['nombre']=$proveedor->getNombre();
					$data['id_compra']=$consultaCompra->getIdCompra();
					$serializeCompra=serialize($consultaCompra);
					setcookie("compra", $serializeCompra,time() + 3600, "/");
					echo json_encode($data);
				}
			} catch (Exception $e) {
				echo ERROR;
			}
				
		}
	}else if (!strcmp($method,"getProductosXCompra")) {
		if(isset($_COOKIE['compra'])){
			$compra=unserialize($_COOKIE['compra']);
			if($compra instanceof Compra){
				$productosxcompra=$compra->verProductosxCompra();
				if($productosxcompra->rowCount()>0){
					while ($producto = $productosxcompra->fetch(PDO::FETCH_ASSOC)) {
						$array['productos'][]=$producto;
					}
					echo json_encode($array);
				}else{
					echo NOT_FOUND;
				}
			}else{
				echo ERROR;
			}
		}else{
			echo ERROR;
		}
	}else if(!strcmp($method,"añadirProductoxcompra")){
		if(isset($_COOKIE['compra'])){
			$compra=unserialize($_COOKIE['compra']);
			if($compra instanceof Compra){
				$idProducto=$_POST['idProducto'];
				$idCompra=$compra->getIdCompra();
				$productoxcompra=ProductoXCompra::obtenerProductoXCompraConIdProductoIdCompra($idCompra,$idProducto);
				if($productoxcompra==false){
					try {
						$productoxcompra = new ProductoXCompra(0, 0, $idCompra,$idProducto);
						echo SUCCESS;
					} catch (Exception $e) {
						echo ERROR;
					}
				}else{
					echo ALREADY_EXIST;
				}
			}
		}else{
			echo ERROR;
		}

	}else if(!strcmp($method,"eliminarProductoxcompra")){
		$idProductoxcompra=$_POST['idProductoxcompra'];
		$productoxcompra=ProductoXCompra::obtenerProductoXCompra($idProductoxcompra);
		if($productoxcompra!=false){
			try {
				$productoxcompra->eliminarProductoxCompra();
				echo SUCCESS;
			} catch (Exception $e) {
				echo ERROR;
			}
		}else{
			echo NOT_FOUND;
		}
	}else if(!strcmp($method,"abastecer")){
		$arrayProductosxcompraUtilidad=$_POST['data'];
		$arrayUtilidad=array();
		foreach ($arrayProductosxcompraUtilidad as $productoxcompra) {
			$arrayUtilidad[$productoxcompra["id_productoxcompra"]]=$productoxcompra["utilidad"];
		}
		if(isset($_COOKIE['compra'])){
			$compra=unserialize($_COOKIE['compra']);
			if($compra instanceof Compra){
				try {
					if($compra->abastecer($arrayUtilidad)==SUCCESS){
						echo SUCCESS;
					}else{
						echo ERROR;
					}
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}
		}
	}else if(!strcmp($method,"obtenerIva")){
		echo IVA;
	}
}

?>