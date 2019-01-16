<?php 

/**
 * 
 */
class FacturaCompra {
	//atrubutos

	private $idFacturaCompra;
	private $compra;
	private $comprobanteEgreso;



	public function __construct(){
		$params = func_get_args();
		$num_params = func_num_args();
		if($num_params>0){
			call_user_func_array(array($this,"__construct0"),$params);
		}
	}

	public function __construct0($fechaPago, $descripcion){ //compra es un objeto de ese tipo
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("INSERT INTO `comprobantes_egreso`(`id_comprobante_egreso`, `fecha_pago`, `descripcion`, `COMPRAS_id_compra`) VALUES (NULL,:fechaPago,:descripcion,:compra)");

		$this->setFechaPago($fechaPago,$statement);
		$this->setDescripcion($descripcion,$statement);
		$statement->execute();
		if(!$statement){
			throw new Exception("Error Processing Request", 1);
		}
		$conexion = NULL;
		$statement = NULL;
	}
}









 ?>