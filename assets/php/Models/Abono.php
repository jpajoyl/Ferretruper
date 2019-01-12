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

		public function __construct0($valor, $fecha, $id_Venta){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `abonos`(`id_abono`, `valor`, `fecha`, `TIPO_VENTA_id_tipo_venta`) VALUES (null,:valor,:fecha,:id_Venta)");
			$this->setNumeroDeIdentificacion($numeroDeIdentificacion,$statement);
			$this->setTipoDeIdentificacion($tipoDeIdentificacion,$statement);
			$this->setDigitoDeVerificacion($digitoDeVerificacion,$statement);
			$this->setNombre($nombre,$statement);
			$this->setDireccion($direccion,$statement);
			$this->setCiudad($ciudad,$statement);
			$this->setEmail($email,$statement);
			$this->setCelular($celular,$statement);
			$this->setTelefono($telefono,$statement);
			$this->setClasificacion($clasificacion,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
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
	    	if($statement!=NULL){
	    		$statement->bindParam(':id_Venta',$id_Venta,PDO::PARAM_STR,45);
	    	}
	    	$this->tipoVenta = (TipoVenta::obtenerTipoVenta($id_Venta))->getIdTipoVenta();
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





	}
	








 ?>