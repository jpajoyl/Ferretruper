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


		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($numeroFactura, $fecha, $totalCompra, $descuento, $id_proveedor){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `compras`(`id_compra`, `numero_factura`, `fecha_compra`, `total_compra`, `descuento_compra`, `USUARIOS_id_proveedor`) VALUES (null,:numeroFactura,:fecha,:totalCompra,:descuento,:id_proveedor)");

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
			$this->proveedor = Proveedor::obtenerProveedor($id_proveedor);

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
		public function abastecer($arrayUtilidad){
			$productosxcompra=array();
			$conexion = Conexion::conectar();
			$statement= $this->verProductosxCompra();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			while($resultado){
				$productoxcompra= ProductoXCompra::obtenerProductoXCompra($resultado["id_productoxcompra"]);
				$productosxcompra[]= $productoxcompra;
				$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			}
			foreach ($productosxcompra as $productoxcompra) {
				$proveedor= $productoxcompra->getProveedor();
				$producto=$productoxcompra->getProducto();
				$id_proveedor=$proveedor->getIdUsuario();
				$id_producto=$producto->getIdProducto();
				$nuevaUtilidad= $arrayUtilidad[$id_producto];

				$precio=(($nuevaUtilidad/100) * $productosxcompra->getPrecioUnitario()) + $productosxcompra->getPrecioUnitario();

				if($producto->tieneIva()){
					$precioFinal= ($precio * IVA)+$precio;
				}else{
					$precioFinal = $precio;
				}

				$inventario=Inventario::obtenerInventario($id_producto,$id_proveedor,true);
				if($inventario){
					$unidades= $inventario->getUnidades() + $productosxcompra->getNumeroUnidades();
					$statement = $conexion->prepare(" UPDATE `inventario` SET `precio_inventario`=:precioInventario ,`unidades`=:unidades,`valor_utilidad`=:valorUtilidad WHERE `productos_id_producto`=:id_producto and `usuarios_id_usuario` = :id_usuario ");
					$inventario->setUnidades($unidades,$statement);
					$inventario->setPrecioInventario($precioFinal,$statement);
					$statement->bindValue(":id_producto", $id_producto);
					$statement->bindValue(":id_usuario", $id_proveedor);
					$statement->bindValue(":valorUtilidad", $nuevaUtilidad);
					$statement->execute();
					if(!$statement){
						throw new Exception("Error Processing Request", 1);
						return ERROR;
					}
					$conexion=null;
				}else{
					$unidades= $productosxcompra->getNumeroUnidades();
					$inventario = new Inventario($precioFinal,$productosxcompra->getPrecioUnitario(),$unidades,0,$id_producto,$id_proveedor,$nuevaUtilidad);
				}	

				$facturaCompra = new FacturaCompra($this->getIdCompra());
				$conexion = null;
				$statement=null;
				return SUCCESS;

			}
		}

		public function verProductosxCompra(){
			$idCompra=$this->getIdCompra();
			$conexion = Conexion::conectar();
			$statement= $conexion->prepare("SELECT * FROM `productoxcompra` WHERE `COMPRAS_id_compra` = :idCompra"); 
			//$statement = $conexion->prepare("SELECT * FROM productos INNER JOIN `productoxcompra` ON productoxcompra.productos_id_producto = productos.id_producto WHERE productoxcompra.COMPRAS_id_compra = :idCompra");
			$statement->bindParam(':idCompra',$idCompra,PDO::PARAM_INT);
			$statement->execute();
			$conexion=null;
			return $statement;
		}

	}




?>