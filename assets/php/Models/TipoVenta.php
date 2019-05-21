<?php

/**
 * 
 */
class TipoVenta{
	private $idTipoVenta;
	private $tipoVenta; //Efectivo o Credito
	private $estado; // 0 no pagado ,1 pagado
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

	public function __construct0($id_cliente, $id_empleado, $id_venta, $tipoVenta, $plazo){
        $estado = 1;
        if ($tipoVenta == "Credito"){
             $estado = 0 ;
             if ($plazo == 0){
                return ERROR;
             }
        }
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("INSERT INTO `tipo_venta`(`id_tipo_venta`, `tipo_venta`, `estado`, `plazo`, `USUARIOS_id_cliente`, `USUARIOS_id_empleado`, `VENTAS_id_venta`) VALUES (null,:tipoVenta,:estado,:plazo,:id_cliente,:id_empleado,:id_venta)");
		$this->setTipoVenta($tipoVenta,$statement);
		$this->setEstado($estado,$statement);
		$this->setPlazo($plazo,$statement);
		$this->setCliente($id_cliente,$statement);
		$this->setEmpleado($id_empleado,$statement);
		$this->setVenta($id_venta,$statement);
		$statement->execute();
		if(!$statement){
			throw new Exception("Error Processing Request", 1);
		}
        $this->setIdTipoVenta($conexion->lastInsertId());
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
    	$this->cliente = $id_cliente;
    }



    public function getEmpleado() {
        return $this->empleado;
    }

    public function setEmpleado($id_empleado, $statement=NULL) {
    	if($statement!=NULL){
    		$statement->bindParam(':id_empleado',$id_empleado,PDO::PARAM_INT);
    	}
    	$this->empleado = $id_empleado;
    	return $this;
    }



    public function getVenta() {
        return $this->venta;
    }

    public function setVenta($id_venta, $statement=NULL) {
    	if($statement!=NULL){
    		$statement->bindParam(':id_venta',$id_venta,PDO::PARAM_INT);
    	}
    	$this->venta = $id_venta;

    }

    /*public static function obtenerTipoVentas(){
            $conexion = Conexion::conectar();
            $statement= $conexion->prepare("SELECT * FROM `ventas` INNER JOIN `tipo_venta` ON tipo_venta.VENTAS_id_venta = ventas.id_venta WHERE tipo_venta.estado = :estado"); 
            $statement->bindValue(":estado", 1);
            $statement->execute();
            $conexion=null;
            return $statement;
    }*/


    public static function obtenerTipoVentas(){
// Database connection info
            $dbDetails = array(
                'host' => 'localhost',
                'user' => 'root',
                'pass' => '',
                'db'   => 'ferretruperbd2'
            );

            // DB table to use
            $table = '`ventas` INNER JOIN `tipo_venta` ON tipo_venta.VENTAS_id_venta = ventas.id_venta';

            // Table's primary key
            $primaryKey = 'id_venta';

            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database. 
            // The `dt` parameter represents the DataTables column identifier.
            $columns = array(
                array( 'db' => 'id_venta', 'dt' => 0 ),
                array( 'db' => 'fecha',  'dt' => 1 ),
                array( 'db' => 'total',      'dt' => 2 ),
                array( 'db' => 'codigo_barras',     'dt' => 3 ),
                array( 'db' => 'unidades_totales',    'dt' => 4 ),

            );

            $whereStatement = 'WHERE tipo_venta.estado = :estado';

            // Include SQL query processing class
            require('../ssp.class.php');

            // Output data as json format
            return SSP::complex( $request, $dbDetails, $table, $primaryKey, $columns,null,$whereStatement );

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

    public function cambiarACredito($plazo = 30){
        $conexion = Conexion::conectar();
    	$tipoVenta="Credito";
        $statement = $conexion->prepare("UPDATE `tipo_venta` SET `tipo_venta`=:tipo_venta ,`estado`=:estado ,`plazo`= :plazo WHERE `id_tipo_venta` = :id_tipoVenta");

		$id_tipoVenta= $this->getIdTipoVenta();
		$statement->bindValue(":id_tipoVenta", $id_tipoVenta);
		$statement->bindValue(":tipo_venta", $tipoVenta);
        $statement->bindValue(":estado", 0);
        $statement->bindValue(":plazo", $plazo);
		$statement->execute();
        $conexion = null;

		if($statement){
			return SUCCESS;
		}else{
            return ERROR;
        }
        


    }

    public function cambiarAEfectivo(){
        $conexion = Conexion::conectar();
        $tipoVenta="Efectivo";
        $statement = $conexion->prepare("UPDATE `tipo_venta` SET `tipo_venta`=:tipo_venta WHERE `id_tipo_venta` = :id_tipoVenta");
        $id_tipoVenta= $this->getIdTipoVenta();
        $statement->bindValue(":id_tipoVenta", $id_tipoVenta);
        $statement->bindValue(":tipo_venta", $tipoVenta);
        $statement->execute();
        $conexion = null;
        if($statement){
            return SUCCESS;
        }else{
            return ERROR;
        }
    }

    public function pagarCredito(){
        $conexion = Conexion::conectar();
        $tipo_venta = $this->getTipoVenta();
        if ($tipo_venta == "Credito"){
            $idTipoVenta = $this->getIdTipoVenta();
            $statement = $conexion->prepare("UPDATE `tipo_venta` SET `estado`= :estado WHERE `id_tipo_venta` = :idTipoVenta");
            $statement->bindValue(":estado", 1);
            $statement->bindValue(":idTipoVenta", $idTipoVenta);
            $statement->execute();
            if($statement){
                return SUCCESS;
            }else{
                return ERROR;
            }
            
        }else{
            return ERROR;
        }

    }

    public function getTotalAbonado(){
        $conexion = Conexion::conectar();
        $idTipoVenta = $this->getIdTipoVenta();
        $statement = Abono::obtenerAbonos($idTipoVenta);
        $total = 0;
        while ($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
            $total += $resultado['valor'];
        }
        return $total;
    }

    public function getSaldoFaltante(){
        $venta = Venta::obtenerVenta($this->getVenta());
        $pagado = $this->getTotalAbonado();
        return ($venta->getTotal()-$pagado);
    }





}


 ?>