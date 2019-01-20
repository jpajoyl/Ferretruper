<?php

/**
 * 
 */
class TipoVenta{
	private $idTipoVenta;
	private $tipoVenta; //Decontado o Credito
	private $estado;
	private $plazo;

	private $cliente;
	private $empleado;
	private $venta;

	public function __construct(){
		$params = func_get_args();
		$num_params = func_num_args();
		if($num_params>0){
			call_user_func_array(array($this,"__construct0"),$params);
		}
	}

	public function __construct0($id_cliente, $id_empleado, $id_venta, $tipoVenta="Decontado", $estado="", $plazo=0){
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("INSERT INTO `tipo_venta`(`id_tipo_venta`, `tipo_venta`, `estado`, `plazo`, `USUARIOS_id_cliente`, `USUARIOS_id_empleado`, `VENTAS_id_venta`) VALUES (null,:tipoVenta,:estado,:plazo,:id_cliente,:id_empleado,:id_venta)");
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
        $this->setCliente($cliente,$statement);
		$statement->execute();
		if(!$statement){
			throw new Exception("Error Processing Request", 1);
		}
		$conexion = null;
    	$statement=null;
	}

	public function getIdTipoVenta() {
        return $this->idTipoVenta;
    }

    public function setIdTipoVenta($idTipoVenta, $statement=NULL) {
    	if($statement!=NULL){
    		$statement->bindParam(':idTipoVenta',$idTipoVenta,PDO::PARAM_STR,45);
    	}
    	$this->idTipoVenta = $idTipoVenta;
 
    }


	public function getTipoVenta() {
        return $this->tipoVenta;
    }

    public function setTipoVenta($tipoVenta, $statement=NULL) {
    	if($statement!=NULL){
    		$statement->bindParam(':tipoVenta',$tipoVenta,PDO::PARAM_STR,45);
    	}
    	$this->tipoVenta = $tipoVenta;
    }


    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado, $statement=NULL) {
    	if($statement!=NULL){
    		$statement->bindParam(':estado',$estado,PDO::PARAM_STR,45);
    	}
    	$this->estado = $estado;
    }


    public function getPlazo() {
        return $this->plazo;
    }

    public function setPlazo($plazo, $statement=NULL) {
    	if($statement!=NULL){
    		$statement->bindParam(':plazo',$plazo,PDO::PARAM_STR,45);
    	}
    	$this->plazo = $plazo;
    }


    public function getCliente() {
        return $this->cliente;
    }

    public function setCliente($id_cliente, $statement=NULL) {
    	if($statement!=NULL){
    		$statement->bindParam(':id_cliente',$id_cliente,PDO::PARAM_INT);
    	}
    	$this->cliente = Cliente::obtenerCliente($id_cliente,false);
    }



    public function getEmpleado() {
        return $this->empleado;
    }

    public function setEmpleado($id_empleado, $statement=NULL) {
    	if($statement!=NULL){
    		$statement->bindParam(':id_empleado',$id_empleado,PDO::PARAM_INT);
    	}
    	$this->empleado = Empleado::obtenerEmpleado($id_empleado,false);
    	return $this;
    }



    public function getVenta() {
        return $this->venta;
    }

    public function setVenta($id_venta, $statement=NULL) {
    	if($statement!=NULL){
    		$statement->bindParam(':id_venta',$id_venta,PDO::PARAM_INT);
    	}
    	$this->venta = Venta::obtenerVenta($id_venta);
    	return $this;
    }


    public static function obtenerTipoVenta($idVenta){ 
    	$conexion = Conexion::conectar();
    	$statement = $conexion->prepare("SELECT * FROM `tipo_venta` WHERE  `VENTAS_id_venta`= :idVenta");
    	$statement->bindParam(":idVenta", $idVenta);
    	$statement->execute();
    	$resultado = $statement->fetch(PDO::FETCH_ASSOC);
    	if($statement!=false){
    		$tipoVenta = new TipoVenta();
    		$tipoVenta->setIdTipoVenta($resultado['id_tipo_venta']);
    		$tipoVenta->setTipoVenta($resultado['tipo_venta']);
    		$tipoVenta->setEstado($resultado['estado']);
    		$tipoVenta->setPlazo($resultado['plazo']);
    		$tipoVenta->setCliente($resultado['USUARIOS_id_cliente']);
    		$tipoVenta->setEmpleado($resultado['USUARIOS_id_empleado']);
    		$tipoVenta->setVenta($resultado['VENTAS_id_venta']);

    		$conexion=null;
    		$statement=null;
    		return $tipoVenta;
    	}else{
    		return ERROR;
    	}

    }

    public function verAbonos(){
    	if ($this->getTipoVenta()=="Credito"){
    		$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `abonos` WHERE `id_tipo_venta` = :id_tipoVenta");
			$id_tipoVenta= $this->getIdTipoVenta();
			$statement->bindValue(":id_tipoVenta", $id_tipoVenta);
			$statement->execute();
			return $statement;
    	}
    	return ERROR;


    }

    public function cambiarTipoVenta(){
    	if($this->getTipoVenta()== "Decontado"){
    		$tipoVenta="Credito";
    	}else if ($this->getTipoVenta() == "Credito"){
    		$tipoVenta="Decontado";
    	}
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("UPDATE `tipo_venta` SET `tipo_venta`=:tipo_venta WHERE `id_tipo_venta` = :id_tipoVenta");
		$id_tipoVenta= $this->getIdTipoVenta();
		$statement->bindValue(":id_tipoVenta", $id_tipoVenta);
		$statement->bindValue(":tipo_venta", $tipoVenta);
		$statement->execute();

		if($statement){
			return SUCCESS;
		}


    }





}


 ?>