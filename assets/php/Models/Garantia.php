<?php 

	/**
	 * 
	 */
	class Garantia {
		

		//atributos
		private $idGarantia;
		private $fechaInicial;
		private $fechaFinal;
		private $unidadesDefectuosas; //no esta en la bd
		private $finalizada;

		private $producto;
		private $venta;

		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($fechaInicial, $id_producto, $id_venta, $finalizada = False, $fechaFinal= ""){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `garantias`(`id_garantias`, `fecha_inicial`, `fecha_caducacion`, `caducada`, `PRODUCTOS_id_producto`, `VENTAS_id_venta`) VALUES (null,:fechaInicial,:fechaFinal,:finalizada,:id_producto,:id_venta)");

			$this->setFechaInicial($fechaInicial,$statement);
			$this->setFechaFinal($fechaFinal,$statement);
			$this->setFinalizada($finalizada,$statement);
			$this->setDescuento($descuento,$statement);
			$this->setProducto($id_producto,$statement);
			$this->setVenta($id_venta,$statement);

			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$this->setIdGarantia($conexion->lastInsertId());
			$conexion = NULL;
			$statement = NULL;
		}

		//get & set
		public function getIdGarantia()
		{
		    return $this->idGarantia;
		}
		
		public function setIdGarantia($idGarantia)
		{
		    $this->idGarantia = $idGarantia;
		   
		}

		public function getFechaInicial()
		{
		    return $this->fechaInicial;
		}
		
		public function setFechaInicial($fechaInicial,$statement)
		{
			if ($statement != null){
				$statement->bindParam(':fechaInicial',$fechaInicial,PDO::PARAM_STR,45);
			}
		    $this->fechaInicial = $fechaInicial;
		   
		}

		public function getFechaFinal()
		{
		    return $this->fechaFinal;
		}
		
		public function setFechaFinal($fechaFinal,$statement)
		{
			if ($statement != null){
				$statement->bindParam(':fechaFinal',$fechaFinal,PDO::PARAM_STR,45);
			}
		    $this->fechaFinal = $fechaFinal;
		   
		}

		public function getUnidadesDefectuosas()
		{
		    return $this->unidadesDefectuosas;
		}
		
		public function setUnidadesDefectuosas($unidadesDefectuosas)
		{
		    $this->unidadesDefectuosas = $unidadesDefectuosas;
		   
		}

		public function getFinalizada()
		{
		    return $this->finalizada;
		}
		
		public function setFinalizada($finalizada,$statement)
		{
			if ($statement != null){
				$statement->bindParam(':finalizada',$finalizada,PDO::PARAM_STR,45);
			}
		    $this->finalizada = $finalizada;
		  
		}

		public function getProducto()
		{
		    return $this->producto;
		}
		
		public function setProducto($id_producto,$statement)
		{
			if ($statement != null){
				$statement->bindParam(':id_producto',$id_producto,PDO::PARAM_STR,45);
			}
		    $this->producto = Producto::obtenerProducto($id_producto);
		  
		}


		public function getVenta()
		{
		    return $this->venta;
		}
		
		public function setVenta($id_venta,$statement)
		{
			if ($statement != null){
				$statement->bindParam(':id_venta',$id_venta,PDO::PARAM_STR,45);
			}
		    $this->venta = Venta::obtenerVenta($id_venta);
		  
		}
	}






 ?>