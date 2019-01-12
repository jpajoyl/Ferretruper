<?php 


	/**
	 * 
	 */
	class Credito {
		

		//atributos
		private $idCredito;
		private $fechaPlazo;
		private $saldado; //boolean


		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($idCredito, $fechaPlazo, $saldado, $VENTA_idVenta, $VENTA_CLIENTE_idCliente){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `credito` (`idCredito`, `fechaPlazo`, `saldado`, `VENTA_idVenta`, `VENTA_CLIENTE_idCliente`) VALUES (:idCredito, :fechaPlazo, :saldado, :VENTA_idVenta, :VENTA_CLIENTE_idCliente)");
			$this->setIdCredito($numeroConsecutivo,$statement);
			$this->setFechaPago($fechaPago,$statement);
			$statement->bindParam(':COMPRA_PROVEEDOR_nit',$COMPRA_PROVEEDOR_nit,PDO::PARAM_STR,45);
			$statement->bindParam(':COMPRA_codigoCompra',$COMPRA_codigoCompra,PDO::PARAM_INT);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$conexion = NULL;
			$statement = NULL;
		}
		//get & set
		public function getIdCredito()
		{
		    return $this->idCredito;
		}
		
		public function setIdCredito($idCredito, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':idCredito',$idCredito,PDO::PARAM_INT);
			}
			$this->idCredito = $idCredito;
			return $this;
		}

		public function getFechaPlazo()
		{
		    return $this->fechaPlazo;
		}
		
		public function setFechaPlazo($fechaPlazo, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':fechaPlazo',$fechaPlazo,PDO::PARAM_STR, 45);
			}
			$this->fechaPlazo = $fechaPlazo;
			return $this;
		}

		public function getSaldado()
		{
		    return $this->saldado;
		}
		
		public function setSaldado($saldado, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':saldado',$saldado,PDO::PARAM_STR, 45);
			}
			$this->saldado = $saldado;
			return $this;
		}



	}




 ?>