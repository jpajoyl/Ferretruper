<?php 

/**
 * 
 */
class FacturaCompra {
	//atrubutos

	private $idFacturaCompra;
	private $compra;
	private $comprobanteEgreso;

//get & set
		public function getIdFacturaCompra(){
		return $this->idFacturaCompra;
	}

	public function setIdFacturaCompra($idFacturaCompra, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':idFacturaCompra',$idFacturaCompra,PDO::PARAM_INT);
		}
		$this->idFacturaCompra = $idFacturaCompra;
		return $this;
	}

	public function getCompra(){
		return $this->compra;
	}

	public function setCompra($compra, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':compra',$compra,PDO::PARAM_INT);
		}
		$this->compra = $compra;
		return $this;
	}

	public function getComprobanteEgreso(){
		return $this->comprobanteEgreso;
	}

	public function setComprobanteEgreso($comprobanteEgreso, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':comprobanteEgreso',$comprobanteEgreso,PDO::PARAM_INT);
		}
		$this->comprobanteEgreso = $comprobanteEgreso;
		return $this;
	}

	public function __construct(){
		$params = func_get_args();
		$num_params = func_num_args();
		if($num_params>0){
			call_user_func_array(array($this,"__construct0"),$params);
		}
	}

	public function __construct0($compra, $comprobanteEgreso){
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("INSERT INTO `factura_compra` (`idfactura_compra`, `compras_id_compra`, `comprobantes_egreso_id_comprobante_egreso`) VALUES (NULL, :compra, :comprobanteEgreso)");

		$this->setCompra($compra,$statement);
		$this->setComprobanteEgreso($comprobanteEgreso,$statement);
		$statement->execute();
		if(!$statement){
			throw new Exception("Error Processing Request", 1);
		}
		$conexion = NULL;
		$statement = NULL;
	}

	public static function facturaCompraPorComprobanteEgreso($idComprobanteEgreso){
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("SELECT * FROM factura_compra WHERE comprobantes_egreso_id_comprobante_egreso = :idComprobanteEgreso");
		$statement->bindParam(':idComprobanteEgreso',$idComprobanteEgreso,PDO::PARAM_INT);
		$statement->execute();
		$conexion = NULL;
		return $statement;
	}

	public static function obtenerProveedorPorFacturaCompra($idFacturaCompra)
	{
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("SELECT compras_id_compra FROM factura_compra WHERE idfactura_compra = :idFacturaCompra");
		$statement->bindParam(':idFacturaCompra',$idFacturaCompra,PDO::PARAM_INT);
		$statement->execute();
		$resultado = $statement->fetch(PDO::FETCH_ASSOC);
		$numeroCompra = $resultado['compras_id_compra'];
		$consulta = $conexion->prepare("SELECT USUARIOS_id_proveedor FROM compras WHERE id_compra = :numeroCompra");
		$consulta->bindParam(':numeroCompra',$numeroCompra,PDO::PARAM_INT);
		$consulta->execute();
		$resultado2=$consulta->fetch(PDO::FETCH_ASSOC);
		$numeroProveedor = $resultado2['USUARIOS_id_proveedor'];
		return Proveedor::obtenerProveedor($numeroProveedor, false);
	}

	
}









 ?>