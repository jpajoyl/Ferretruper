<?php 
	include "../Conexion.php";
	include "../Controllers/Response.php";
	include "Usuario.php";
	include "Proveedor.php";
	include "Producto.php";
	include "Inventario.php";
	include "Factura.php";
	include "ProductoXVenta.php";
	/**
	 * 
	 */
	date_default_timezone_set("America/Bogota");
	class Venta {
		private $arrayDistribucion = array();
		

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

		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($fecha, $subtotal = 0, $total = 0, $id_resolucion = 0, $retefuente=null, $descuento=null, $anulada = 0, $fechaanulada=null){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `ventas` (`id_venta`, `subtotal`, `iva`, `retefuente`, `descuento`, `total`, `fecha`, `anulada`, `fecha_anulada`) VALUES (NULL, :subtotal, :iva, :retefuente, :descuento, :total, :fecha, :anulada, :fechaAnulada)");

			$this->setSubtotal($subtotal,$statement);
			$this->setIva(IVA,$statement);
			$this->setRetefuente($retefuente,$statement);
			$this->setDescuento($descuento,$statement);
			$this->setTotal($total,$statement);
			$this->setFecha($fecha,$statement);
			$this->setAnulada($anulada,$statement);
			$this->setFechaAnulada($fechaanulada,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);

			}
			$idVenta = $conexion->lastInsertId();
			$this->setIdVenta($idVenta);
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


		public function getArrayDistribucion(){
			return $this->arrayDistribucion;
		}

		public function setArrayDistribucion($ArrayDistribucion){
			$this->arrayDistribucion = $ArrayDistribucion;
		}

		public function setSumaTotal($sumaTotal){
			$this->total = $this->total + $sumaTotal;
		}
		public function setSumaSubTotal($sumaSubTotal){
			$this->subtotal = $this->subtotal + $sumaSubTotal;
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

		public function seleccionarProducto($idProducto, $numeroUnidades, $precioVenta = 0){
			$arrayDistribucion=$this->getArrayDistribucion();
			$producto = Producto::obtenerProducto($idProducto);
			if($numeroUnidades<= $producto->getUnidadesTotales()){
				if ($precioVenta != 0){
					$precioVentaUnitario= $precioVenta/$numeroUnidades;
				}else{
					$precioVentaUnitario= $producto->getPrecioMayorInventario();
				}
				$productoxventa = new ProductoXVenta($precioVentaUnitario, $numeroUnidades, $producto->getIdProducto(), $this->getIdVenta());
				$idProductoXVenta=$productoxventa->getIdProductoxventa();
				$conexion = Conexion::conectar();
				$statement= Inventario::obtenerInventariosParaVenta($idProducto);
				$resultado=$statement->fetch(PDO::FETCH_ASSOC);
				if($resultado){
					$unidadesSumadas=0;
					$arrayDistribucionInventario = array();
					while($resultado){
						$idInventario=$resultado['id_inventario'];
						$unidadesInventario=intval($resultado['unidades']);
						$unidadesSumadas+=$unidadesInventario;
						if($unidadesSumadas< $numeroUnidades){
							$statement2 = null;
							$unidadesRestantes=0;
							$statement2 = $conexion->prepare("UPDATE `inventario` SET `unidades`=:unidades WHERE `id_inventario` = :idInventario");
							$statement2->bindValue(":unidades", $unidadesRestantes);
							$statement2->bindValue(":idInventario", $idInventario);
							$statement2->execute();
							$arrayDistribucionInventario[strval($idInventario)] = $unidadesInventario-$unidadesRestantes;

						}else if ($unidadesSumadas >= $numeroUnidades) {
							$unidadesRestantes= $unidadesSumadas-$numeroUnidades;
							$statement2 = null;
							$statement2 = $conexion->prepare("UPDATE `inventario` SET `unidades`=:unidades WHERE `id_inventario` = :idInventario");
							$statement2->bindValue(":unidades", $unidadesRestantes);
							$statement2->bindValue(":idInventario", $idInventario);
							$statement2->execute();
							$arrayDistribucionInventario[strval($idInventario)] = $unidadesInventario-$unidadesRestantes;
							break;
						}

						
						$resultado=$statement->fetch(PDO::FETCH_ASSOC);

					}

					$arrayDistribucion[strval($idProductoXVenta)] = $arrayDistribucionInventario;

					$total=($numeroUnidades*$precioVentaUnitario);
					$this->setSumaTotal($total);
					$subtotalIva=$total;
					if($producto->getTieneIva()){
						$subtotalIva = $total/(1+IVA);
					}
					$this->setSumaSubTotal($subtotalIva);
					$this->setArrayDistribucion($arrayDistribucion);
					$producto->calcularUnidades();
					$conexion = null;
					$statement=null;
					return SUCCESS;	 //GUARDAR ESTO EN UN ARRAY;
				}else{
					return ERROR;
				}
			}else{
				return NOT_FOUND;
			}

		}

		public function desseleccionarProducto($idProductoXVenta){ //OBJETO PRODUCTO X VENTA;
			$conexion = Conexion::conectar();
			$productoxventa = ProductoXVenta::obtenerProductoXVenta($idProductoXVenta);
			if($productoxventa){
				$producto = $productoxventa->getProducto();
				$unidades = $productoxventa->getNumeroUnidades();
				$precio = $productoxventa->getPrecioVenta();
				$arrayDistribucion = $this->getArrayDistribucion();
				$arrayDistribucionxProducto = $arrayDistribucion[$idProductoXVenta];

				foreach ($arrayDistribucionxProducto as $idInventario => $unidadesRestadas) {
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
				$statement->bindValue(":idProductoXVenta", $productoxventa->getIdProductoxventa());
				$statement->execute();


				$total=$this->getTotal()-($unidades*$precio);
				$subtotalIva=$total;

				if($producto->getTieneIva()){
					$subtotalIva = $total/(1+IVA);
				}
				$subtotal = $this->getSubtotal()-$subtotalIva;
				$this->setTotal($total);
				$this->setSubtotal($subtotal );

				$conexion = null;
				return SUCCESS;
			}else{
				echo "NO HAY PRODUCTO X VENTA";
				return ERROR;
			}

		}


		public function cancelarVenta(){ //Probar , no se si funcione;
			$arrayDistribucion = $this->getArrayDistribucion();
			foreach ($productosxVenta as $key => $value) {
				$this->desseleccionarProducto($key);
			}

			$conexion = Conexion::conectar();
			$conexion->prepare("DELETE FROM `ventas` WHERE `id_venta` = :idVenta");
			$statement->bindValue(":idVenta", $this->getIdVenta());
			$statement->execute();

			if(!$statement){
				return ERROR;
			}else{
				return SUCCESS;
			}


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

		public function efectuarVenta($resolucion,$idEmpleado, $tipoVenta = "Efectivo", $idCliente = 1){ //Factura
			$total=$this->getTotal();
			$conexion = Conexion::conectar();
			$statement= prepare("UPDATE `ventas` SET `subtotal`=:subtotal,`total`=:total WHERE `id_venta` = :idVenta");
			$statement->bindParam(':subtotal',$this->getSubtotal(),PDO::PARAM_INT);
			$statement->bindParam(':total',$total,PDO::PARAM_INT);
			$statement->bindParam(':idVenta',$this->getIdVenta(),PDO::PARAM_INT);
			$statement->execute();

			if ( $statement ){
				$statement = null;
				$resultado= null;
				$fecha=getDate();
				$statement = $conexion->prepare("SELECT * FROM `resoluciones` WHERE `id_resolucion` = :idResolucion ");
				$statement->bindParam(':idResolucion',$resolucion,PDO::PARAM_INT);
				$statement->execute();
				$resultado=$statement->fetch(PDO::FETCH_ASSOC);
				if($resultado){
					$numeroDian = $resultado['numero_dian']+ 1;
					$factura = new factura($total,($fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday']),$resolucion,$this->getIdVenta(),$resolucion,$numeroDian);

					if($factura){
						$this-asociarTipoVenta($idEmpleado,$tipoVenta,$idCliente);
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

		public static function verVentas(){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `ventas` WHERE 1 ORDER BY `ventas`.`id_venta` DESC ");
			$statement->execute();
			$conexion=null;
			return $statement;
		}

		public static function verVentasDelDia(){
			$conexion = Conexion::conectar();
			$fechaHoy=date('Y-m-d');
			$statement = $conexion->prepare("SELECT * FROM `ventas` WHERE `fecha` = :fechaHoy ORDER BY `ventas`.`id_venta` DESC ");
			$statement->bindValue(":fechaHoy", $fechaHoy);
			$statement->execute();
			$conexion=null;
			return $statement;
		}

		public function asociarTipoVenta($idEmpleado, $tipoVenta = "Efectivo", $idCliente = 1){
			$tipoVenta = new TipoVenta ($idCliente,$idEmpleado,$this->getIdVenta(),$tipoVenta);

		}

		public static function verCreditosActivos(){
			$tipoVenta= "Credito";
			$conexion = Conexion::conectar();
			$statement= $conexion->prepare("SELECT * FROM `ventas` INNER JOIN `tipo_venta` ON tipo_venta.VENTAS_id_venta = ventas.id_venta WHERE tipo_venta.estado = :estado and tipo_venta.tipo_venta = :tipoVenta"); 
			$statement->bindValue(":estado", 0);
			$statement->bindValue(":tipoVenta", $tipoVenta);
			$statement->execute();
			$conexion=null;
			return $statement;
		}

		public static function anularVenta($idVenta){ 
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `productoxventa` WHERE `VENTAS_id_venta` = :idVenta");
			$statement->bindValue(":idVenta", $idVenta);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado){
				while($resultado){
					$id_producto = $resultado['PRODUCTOS_id_producto'];
					$unidades = $resultado['unidades'];
					$statement2 = null;
					$statement2 = $conexion->prepare("SELECT * FROM `inventario` WHERE `productos_id_producto` = :idProducto ORDER BY `inventario`.`precio_inventario` DESC");
					$statement2->bindValue(":idProducto", $id_producto);
					$statement2->execute();
					$resultado2 =  $statement->fetch(PDO::FETCH_ASSOC);
					if($resultado2){
						$id_inventario = $resultado2['id_inventario'];
						$unidades = $resultado2['unidades'] + $unidades;
						$statement2 = null;
						$statement2 = $conexion->prepare("UPDATE `inventario` SET `unidades`=:unidades WHERE 1");
						$statement2->bindValue(":unidades", $unidades);
						$statement2->execute();

						if(!$statement2){
							return ERROR;
						}

					}else{
						return ERROR;
					}

					$resultado = $statement->fetch(PDO::FETCH_ASSOC);
				}

			$statement = null;
			$statement = $conexion->prepare("UPDATE `ventas` SET `anulada`= 1,`fecha_anulada`=:fechaAnulada WHERE 1");
			$fechaAnulada = date('Y-m-d');
			$statement->bindValue(":fechaAnulada", $fechaAnulada);
			$statement->execute();
			if($statement){
				$factura = Factura::obtenerFactura($this->getIdVenta(),false);
				$factura ->anularFactura();
			}else{
				return ERROR;
			}
			$statement = null;
			$conexion = null;
			return SUCCESS;

			}else{
				return ERROR;
			}

		}
	}
	$fecha = date('Y-m-d');
	$venta = new Venta($fecha);
	$venta->seleccionarProducto(1,1);
	echo "Total 1 : " . $venta->getTotal();
	echo "<br>SubTotal 1 : " . $venta->getSubtotal();
	$venta->seleccionarProducto(1,200);
	echo "<br>Total 2 : " . $venta->getTotal();
	echo "<br>SubTotal 2 : " . $venta->getSubtotal();
	echo "<br>";
	$array = $venta-> getArrayDistribucion();
	var_dump($array);
	$venta->desseleccionarProducto(77);


	echo "Total 3: " . $venta->getTotal();
	echo "<br>SubTotal 3 : " . $venta->getSubtotal();


	?>