<?php 


	/**
	 * 
	 */
	class ProductoXVenta {


		//atributos
		private $idProductoxventa;
		private $numeroUnidades;
		private $precioUnitario;
		private $producto;
		private $venta;

		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($precioUnitario, $unidades, $id_producto, $id_venta){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `productoxventa` (`id_productoxventa`, `precio_unitario`, `unidades`, `PRODUCTOS_id_producto`, `VENTAS_id_venta`) VALUES (NULL, :precioUnitario, :numeroUnidades, :id_producto, :id_venta)");

			$this->setPrecioUnitario($precioUnitario,$statement);
			$this->setNumeroUnidades($numeroUnidades,$statement);
			$this->setProducto($id_producto,$statement);
			$this->setVenta($id_venta,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
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

		public function getPrecioUnitario(){
			return $this->precioUnitario;
		}

		public function setPrecioUnitario($precioUnitario, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':precioUnitario',$precioUnitario,PDO::PARAM_INT);
			}
			$this->precioUnitario = $precioUnitario;
			
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


	}

 ?>