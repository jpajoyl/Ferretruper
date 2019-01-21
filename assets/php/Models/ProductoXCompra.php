<?php 


	/**
	 * 
	 */
	class ProductoXCompra {
		

		//atributtos
		private $idProductoxcompra;
		private $precioUnitario;
		private $numeroUnidades;
		//idk
		private $compra;
		private $producto;

		public function __construct(){ 
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($precioUnitario, $numeroUnidades, $idCompra,$idProducto){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `productoxcompra` (`id_productoxcompra`, `precio_unitario`, `unidades`, `COMPRAS_id_compra`, `PRODUCTOS_id_producto`) VALUES (NULL, :precioUnitario, :numeroUnidades, :idCompra, :idProducto)");

			$this->setPrecioUnitario($precioUnitario,$statement);
			$this->setNumeroUnidades($numeroUnidades,$statement);
			$this->setProducto($idProducto,$statement);
			$this->setCompra($idCompra,$statement);

			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$this->setIdProductoxCompra($conexion->lastInsertId());
			$conexion = NULL;
			$statement = NULL;
		}

		//get & set


		public function getIdProductoxCompra(){
			return $this->idProductoxcompra;
		}
		public function setIdProductoxCompra($idProductoxcompra){
			$this->idProductoxcompra;
		}


		public function getPrecioUnitario()
		{
		    return $this->precioUnitario;
		}
		
		public function setPrecioUnitario($precioUnitario, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':precioUnitario',$precioUnitario,PDO::PARAM_INT);
			}
		    $this->precioUnitario = $precioUnitario;
		    
		}


		public function getNumeroUnidades()
		{
		    return $this->numeroUnidades;
		}
		
		public function setNumeroUnidades($numeroUnidades, $statement=NULL)
		{	
			if($statement!=NULL){
				$statement->bindParam(':numeroUnidades',$numeroUnidades,PDO::PARAM_INT);
			}
		    $this->numeroUnidades = $numeroUnidades;
		  
		}



		public function getProducto(){
			return $this->producto;
		}

		public function setProducto($idProducto, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':idProducto',$idProducto,PDO::PARAM_INT);
			}
			$this->producto = Producto::obtenerProducto($idProducto);
		}


		public function getCompra(){
			return $this->Compra;
		}

		public function setCompra($idCompra, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':idCompra',$idCompra,PDO::PARAM_INT);
			}
			$this->Compra = Compra::obtenerCompra($idCompra);
		}

		public function calcularPrecioTotal(){
			$precioTotal=$this->getNumeroUnidades()*$this->getPrecioUnitario();
			return ($precioTotal)-(($precioTotal*$this->getDescuentoProducto())/100);
		}

		public static function obtenerProductoXCompra($idProductoxcompra){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `productoxcompra` WHERE `id_productoxcompra` = :idProductoxcompra");
			$statement->bindValue(":idProductoxcompra", $idProductoxcompra);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado!=false){
				$productoxcompra = new ProductoXCompra();
				$productoxcompra->setIdProductoxCompra($resultado['id_productoxcompra']);
				$productoxcompra->setPrecioUnitario($resultado['precio_unitario']);
				$productoxcompra->setNumeroUnidades($resultado['unidades']);

				$productoxcompra->setProducto($resultado['PRODUCTOS_id_producto']);
				$productoxcompra->setCompra($resultado['COMPRAS_id_compra']);

				$conexion=null;
				$statement=null;
				return $productoxcompra;
			}else{
				return false;
			}
		}

		public static function obtenerProductoXCompraConIdProductoIdCompra($idCompra,$idProducto){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `productoxcompra` WHERE `COMPRAS_id_compra` = :idCompra and `PRODUCTOS_id_producto` = :idProducto");
			$statement->bindValue(":idCompra", $idCompra);
			$statement->bindValue(":idProducto", $idProducto);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado!=false){
				$productoxcompra = new ProductoXCompra();
				$productoxcompra->setIdProductoxCompra($resultado['id_productoxcompra']);
				$productoxcompra->setPrecioUnitario($resultado['precio_unitario']);
				$productoxcompra->setNumeroUnidades($resultado['unidades']);

				$productoxcompra->setProducto($resultado['PRODUCTOS_id_producto']);
				$productoxcompra->setCompra($resultado['COMPRAS_id_compra']);

				$conexion=null;
				$statement=null;
				return $productoxcompra;
			}else{
				return false;
			}
		}

		public function eliminarProductoxCompra(){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("DELETE FROM `productoxcompra` WHERE `id_productoxcompra` = :idProductoxcompra");
			$statement->bindValue(":idProductoxcompra", $this->getIdProductoxCompra());
			$statement->execute();
			if($statement){
				return SUCCESS;
			}else{
				return ERROR;
			}
			$conexion=null;

		}

	}

	
 ?>