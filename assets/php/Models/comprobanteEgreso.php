<?php 

	/**
	 * 
	 */
	class comprobanteEgreso {
		

		//atributos
		private $numeroConsecutivo;
		private $fechaPago;
		private $compra;//objeto compra


		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($fechaPago, $compra ){ //compra es un objeto de ese tipo
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `comprobantes_egreso`(`id_comprobante_egreso`, `fecha_pago`, `COMPRAS_id_compra`) VALUES (NULL,:fechaPago,:id_compra)");

			$this->setFechaPago($fechaPago,$statement);
			$this->setCompra($compra,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$conexion = NULL;
			$statement = NULL;
		}

		//get & set
		public function getNumeroConsecutivo()
		{
		    return $this->numeroConsecutivo;
		}
		
		public function setNumeroConsecutivo($numeroConsecutivo, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':numeroConsecutivo',$numeroConsecutivo,PDO::PARAM_INT);
			}
			$this->numeroConsecutivo = $numeroConsecutivo;
			return $this;
		}

		public function getFechaPago()
		{
		    return $this->fechaPago;
		}
		
		public function setFechaPago($fechaPago, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':fechaPago',$fechaPago,PDO::PARAM_STR, 45);
			}
			$this->fechaPago = $fechaPago;
			return $this;
		}

		public function getCompra()
		{
		    return $this->compra;
		}
		
		public function setCompra($compra, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':id_compra',$compra->getIdCompra(),PDO::PARAM_STR, 45);
			}
			$this->compra = $compra;
			return $this;
		}

		public static function obtenerComprovanteEgreso($numeroDeConsulta, $modo=true){
			//idComprovanteEgreso->True, idCompra->False
			$conexion = Conexion::conectar();
			if ($modo) {
				$statement = $conexion->prepare("SELECT * FROM `comprobantes_egreso` WHERE  `id_comprobante_egreso` = :numeroDeConsulta");
			}else{
				$statement = $conexion->prepare("SELECT * FROM `comprobantes_egreso` WHERE  `COMPRAS_id_compra` = :numeroDeConsulta");
			}
			
			$statement->bindValue(":numeroDeConsulta", $numeroDeConsulta);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado!=false){
				$comprovanteEgreso = new comprobanteEgreso();
				$comprovanteEgreso->setNumeroConsecutivo($resultado['id_comprobante_egreso']);
				$comprovanteEgreso->setFechaPago($resultado['fecha_pago']);
				$compra = Compra::obtenerCompra($resultado['COMPRAS_id_compra']);
				$comprovanteEgreso->setCompra($compra);
				$conexion=null;
				$statement=null;
				return $comprovanteEgreso;
			}else{
				$conexion=null;
				$statement=null;
				return false;
			}
		}


		public function imprimirComprobante(){



		}



	}


 ?>