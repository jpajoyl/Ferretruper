<?php 

/**
 * 
 */
class Usuario{
	private $idUsuario;
	private $numeroDeIdentificacion;
	private $tipoDeIdentificacion;
	private $digitoDeVerificacion;
	private $nombre;
	private $direccion;
	private $ciudad;
	private $email;
	private $celular;
	private $telefono;
	private $clasificacion;
	private $activa;

	public function getDigitoDeVerificacion()
	{
		return $this->digitoDeVerificacion;
	}
	
	public function setDigitoDeVerificacion($digitoDeVerificacion, $statement=NULL)
	{
		if ($digitoDeVerificacion>=0) {
			if($statement!=NULL){
				$statement->bindParam(':digitoDeVerificacion',$digitoDeVerificacion,PDO::PARAM_INT);
			}
			$this->digitoDeVerificacion = $digitoDeVerificacion;
			return $this;
		}
	}
	public function getIdUsuario(){
		return $this->idUsuario;
	}

	public function setIdUsuario($idUsuario, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':idUsuario',$idUsuario,PDO::PARAM_INT);
		}
		$this->idUsuario = $idUsuario;
		return $this;
	}

	public function getNumeroDeIdentificacion(){
		return $this->numeroDeIdentificacion;
	}

	public function setNumeroDeIdentificacion($numeroDeIdentificacion, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':numeroDeIdentificacion',$numeroDeIdentificacion,PDO::PARAM_STR, 45);
		}
		$this->numeroDeIdentificacion = $numeroDeIdentificacion;
		return $this;
	}
	public function getTipoDeIdentificacion()
	{
		return $this->tipoDeIdentificacion;
	}
	
	public function setTipoDeIdentificacion($tipoDeIdentificacion, $statement=NULL)
	{
		if($statement!=NULL){
			$statement->bindParam(':tipoDeIdentificacion',$tipoDeIdentificacion,PDO::PARAM_STR, 45);
		}
		$this->tipoDeIdentificacion = $tipoDeIdentificacion;
		return $this;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function setNombre($nombre, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':nombre',$nombre,PDO::PARAM_STR,45);
		}
		$this->nombre = $nombre;
		return $this;
	}

	public function getDireccion(){
		return $this->direccion;
	}

	public function setDireccion($direccion, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':direccion',$direccion,PDO::PARAM_STR,255);
		}
		$this->direccion = $direccion;
		return $this;
	}

	public function getCiudad(){
		return $this->ciudad;
	}

	public function setCiudad($ciudad, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':ciudad',$ciudad,PDO::PARAM_STR,45);
		}
		$this->ciudad = $ciudad;
		return $this;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':email',$email,PDO::PARAM_STR,150);
		}
		$this->email = $email;
		return $this;
	}

	public function getCelular(){
		return $this->celular;
	}

	public function setCelular($celular, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':celular',$celular,PDO::PARAM_STR,20);
		}
		$this->celular = $celular;
		return $this;
	}

	public function getTelefono(){
		return $this->telefono;
	}

	public function setTelefono($telefono, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':telefono',$telefono,PDO::PARAM_STR,45);
		}
		$this->telefono = $telefono;
		return $this;
	}

	public function getClasificacion(){
		return $this->clasificacion;
	}

	public function setClasificacion($clasificacion, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':clasificacion',$clasificacion,PDO::PARAM_STR,45);
		}
		$this->clasificacion = $clasificacion;
		return $this;
	}

	public function getActiva(){
		return $this->activa;
	}

	public function setActiva($activa, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':activa',$activa,PDO::PARAM_INT);
		}
		$this->activa = $activa;
		return $this;
	}


	public function actualizarUsuario($idUsuario, $nombre, $direccion, $ciudad, $telefono, $clasificacion, $digitoDeVerificacion, $email, $celular) {
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("UPDATE `usuarios` SET `digito_de_verificacion` = :digitoDeVerificacion, `nombre` = :nombre, `direccion` = :direccion, `email` = :email, `ciudad` = :ciudad, `celular` = :celular, `telefono` = :telefono, `clasificacion` = :clasificacion WHERE `usuarios`.`id_usuario` = :idUsuario");

		$this->setDigitoDeVerificacion($digitoDeVerificacion,$statement);
		$this->setNombre($nombre,$statement);
		$this->setDireccion($direccion,$statement);
		$this->setCiudad($ciudad,$statement);
		$this->setEmail($email,$statement);
		$this->setCelular($celular,$statement);
		$this->setTelefono($telefono,$statement);
		$this->setClasificacion($clasificacion,$statement);
		$this->setIdUsuario($idUsuario,$statement);
		$statement->execute();
		$conexion=null;
		if($statement){
			$statement=null;
			return SUCCESS;
		}else{
			$statement=null;
			return ERROR;
		}
	}

	public function desactivarUsuario(){
		$idUsuario = $this->getIdUsuario();
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("UPDATE `usuarios` SET `activa` = '0' WHERE `usuarios`.`id_usuario` = :idUsuario");
		$statement->bindParam(':idUsuario',$idUsuario,PDO::PARAM_INT);
		$statement->execute();
		$resultado=ERROR;
		if($statement){
			$resultado=SUCCESS;
			$this->setActiva(0);
		}
		$conexion = null;
		$statement = null;
		return $resultado;
	}

	public static function buscarDatosUsuario($numeroDeConsulta,$modo = true){  //numero_identificacion->True, id Usuario->False
		$resultado = array();
		$conexion = Conexion::conectar();
		if($modo){
			$statement = $conexion->prepare("SELECT * FROM `usuarios` WHERE  numero_identificacion = :numeroDeConsulta");
		}else{
			$statement = $conexion->prepare("SELECT * FROM `usuarios` WHERE  `id_usuario` = :numeroDeConsulta");
		}
		$statement->bindParam(":numeroDeConsulta", $numeroDeConsulta);
		$statement->execute();
		$resultado = $statement->fetch(PDO::FETCH_ASSOC);
		$conexion = null;
		$statement = null;
		return $resultado;

	}


}









?>