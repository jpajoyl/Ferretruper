<?php 


	/**
	 * 
	 */
	class ProductoXVenta {
		

		//atributos
		private $idProductoxventa;
		private $numeroUnidades;
		private $precioVenta;
		private $producprecioVentato;
		private $venta;

		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($precioVenta, $unidades, $id_producto, $id_venta){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `productoxventa` (`id_productoxventa`, `precio_venta`, `unidades`, `PRODUCTOS_id_producto`, `VENTAS_id_venta`) VALUES (NULL, :precioVenta, :numeroUnidades, :id_producto, :id_venta)");

			$this->setPrecioVenta($precioVenta,$statement);
			$this->setNumeroUnidades($unidades,$statement);
			$this->setProducto($id_producto,$statement);
			$this->setVenta($id_venta,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$this->setIdProductoxventa($conexion->lastInsertId());
			$conexion = NULL;
			$statement = NULL;
		}


		//get & set
		public function getIdProductoxventa(){
			return $this->idProductoxventa;
		}

		public function setIdProductoxventa($idProductoxventa, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':idProductoxventa',$idProductoxventa,PDO::PARAM_INT);
			}
			$this->idProductoxventa = $idProductoxventa;
			
		}

		public function getNumeroUnidades(){
			return $this->numeroUnidades;
		}

		public function setNumeroUnidades($numeroUnidades, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':numeroUnidades',$numeroUnidades,PDO::PARAM_INT);
			}
			$this->numeroUnidades = $numeroUnidades;
			
		}

		public function getPrecioVenta(){
			return $this->precioVenta;
		}

		public function setPrecioVenta($precioVenta, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':precioVenta',$precioVenta,PDO::PARAM_INT);
			}
			$this->precioVenta = $precioVenta;
		}
		public function getProducto(){
			return $this->producto;
		}

		public function setProducto($id_producto, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':id_producto',$id_producto,PDO::PARAM_INT);
			}
			$this->producto = Producto::obtenerProducto($id_producto);

		}

		public function getVenta(){
			return $this->venta;
		}

		public function setVenta($id_venta, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':id_venta',$id_venta,PDO::PARAM_INT);
			}
			$this->venta = Venta::obtenerVenta($id_venta);
		}



		//methods

		public static function obtenerProductoXVenta($idProductoxventa)
		{
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `productoxventa` WHERE `id_productoxventa` = :idProductoxventa");
			$statement->bindValue(":idProductoxventa", $idProductoxventa);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado!=false){
				$productoxventa = new ProductoXVenta();
				$productoxventa->setIdProductoxventa($idProductoxventa);
				$productoxventa->setNumeroUnidades($resultado['unidades']);
				$productoxventa->setPrecioVenta($resultado['precio_venta']);

				$productoxventa->setProducto($resultado['PRODUCTOS_id_producto']);
				$productoxventa->setVenta($resultado['VENTAS_id_venta']);

				$conexion=null;
				$statement=null;
				return $productoxventa;
			}else{
				return false;
			}
		}

	}

	?>