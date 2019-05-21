<?php 

	Class Abono{

		private $idAbono;
		private $valor;
		private $fecha;

		private $tipoVenta;

		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($valor, $fecha, $id_Venta){  //Id_venta es el id de la VENTAAAAAAAAAAAAAAAAAAAAAAA
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `abonos`(`id_abono`, `valor`, `fecha`, `TIPO_VENTA_id_tipo_venta`) VALUES (null,:valor,:fecha,:id_Venta)");
			$this->setValor($valor,$statement);
			$this->setFecha($fecha,$statement);
			$this->setTipoVenta($id_Venta,$statement);

			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$this->setIdAbono($conexion->lastInsertId());

			$tipoVenta= $this->getTipoVenta();
			$faltante = $tipoVenta->getSaldoFaltante();
			if($faltante<=0){
				$tipoVenta->pagarCredito();
			}
			$conexion = null;
	    	$statement=null;
		}

		public function getIdAbono() {
	        return $this->idAbono;
	    }

	    public function setIdAbono($idAbono, $statement=NULL) {
	    	if($statement!=NULL){
	    		$statement->bindParam(':idAbono',$idAbono,PDO::PARAM_INT);
	    	}
	    	$this->idAbono = $idAbono;
	    }


		public function getValor() {
	        return $this->valor;
	    }

	    public function setValor($valor, $statement=NULL) {
	    	if($statement!=NULL){
	    		$statement->bindParam(':valor',$valor,PDO::PARAM_INT);
	    	}
	    	$this->valor = $valor;
	    }


	   	public function getFecha() {
	        return $this->fecha;
	    }

	    public function setFecha($fecha, $statement=NULL) {
	    	if($statement!=NULL){
	    		$statement->bindParam(':fecha',$fecha,PDO::PARAM_STR,45);
	    	}
	    	$this->fecha = $fecha;
	    }


	   	public function getTipoVenta() {
	        return $this->tipoVenta;
	    }

	    public function setTipoVenta($id_Venta, $statement=NULL) {  //Mando el id de venta
			$tipoVenta=TipoVenta::obtenerTipoVenta($id_Venta);
			if($statement!=NULL){
	    		$statement->bindParam(':id_Venta',$tipoVenta->getIdTipoVenta(),PDO::PARAM_STR,45);
	    	}
	    }


	    public function elminarAbono(){
	    	$id_abono=$this->getIdAbono();
	    	$conexion = Conexion::conectar();
			$statement = $conexion->prepare("DELETE FROM `abonos` WHERE `id_abono` = :id_abono");
			$statement->bindValue(":id_abono", $id_abono);
			if($statement){
				return SUCCESS;
			}
			else{
				return ERROR;
			}

	    }

	    public function modificarAbono($valor){
	    	$id_abono=$this->getIdAbono();
	    	$conexion = Conexion::conectar();
			$statement = $conexion->prepare("UPDATE `abonos` SET `valor`=:valor  WHERE `id_abono` = :id_abono");
			$statement->bindValue(":id_abono", $id_abono);
			$this->setValor($valor,$statement);

			$statement->execute();
			
	    }
	    public static function obtenerAbono($idAbono)
	    {
	    	$conexion = Conexion::conectar();
	    	$statement = $conexion->prepare("SELECT * FROM `abonos` WHERE  `id_abono`= :idAbono");
	    	$statement->bindParam(":idAbono", $idAbono);
	    	$statement->execute();
	    	$resultado = $statement->fetch(PDO::FETCH_ASSOC);
	    	if($statement!=false){
	    		$abono = new Abono();
	    		$abono->setIdAbono($resultado['id_abono']);
	    		$abono->setValor($resultado['valor']);
	    		$abono->setFecha($resultado['fecha']);
	    		$abono->setTipoVenta($resultado['TIPO_VENTA_id_tipo_venta']);
	    		$conexion=null;
	    		$statement=null;
	    		return $abono;
	    	}else{
	    		return ERROR;
	    	}
	    }
	    public static function obtenerAbonos($idTipoVenta){
	    	$conexion = Conexion::conectar();
	    	$statement = $conexion->prepare("SELECT * FROM `abonos` WHERE TIPO_VENTA_id_tipo_venta = :idTipoVenta");
	    	$statement->bindParam(":idTipoVenta",$idTipoVenta);
	    	$statement->execute();
	    	$conexion=null;
	    	return $statement;
	    }





	}
	








 ?>