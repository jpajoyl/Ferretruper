<?php 

	/**
	 * 
	 */
	date_default_timezone_set("America/Bogota");
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
			$this->setIdVenta($conexion->lastInsertId());
			$conexion = NULL;
			$statement = NULL;
		}

		//get & set
		public function getIdVenta(){
			return $this->idVenta;
		}

		public function setIdVenta($idVenta, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':idVenta',$idVenta,PDO::PARAM_INT);
			}
			$this->idVenta = $idVenta;
			return $this;
		}

		public function getSubtotal(){
			return $this->subtotal;
		}

		public function setSubtotal($subtotal, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':subtotal',$subtotal,PDO::PARAM_INT);
			}
			$this->subtotal = $subtotal;
			return $this;
		}

		public function getIva(){
			return $this->iva;
		}

		public function setIva($iva, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':iva',$iva,PDO::PARAM_INT);
			}
			$this->iva = $iva;
			return $this;
		}

		public function getRetefuente(){
			return $this->retefuente;
		}

		public function setRetefuente($retefuente, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':retefuente',$retefuente,PDO::PARAM_INT);
			}
			$this->retefuente = $retefuente;
			return $this;
		}

		public function getTotal(){
			return $this->total;
		}

		public function setTotal($total, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':total',$total,PDO::PARAM_INT);
			}
			$this->total = $total;
			return $this;
		}

		public function getDescuento(){
			return $this->descuento;
		}

		public function setDescuento($descuento, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':descuento',$descuento,PDO::PARAM_INT);
			}
			$this->descuento = $descuento;
			return $this;
		}

		public function getFecha(){
			return $this->fecha;
		}

		public function setFecha($fecha, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':fecha',$fecha,PDO::PARAM_STR,45);
			}
			$this->fecha = $fecha;
			return $this;
		}

		public function getAnulada(){
			return $this->anulada;
		}

		public function setAnulada($anulada, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':anulada',$anulada,PDO::PARAM_INT);
			}
			$this->anulada = $anulada;
			return $this;
		}

		public function getFechaAnulada(){
			return $this->fechaanulada;
		}

		public function setFechaAnulada($fechaAnulada, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':fechaAnulada',$fechaAnulada,PDO::PARAM_STR,45);
			}
			$this->fechaAnulada = $fechaAnulada;
			return $this;
		}

		public function getResolucion(){
			return $this->resolucion;
		}

		public function setResolucion($resolucion, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':resolucion',$resolucion,PDO::PARAM_INT);
			}
			$this->resolucion = $resolucion;
			return $this;
		}

		public static function obtenerVenta($idVenta){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `ventas` WHERE  `id_venta` = :idVenta");
			$statement->bindValue(":idVenta", $idVenta);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado!=false){
				$venta = new Venta();
				$venta->setIdVenta($idVenta);
				$venta->setSubtotal($resultado['subtotal']);
				$venta->setIva($resultado['iva']);
				$venta->setRetefuente($resultado['retefuente']);
				$venta->setDescuento($resultado['descuento']);
				$venta->setTotal($resultado['total']);
				$venta->setFecha($resultado['fecha']);
				$venta->setAnulada($resultado['anulada']);
				$venta->setFechaAnulada($resultado['fecha_anulada']);
				$conexion=null;
				$statement=null;
				return $venta;
			}else{
				return false;
			}

		}

		public function seleccionarProducto($idProducto, $numeroUnidades){
			$arrayDistribucion=Array();

			$producto = Producto::obtenerProducto($idProducto);
			if($numeroUnidades< $producto-getUnidadesTotales()){

				$conexion = Conexion::conectar();	
				$statement= Inventario::obtenerInventariosParaVenta($idProducto);
				$resultado=$statement->fetch(PDO::FETCH_ASSOC);
				if($resultado){
					$unidadesSumadas=0;
					while($resultado){
						$idInventario=$resultado['id_inventario'];
						$unidadesInventario=$resultado['unidades'];
						$unidadesSumadas+=$unidadesInventario;
						if($unidadesSumadas< $numeroUnidades){
							$statement = null;
							$statement = $conexion->prepare("UPDATE `inventario` SET `unidades`=:unidades WHERE `id_inventario` = :idInventario");
							$unidadesRestantes=0;
							$statement->bindValue(":unidades", $unidadesRestantes);
							$statement->bindValue(":idInventario", $idInventario);
							$statement->execute();

						}elseif ($unidadesSumadas >= $numeroUnidades) {
							$unidadesRestantes= $unidadesSumadas-$numeroUnidades;
							$statement = null;
							$statement = $conexion->prepare("UPDATE `inventario` SET `unidades`=:unidades WHERE `id_inventario` = :idInventario");

							$statement->bindValue(":unidades", $unidadesRestantes);
							$statement->bindValue(":idInventario", $idInventario);
							$statement->execute();
							break;
						}

						if($statement){
							$arrayDistribucion[$idInventario]=$unidadesInventario-$unidadesRestantes;
						}else{
							return Error;
						}

					$resultado=$statement->fetch(PDO::FETCH_ASSOC);
					}

				$productoxventa = new ProductoXVenta($producto->getPrecioMayorInventario(), $numeroUnidades, $producto->getIdProducto(), $this->getIdVenta());
				$total=$this->getTotal()+($numeroUnidades*$producto->getPrecioMayorInventario());
				$this->setTotal($total);
				$subtotalIva=$total;
				if($producto->tieneIva()){
					$subtotalIva = $total/(1+IVA);
				}
				$this->setSubtotal($this->getSubtotal()+$subtotalIva);
				$conexion = null;
				$productoxventa->setArrayDistribucion($arrayDistribucion);
				return $productoxventa;	 //GUARDAR ESTO EN UN ARRAY;
				}else{
					return ERROR;
				}


			}

		}

		public function desseleccionarProducto($productoXVenta){ //OBJETO PRODUCTO X VENTA;
			$conexion = Conexion::conectar();
			$producto = $productoXVenta->getProducto();
			$unidades = $productoXVenta->getNumeroUnidades();
			$precio = $productoXVenta->getPrecioVenta();
			$arrayDistribucion = $productoXVenta->getArrayDistribucion();

			foreach ($arrayDistribucion as $idInventario => $unidadesRestadas) {
			 	$statement = null;
			 	$inventario= Inventario::obtenerInventario($idInventario);
			 	$unidadesNuevas = $inventario->getUnidades() + $unidadesRestadas; 
			 	$statement = $conexion->prepare("UPDATE `inventario` SET `unidades`=:unidadesNuevas WHERE `id_inventario` = :idInventario");
			 	$statement->bindValue(":unidadesNuevas", $unidadesNuevas);
			 	$statement->bindValue(":idInventario", $idInventario);
			 	$statement->execute();
			 	if(!$statement){
			 		return ERROR;
			 	}

			 }
			$statement = $conexion->prepare("DELETE FROM `productoxventa` WHERE `id_productoxventa` = :idProductoXVenta ");
			$statement->bindValue(":idProductoXVenta", $productoXVenta->getIdProductoxventa());
			$statement->execute();


			$total=$this->getTotal()-($unidades*$precio);
			$this->setTotal($total);
			$subtotalIva=$total;

			if($producto->tieneIva()){
				$subtotalIva = $total/(1+IVA);
			}
			$this->setSubtotal($this->getSubtotal()-$subtotalIva);

			$conexion = null;
			return SUCCESS;

		}


		public function cancelarVenta($productosxVenta){ //ARRAY CON LOS PRODUCTOS X VENTA;
			foreach ($productosxVenta as $productoxVenta) {
				$this->desseleccionarProducto($productoxVenta);
			}
			$conexion = Conexion::conectar();
			$conexion->prepare("DELETE FROM `ventas` WHERE `id_venta` = :idVenta");
			$statement->bindValue(":idVenta", $this->getIdVenta());
			$statement->execute();
			if(!$statement){
				return ERROR;
			}
			return SUCCESS;

		}

		public function obtenerInfoProductosProductoXVenta()
		{
			$idVenta=$this->getIdVenta();
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM productos INNER JOIN productoxventa ON productoxventa.PRODUCTOS_id_producto = productos.id_producto WHERE productoxventa.VENTAS_id_venta = :idVenta and productos.activa = 1");
			$statement->bindParam(':idVenta',$idVenta,PDO::PARAM_INT);
			$statement->execute();
			$conexion=null;
			return $statement;
		}

		public function efectuarVenta(){ //Factura
			$total=$this->getTotal();
			$conexion = Conexion::conectar();
			$statement= prepare("UPDATE `ventas` SET `subtotal`=:subtotal,`total`=:total WHERE `id_venta` = :idVenta");
			$statement->bindParam(':subtotal',$this->getSubtotal(),PDO::PARAM_INT);
			$statement->bindParam(':total',$total,PDO::PARAM_INT);
			$statement->bindParam(':idVenta',$this->getIdVenta(),PDO::PARAM_INT);
			$statement->execute();

			$statement = null;
			$resultado= null;
			$fecha=getDate();
			$resolucion=$this->getResolucion();
			$statement = $conexion->prepare("SELECT * FROM `resoluciones` WHERE `id_resolucion` = :idResolucion ");
			$statement->bindParam(':idResolucion',$resolucion,PDO::PARAM_INT);
			$statement->execute();
			$resultado=$statement->fetch(PDO::FETCH_ASSOC);
			if($resultado){
				$numeroDian = $resultado['numero_dian']+ 1;
				$factura = new factura($total,($fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday']),$resolucion,$this->getIdVenta(),$resolucion,$numeroDian);

				if($factura){
					$statement=null;
					$resultado=null;
					$numeroNuevoDian = $numeroDian;
					$statement=$conexion->prepare("UPDATE `resoluciones` SET `numero_dian`=:numeroNuevoDian WHERE `id_resolucion` = :idResolucion ");
					$statement->bindParam(':idResolucion',$resolucion,PDO::PARAM_INT);
					$statement->bindParam(':numeroNuevoDian',$numeroNuevoDian,PDO::PARAM_INT);
					$statement->execute();
				}else{
					return ERROR;
				}
			}else{
				return ERROR;
			}



		}

		public function verProductosxVenta(){
			$idVenta=$this->getIdVenta();
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM productos INNER JOIN `productoxventa` ON productoxventa.productos_id_producto = productos.id_producto WHERE productoxventa.VENTAS_id_venta = :idVenta");
			$statement->bindParam(':idVenta',$idVenta,PDO::PARAM_INT);
			$statement->execute();
			$conexion=null;
			return $statement;
		}


	}


	?>