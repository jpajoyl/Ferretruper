<?php 


	/**
	 * 
	 */
	class Compra {
		

		//atributos
		private $idCompra;
		private $numeroFactura;
		private $fecha;
		private $descuento;
		private $totalCompra;
		private $proveedor; //Objeto

		private $productosxcompra; //Array
		private $activa;


		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($numeroFactura, $fecha, $totalCompra, $descuento, $id_proveedor){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `compras`(`id_compra`, `numero_factura`, `fecha_compra`, `total_compra`, `descuento_compra`, `USUARIOS_id_proveedor`,`activa`) VALUES (null,:numeroFactura,:fecha,:totalCompra,:descuento,:id_proveedor,1)");

			$this->setNumeroFactura($numeroFactura,$statement);
			$this->setFecha($fecha,$statement);
			$this->setTotalCompra($totalCompra,$statement);
			$this->setDescuento($descuento,$statement);
			$this->setProveedor($id_proveedor,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$this->setIdCompra($conexion->lastInsertId());
			$conexion = NULL;
			$statement = NULL;
		}

		//get & set
		public function getIdCompra()
		{
			return $this->idCompra;
		}
		
		public function setIdCompra($idCompra, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':idCompra',$idCompra,PDO::PARAM_INT);
			}
			$this->idCompra = $idCompra;

		}

		public function getNumeroFactura()
		{
			return $this->numeroFactura;
		}
		
		public function setNumeroFactura($numeroFactura, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':numeroFactura',$numeroFactura,PDO::PARAM_STR,45);
			}
			$this->numeroFactura = $numeroFactura;

		}

		public function getFecha()
		{
			return $this->fecha;
		}
		
		public function setFecha($fecha, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':fecha',$fecha,PDO::PARAM_STR,45);
			}
			$this->fecha = $fecha;

		}

		public function getDescuento()
		{
			return $this->descuento;
		}
		
		public function setDescuento($descuento, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':descuento',$descuento,PDO::PARAM_INT);
			}
			$this->descuento = $descuento;
			
		}

		public function getTotalCompra()
		{
			return $this->totalCompra;
		}
		
		public function setTotalCompra($totalCompra, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':totalCompra',$totalCompra,PDO::PARAM_INT);
			}
			$this->totalCompra = $totalCompra;

		}


		public function getProveedor()
		{
			return $this->proveedor;
		}
		
		public function setProveedor($id_proveedor, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':id_proveedor',$id_proveedor,PDO::PARAM_INT);
			}
			$this->proveedor = Proveedor::obtenerProveedor($id_proveedor,false);

		}


		public function getActiva()
		{
			return $this->activa;
		}
		
		public function setActiva($activa, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':activa',$activa,PDO::PARAM_INT);
			}
			$this->activa = $activa;

		}


		public function pagarCompra(){
			$fecha=getDate();
			$comprobante= new comprobanteEgreso(($fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday']),$this);
			if ( $comprobante != null){
				$comprobante->imprimirComprobante();
			}
		}

		public static function obtenerCompra($idCompra)
		{
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `compras` WHERE  `id_compra` = :id_compra");
			$statement->bindValue(":id_compra", $idCompra);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado!=false){
				$compra = new Compra();
				$compra->setIdCompra($resultado['id_compra']);
				$compra->setNumeroFactura($resultado['numero_factura']);
				$compra->setFecha($resultado['fecha_compra']);
				$compra->setTotalCompra($resultado['total_compra']);
				$compra->setDescuento($resultado['descuento_compra']);
				$compra->setProveedor($resultado['USUARIOS_id_proveedor']);
				$compra->setActiva($resultado['activa']);
				$conexion=null;
				$statement=null;
				return $compra;
			}else{
				return false;
			}

		}
		public static function obtenerCompraNumeroFacturaXProveedor($numeroFactura,$idProveedor){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `compras` WHERE  `numero_factura` = :numero_factura AND `USUARIOS_id_proveedor` = :id_proveedor");
			$statement->bindValue(":numero_factura", $numeroFactura);
			$statement->bindValue(":id_proveedor", $idProveedor);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado!=false){
				$compra = new Compra();
				$compra->setIdCompra($resultado['id_compra']);
				$compra->setNumeroFactura($resultado['numero_factura']);
				$compra->setFecha($resultado['fecha_compra']);
				$compra->setTotalCompra($resultado['total_compra']);
				$compra->setDescuento($resultado['descuento_compra']);
				$compra->setProveedor($resultado['USUARIOS_id_proveedor']);
				$compra->setActiva($resultado['activa']);

				$conexion=null;
				$statement=null;
				return $compra;
			}else{
				return false;
			}
		}
		public static function verCompras($id_proveedor = null){
			$conexion = Conexion::conectar();
			if ($proveedor == null){

				$statement = $conexion->prepare( "SELECT * FROM `compras` WHERE 1");

			}else{
				$statement = $conexion->prepare( "SELECT * FROM `compras` WHERE `USUARIOS_id_proveedor` = :id_proveedor ");
				$statement->bindValue(":id_proveedor", $id_proveedor);
			}

			$statement->execute();
			if($statement){
				return $statement;
			}else{
				return ERROR;
			}

		}
		public function abastecer($array){
			$productosxcompra=array();
			$conexion = Conexion::conectar();
			$statement= $this->verProductosxCompra();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			while($resultado){
				$idProductoxCompra= $resultado["id_productoxcompra"];
				$nuevaUnidades= $array[$idProductoxCompra]["unidades"];
				$precioUnitario = $array[$idProductoxCompra]["precioUnitario"];
				
				$statement2=$conexion->prepare("UPDATE `productoxcompra` SET `precio_unitario`=:precioUnitario,`unidades`=:nuevaUnidades WHERE `id_productoxcompra` = :idProductoxCompra");

				$statement2->bindValue(":precioUnitario", $precioUnitario);
				$statement2->bindValue(":nuevaUnidades", $nuevaUnidades);
				$statement2->bindValue(":idProductoxCompra", $idProductoxCompra);
				$statement2->execute();
				$statement2 = null;

				$productoxcompra= ProductoXCompra::obtenerProductoXCompra($idProductoxCompra);
				$productosxcompra[]= $productoxcompra;
				$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			}
			$totalCompra=0;
			foreach ($productosxcompra as $productoxcompra) {
				$proveedor=$this->getProveedor();
				$producto=$productoxcompra->getProducto();
				$idProveedor=$proveedor->getIdUsuario();
				$idProducto=$producto->getIdProducto();
				$idProductoxCompra =  $productoxcompra->getIdProductoxCompra();
				
				$nuevaUtilidad= $array[$idProductoxCompra]["utilidad"];
				$precioVenta = $array[$idProductoxCompra]["precioVenta"]; 


				$inventario=Inventario::obtenerInventario($idProducto,$idProveedor,true);
				if($inventario){
					$unidades= $inventario->getUnidades() + $productoxcompra->getNumeroUnidades();
					$statement = $conexion->prepare(" UPDATE `inventario` SET `precio_inventario`=:precioInventario ,`precio_compra`=:precioCompra, `unidades`=:unidades,`valor_utilidad`=:valorUtilidad WHERE `productos_id_producto`=:idProducto and `usuarios_id_usuario` = :idUsuario ");
					$inventario->setUnidades($unidades,$statement);
					$inventario->setPrecioCompra($array[$idProductoxCompra]["precioUnitario"],$statement);
					$inventario->setPrecioInventario($precioVenta,$statement);
					$statement->bindValue(":idProducto", $idProducto);
					$statement->bindValue(":idUsuario", $idProveedor);
					$statement->bindValue(":valorUtilidad", $nuevaUtilidad);
					$statement->execute();
					if(!$statement){
						throw new Exception("Error Processing Request", 1);
						return ERROR;
					}
				}else{
					$unidades= $productoxcompra->getNumeroUnidades();
					$inventario = new Inventario($precioVenta,$productoxcompra->getPrecioUnitario(),$unidades,0,$idProducto,$idProveedor,$nuevaUtilidad);
				}
				$unidadesNetas= $productoxcompra->getNumeroUnidades();
				$totalCompra+=($precioVenta*$unidadesNetas);
				$producto->calcularUnidades();
				$producto->obtenerPrecioMayorInventario();

			}	

			$facturaCompra = new FacturaCompra($this->getIdCompra());

			$statement = $conexion->prepare(" UPDATE `compras` SET `total_compra`=:totalCompra WHERE `id_compra` = :idCompra ");
			$this->setTotalCompra($totalCompra,$statement);
			$statement->bindValue(":idCompra", $this->getIdCompra());
			$statement->execute();
			$conexion = null;
			if ($statement){
				try {
					$this->desactivarCompra();
				} catch (Exception $e) {
					return ERROR;
				}
			}else{
				return ERROR;
			}
			return SUCCESS;

		}

		public function verProductosxCompra(){
			$idCompra=$this->getIdCompra();
			$conexion = Conexion::conectar();
			$statement= $conexion->prepare("SELECT * FROM productos INNER JOIN `productoxcompra` ON productoxcompra.productos_id_producto = productos.id_producto WHERE productoxcompra.COMPRAS_id_compra = :idCompra"); 
			$statement->bindParam(':idCompra',$idCompra,PDO::PARAM_INT);
			$statement->execute();
			$conexion=null;
			return $statement;
		}

		public function desactivarCompra(){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare(" UPDATE `compras` SET `activa`=:activa WHERE `id_compra` = :idCompra ");
			$statement->bindValue(":idCompra", $this->getIdCompra());
			$statement->bindValue(":activa", 0);
			$statement->execute();
			$conexion = null;
			if ($statement){
				return SUCCESS;
			}else{
				return ERROR;
			}
		}
		public static function obtenerComprasPorNumeroFactura($numeroFactura){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `compras` WHERE  `numero_factura` = :numeroFactura");
			$statement->bindParam(":numeroFactura",$numeroFactura,PDO::PARAM_INT);
			$statement->execute();
			$conexion = null;
			return $statement;
		}
		public static function obtenerComprasPorIdProveedor($idProveedor, $modo=true)
		{//si modo es true, trae las que no estan pagadas. si modo es false, trae todas
			$conexion = Conexion::conectar();
			if ($modo) {
				$statement = $conexion->prepare("SELECT * FROM compras INNER JOIN `factura_compra` ON factura_compra.compras_id_compra = compras.id_compra WHERE compras.USUARIOS_id_proveedor = :idProveedor AND factura_compra.comprobantes_egreso_id_comprobante_egreso IS NULL");
			}else{
				$statement = $conexion->prepare("SELECT * FROM compras INNER JOIN `factura_compra` ON factura_compra.compras_id_compra = compras.id_compra WHERE compras.USUARIOS_id_proveedor = :idProveedor");
			}
			$statement->bindParam(":idProveedor",$idProveedor,PDO::PARAM_INT);
			$statement->execute();
			$conexion = null;
			return $statement;
		}


		public function abastecerEspecial($array){
			$productosxcompra=array();
			$conexion = Conexion::conectar();
			$statement= $this->verProductosxCompra();
			$resultado = $statement->fetchAll();
			foreach($resultado as $r){
				$idProductoxCompra= $r["id_productoxcompra"];
				$nuevaUnidades= $array[$idProductoxCompra]["unidades"];
				$precioUnitario = $array[$idProductoxCompra]["precioUnitario"];
				
				$statement2=$conexion->prepare("UPDATE `productoxcompra` SET `precio_unitario`=:precioUnitario,`unidades`=:nuevaUnidades WHERE `id_productoxcompra` = :idProductoxCompra");

				$statement2->bindValue(":precioUnitario", $precioUnitario);
				$statement2->bindValue(":nuevaUnidades", $nuevaUnidades);
				$statement2->bindValue(":idProductoxCompra", $idProductoxCompra);
				$statement2->execute();
				$statement2 = null;

				$productoxcompra= ProductoXCompra::obtenerProductoXCompra($idProductoxCompra);
				$productosxcompra[]= $productoxcompra;
			}
			$totalCompra=0;
			$statement=null;
			foreach ($productosxcompra as $productoxcompra) {
				$proveedor=$this->getProveedor();
				$producto=$productoxcompra->getProducto();
				$idProveedor=$proveedor->getIdUsuario();
				$idProducto=$producto->getIdProducto();
				$idProductoxCompra =  $productoxcompra->getIdProductoxCompra();

				
				$nuevaUtilidad= $array[$idProductoxCompra]["utilidad"];
				$precioVenta = $array[$idProductoxCompra]["precioVenta"]; 
				$inventarioEspecial = Producto::verificarEspecial($idProducto);
				if($inventarioEspecial){
					$idInventarioEspecial = $inventarioEspecial->getIdInventario();
					$unidadesDebidas = $producto->getUnidadesDeuda();

					$unidadesFinales =$unidadesDebidas - $productoxcompra->getNumeroUnidades();
					if($unidadesFinales >0){
						$statement = $conexion->prepare("UPDATE `productos` SET `unidades_deuda`=:unidadesDeuda WHERE `id_producto` = :idProducto");
						$statement->bindValue(":unidadesDeuda", $unidadesFinales);
						$statement->bindValue(":idProducto", $idProducto);
						$statement->execute();
						$statement=null;
						$statement = $conexion->prepare(" UPDATE `inventario` SET `precio_inventario`=:precioInventario ,`precio_compra`=:precioCompra, `unidades`=:unidades,`valor_utilidad`=:valorUtilidad WHERE `id_inventario` = :idInventario ");
						$statement->bindValue(":precioInventario", $precioVenta);
						$statement->bindValue(":precioCompra", $array[$idProductoxCompra]["precioUnitario"]);
						$statement->bindValue(":unidades", $unidadesFinales);
						$statement->bindValue(":idInventario", $idInventarioEspecial);
						$statement->bindValue(":valorUtilidad", $nuevaUtilidad);
						$statement->execute();
						if(!$statement){
							throw new Exception("Error Processing Request", 1);
							return ERROR;
						}
					}else if($unidadesFinales < 0){
						$unidadesFinales = (-1)*$unidadesFinales;
						$statement = $conexion->prepare("UPDATE `productos` SET `unidades_deuda`=:unidadesDeuda WHERE `id_producto` = :idProducto");
						$statement->bindValue(":unidadesDeuda", 0);
						$statement->bindValue(":idProducto", $idProducto);
						$statement->execute();
						$statement=null;
						$statement = $conexion->prepare(" DELETE FROM `inventario` WHERE `id_inventario` = :idInventario ");
						$statement->bindValue(":idInventario", $idInventarioEspecial);
						$statement->execute();
						if(!$statement){
							throw new Exception("Error Processing Request", 1);
							return ERROR;
						}

						$inventario=Inventario::obtenerInventario($idProducto,$idProveedor,true);
						if($inventario){
							$unidades= $inventario->getUnidades() + $unidadesFinales;
							$statement2 = $conexion->prepare(" UPDATE `inventario` SET `precio_inventario`=:precioInventario ,`precio_compra`=:precioCompra, `unidades`=:unidades,`valor_utilidad`=:valorUtilidad WHERE `productos_id_producto`=:idProducto and `usuarios_id_usuario` = :idUsuario ");
							$inventario->setUnidades($unidades,$statement2);
							$inventario->setPrecioCompra($array[$idProductoxCompra]["precioUnitario"],$statement2);
							$inventario->setPrecioInventario($precioVenta,$statement2);
							$statement2->bindValue(":idProducto", $idProducto);
							$statement2->bindValue(":idUsuario", $idProveedor);
							$statement2->bindValue(":valorUtilidad", $nuevaUtilidad);
							$statement2->execute();
							if(!$statement2){
								throw new Exception("Error Processing Request", 1);
								return ERROR;
							}
						}else{
							$unidades= $unidadesFinales;
							$inventario = new Inventario($precioVenta,$productoxcompra->getPrecioUnitario(),$unidades,0,$idProducto,$idProveedor,$nuevaUtilidad);
						}
					}else{
						$statement = $conexion->prepare("UPDATE `productos` SET `unidades_deuda`=:unidadesDeuda WHERE `id_producto` = :idProducto");
						$statement->bindValue(":unidadesDeuda", 0);
						$statement->bindValue(":idProducto", $idProducto);
						$statement->execute();
						$statement=null;
						$statement = $conexion->prepare(" DELETE FROM `inventario` WHERE `id_inventario` = :idInventario ");
						$statement->bindValue(":idInventario", $idInventarioEspecial);
						$statement->execute();
						if(!$statement){
							throw new Exception("Error Processing Request", 1);
							return ERROR;
						}
					}
				}else{

					$inventario=Inventario::obtenerInventario($idProducto,$idProveedor,true);
					if($inventario){
						$unidades= $inventario->getUnidades() + $productoxcompra->getNumeroUnidades();
						$statement = $conexion->prepare(" UPDATE `inventario` SET `precio_inventario`=:precioInventario ,`precio_compra`=:precioCompra, `unidades`=:unidades,`valor_utilidad`=:valorUtilidad WHERE `productos_id_producto`=:idProducto and `usuarios_id_usuario` = :idUsuario ");
						$inventario->setUnidades($unidades,$statement);
						$inventario->setPrecioCompra($array[$idProductoxCompra]["precioUnitario"],$statement);
						$inventario->setPrecioInventario($precioVenta,$statement);
						$statement->bindValue(":idProducto", $idProducto);
						$statement->bindValue(":idUsuario", $idProveedor);
						$statement->bindValue(":valorUtilidad", $nuevaUtilidad);
						$statement->execute();
						if(!$statement){
							throw new Exception("Error Processing Request", 1);
							return ERROR;
						}
					}else{
						$unidades= $productoxcompra->getNumeroUnidades();
						$inventario = new Inventario($precioVenta,$productoxcompra->getPrecioUnitario(),$unidades,0,$idProducto,$idProveedor,$nuevaUtilidad);
					}
				}

				
				$unidadesNetas= $productoxcompra->getNumeroUnidades();
				$totalCompra+=($precioVenta*$unidadesNetas);
				$producto->calcularUnidades();
				$producto->obtenerPrecioMayorInventario();

			}	

			
			$statement2 = null;
			$statement = null;
			$facturaCompra = new FacturaCompra($this->getIdCompra());

			$statement = $conexion->prepare(" UPDATE `compras` SET `total_compra`=:totalCompra WHERE `id_compra` = :idCompra ");
			$this->setTotalCompra($totalCompra,$statement);
			$statement->bindValue(":idCompra", $this->getIdCompra());
			$statement->execute();
			$conexion = null;
			if ($statement){
				try {
					$this->desactivarCompra();
				} catch (Exception $e) {
					return ERROR;
				}
			}else{
				return ERROR;
			}
			return SUCCESS;
		}

	}

	?>