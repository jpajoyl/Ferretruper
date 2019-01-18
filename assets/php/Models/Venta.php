<?php 

	/**
	 * 
	 */
	class Venta {
		

		//atributos
		private $idVenta;
		private $subtotal;
		private $iva;
		private $retefuente;
		private $total;
		private $descuento;
		private $fecha;
		private $anulada;//bool
		private $fechaAnulada;
		private $resolucion;	

		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($subtotal, $iva, $total, $fecha, $RESOLUCIONES_id_resolucion, $retefuente=null, $descuento=null, $anulada = 0, $fechaanulada=null){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `ventas` (`id_venta`, `subtotal`, `iva`, `retefuente`, `descuento`, `total`, `fecha`, `anulada`, `fecha_anulada`, `RESOLUCIONES_id_resolucion`) VALUES (NULL, :subtotal, :iva, :retefuente, :descuento, :total, :fecha, :anulada, :fechaAnulada, :resolucion)");

			$this->setSubtotal($subtotal,$statement);
			$this->setIva($iva,$statement);
			$this->setRetefuente($retefuente,$statement);
			$this->setDescuento($descuento,$statement);
			$this->setTotal($total,$statement);
			$this->setFecha($fecha,$statement);
			$this->setAnulada($anulada,$statement);
			$this->setFechaAnulada($fechaAnulada,$statement);
			$this->setResolucion($resolucion,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$conexion = NULL;
			$statement = NULL;
		}

		//get & set
		public function getIdVenta(){
			return $this->idVenta;
		}

		public function setIdVenta($idVenta){
			if($statement!=NULL){
				$statement->bindParam(':idVenta',$idVenta,PDO::PARAM_INT);
			}
			$this->idVenta = $idVenta;
			return $this;
		}

		public function getSubtotal(){
			return $this->subtotal;
		}

		public function setSubtotal($subtotal){
			if($statement!=NULL){
				$statement->bindParam(':subtotal',$subtotal,PDO::PARAM_INT);
			}
			$this->subtotal = $subtotal;
			return $this;
		}

		public function getIva(){
			return $this->iva;
		}

		public function setIva($iva){
			if($statement!=NULL){
				$statement->bindParam(':iva',$iva,PDO::PARAM_INT);
			}
			$this->iva = $iva;
			return $this;
		}

		public function getRetefuente(){
			return $this->retefuente;
		}

		public function setRetefuente($retefuente){
			if($statement!=NULL){
				$statement->bindParam(':retefuente',$retefuente,PDO::PARAM_INT);
			}
			$this->retefuente = $retefuente;
			return $this;
		}

		public function getTotal(){
			return $this->total;
		}

		public function setTotal($total){
			if($statement!=NULL){
				$statement->bindParam(':total',$total,PDO::PARAM_INT);
			}
			$this->total = $total;
			return $this;
		}

		public function getDescuento(){
			return $this->descuento;
		}

		public function setDescuento($descuento){
			if($statement!=NULL){
				$statement->bindParam(':descuento',$descuento,PDO::PARAM_INT);
			}
			$this->descuento = $descuento;
			return $this;
		}

		public function getFecha(){
			return $this->fecha;
		}

		public function setFecha($fecha){
			if($statement!=NULL){
				$statement->bindParam(':fecha',$fecha,PDO::PARAM_STR,45);
			}
			$this->fecha = $fecha;
			return $this;
		}

		public function getAnulada(){
			return $this->anulada;
		}

		public function setAnulada($anulada){
			if($statement!=NULL){
				$statement->bindParam(':anulada',$anulada,PDO::PARAM_INT);
			}
			$this->anulada = $anulada;
			return $this;
		}

		public function getFechaAnulada(){
			return $this->fechaanulada;
		}

		public function setFechaAnulada($fechaAnulada){
			if($statement!=NULL){
				$statement->bindParam(':fechaAnulada',$fechaAnulada,PDO::PARAM_STR,45);
			}
			$this->fechaAnulada = $fechaAnulada;
			return $this;
		}

		public function getResolucion(){
			return $this->resolucion;
		}

		public function setResolucion($resolucion){
			if($statement!=NULL){
				$statement->bindParam(':resolucion',$resolucion,PDO::PARAM_INT);
			}
			$this->resolucion = $resolucion;
			return $this;
		}

		public static function obtenerVenta($idVenta){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `ventas` WHERE  `idVenta` = :idVenta");
			$statement->bindValue(":idVenta", $idVenta);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado!=false){
				$venta = new Venta();
				$venta->setNumeroDian($resultado['numero_dian']);
				$venta->setSubtotal($resultado['subtotal']);
				$venta->setIva($resultado['iva']);
				$venta->setRetefuente($resultado['retefuente']);
				$venta->setDescuento($resultado['descuento']);
				$venta->setTotal($resultado['total']);
				$venta->setFecha($resultado['fecha']);
				$venta->setAnulada($resultado['anulada']);
				$venta->setFechaAnulada($resultado['fecha_anulada']);
				$venta->setResolucion($resultado['RESOLUCIONES_id_resolucion']);
				$conexion=null;
				$statement=null;
				return $venta;
			}else{
				return false;
			}

		}

		public function seleccionarProducto($idInventario, $numeroUnidades){

			$idVenta=$this->getIdVenta();
			$inventarioProducto = Inventario::obtenerInventario($idInventario);
			if ($inventarioProducto->getUnidades()>=$numeroUnidades) {
				$productoxventa = new ProductoXVenta($inventarioProducto->getPrecio(), $numeroUnidades, ($inventarioProducto->getProducto())->getIdProducto(), $this->getIdVenta());
				$unidadesResultantes = $inventarioProducto->getUnidades() - $numeroUnidades;
				$conexion = Conexion::conectar();
				$statement = $conexion->prepare("UPDATE `inventario` SET `unidades` = $unidadesResultantes WHERE `inventario`.`id_inventario` = $idInventario");
				$statement->execute();
				return $productoxventa;
			} else{
				return ERROR;
			}

		}

		public function efectuarCompra(){ //Factura


		}

	}


	?>