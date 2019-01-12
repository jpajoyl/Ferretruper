<?php 

	/**
	 * 
	 */
	class ProductoXCompra {
		

		//atributtos
		private $id_productoxcompra;
		private $precioUnitario;
		private $numeroUnidades;
		private $descuentoProducto;
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

		public function __construct0($precioUnitario, $numeroUnidades, $descuentoProducto, $id_compra,$id_producto){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `productoxcompra`(`id_productoxcompra`, `precio_unitario`, `unidades`, `descuento`, `COMPRAS_id_compra`, `PRODUCTOS_id_producto`) VALUES (NULL,:precioUnitario,:unidades,:descuentos,:id_compra,:id_producto)");

			$this->setPrecioUnitario($precioUnitario,$statement);
			$this->setNumeroUnidades($numeroUnidades,$statement);
			$this->setProducto($id_compra,$statement);
			$this->setCompra($id_producto,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$conexion = NULL;
			$statement = NULL;
		}

		//get & set


		public function getIdProductoxCompra{
			return $this->id_productoxcompra;
		}
		public function setIdProductoxCompra($id_productoxcompra){
			$this->id_productoxcompra;
		}


		public function getPrecioUnitario()
		{
		    return $this->precioUnitario;
		}
		
		public function setPrecioUnitario($precioUnitario)
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
		
		public function setNumeroUnidades($numeroUnidades)
		{	
			if($statement!=NULL){
				$statement->bindParam(':unidades',$numeroUnidades,PDO::PARAM_INT);
			}
		    $this->numeroUnidades = $numeroUnidades;
		  
		}


		public function getDescuentoProducto()
		{
		    return $this->descuentoProducto;
		}
		
		public function setDescuentoProducto($descuentoProducto)
		{
			if($statement!=NULL){
				$statement->bindParam(':descuentos',$descuentoProducto,PDO::PARAM_INT);
			}
		    $this->descuentoProducto = $descuentoProducto;
		   
		}


		public function getProducto(){
			return $this->producto;
		}

		public function setProducto($id_producto){
			if($statement!=NULL){
				$statement->bindParam(':id_producto',$id_producto,PDO::PARAM_INT);
			}
			$this->producto = Producto::obtenerProducto($id_producto);
		}


		public function getCompra(){
			return $this->Compra;
		}

		public function setCompra($id_compra){
			if($statement!=NULL){
				$statement->bindParam(':id_compra',$id_compra,PDO::PARAM_INT);
			}
			$this->Compra = Compra::obtenerCompra($id_compra);
		}
	}

	public function calcularPrecioTotal(){
		$precioTotal=$this->getNumeroUnidades()*$this->getPrecioUnitario()
		return ($precioTotal)-(($precioTotal*$this->getDescuentoProducto())/100)
	}


	//Ver todos productos por compra jajjajajajajja jueputa 


 ?>