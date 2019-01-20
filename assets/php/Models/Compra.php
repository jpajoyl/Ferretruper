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

		public function __construct0($numeroFactura, $fecha, $totalCompra, $descuento, $proveedor){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `compras`(`id_compra`, `numero_factura`, `fecha_compra`, `total_compra`, `descuento_compra`, `USUARIOS_id_proveedor`) VALUES (null,:numeroFactura,:fecha,:totalCompra,:descuento,:id_proveedor)");

			$this->setNumeroFactura($numeroFactura,$statement);
			$this->setFecha($fecha,$statement);
			$this->setTotalCompra($totalCompra,$statement);
			$this->setDescuento($descuento,$statement);
			$this->setProveedor($proveedor,$statement);
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
			return $this;
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
			return $this;
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
			return $this;
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
			return $this;
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
			return $this;
		}


		public function getProveedor()
		{
			return $this->proveedor;
		}
		
		public function setProveedor($proveedor, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':id_proveedor',$proveedor->getIdUsuario(),PDO::PARAM_INT);
			}
			$this->proveedor = $proveedor;
			return $this;
		}

		public function pagarCompra(){
			$comprobante= new comprobanteEgreso(getdate(),$this);
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
				$compra->setNumeroFactura($resultado['numero_factura']);
				$compra->setFecha($resultado['fecha_compra']);
				$compra->setTotalCompra($resultado['total_compra']);
				$compra->setDescuento($resultado['descuento_compra']);

				$proveedor= Proveedor::obtenerProveedor($resultado['USUARIOS_id_proveedor'],false);

				$compra->setProveedor($proveedor);

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
		public function abastecer(){
			$productosxcompra=array();
			$conexion = Conexion::conectar();
			$statement= $this->verProductosxCompra;
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			while($resultado){
				$productoxcompra= ProductoXCompra::obtenerProductoXCompra($resultado["id_productoxcompra"]);
				$productosxcompra[]= $productoxcompra;
				$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			}
			foreach ($productosxcompra as $productoxcompra) {
				$conexion = Conexion::conectar();
				$statement = $conexion->prepare(" UPDATE `inventario` SET `precio`=:precio ,`unidades`=:unidades  WHERE `productos_id_producto`=:id_producto and `usuarios_id_usuario` = :id_usuario ");
				$proveedor= $productoxcompra->getProveedor();
				$producto=$productoxcompra->getProducto();
				$id_proveedor=$proveedor->getIdUsuario();
				$id_producto=$producto->getIdProducto();

				$inventario=Inventario::obtenerInventario($id_producto,$id_proveedor,true);

				$precio=(($producto->getValorUtilidad()/100) * $productosxcompra->getPrecioUnitario()) + $productosxcompra->getPrecioUnitario() ;
				$unidades= $inventario->getUnidades() + $productosxcompra->getNumeroUnidades();

				if(!$inventario){
					$inventario= new Inventario($precio,$unidades,0,$id_producto,$id_proveedor);

				}

				$inventario->setUnidades($unidades,$statement);
				$inventario->setPrecio($precio,$statement);
				$statement->bindValue(":id_producto", $id_producto);
				$statement->bindValue(":id_usuario", $id_proveedor);

				$statement->execute();
				if(!$statement){
					throw new Exception("Error Processing Request", 1);
					return ERROR;
				}
				$conexion = null;
				$statement=null;
				return SUCCESS;

			}
		}

		public function verProductosxCompra(){
			$idCompra=$this->getIdCompra();
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM productos INNER JOIN `productoxcompra` ON productoxcompra.productos_id_producto = productos.id_producto WHERE productoxcompra.COMPRAS_id_compra = :idCompra");
			$statement->bindParam(':idCompra',$idCompra,PDO::PARAM_INT);
			$statement->execute();
			$conexion=null;
			return $statement;
		}

	}




?>