<?php 
	/*include "../Conexion.php";
	include "../Controllers/Response.php";
	include "Usuario.php";
	include "Proveedor.php";
	include "Producto.php";
	include "Inventario.php";
	include "Factura.php";
	include "ProductoXVenta.php";
	include "TipoVenta.php";*/
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
				$conexion = null;
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
					$this->setSumaTotal(round($total));
					$subtotalIva=$total;
					if($producto->getTieneIva()){
						$subtotalIva = $total/(1+IVA);
					}
					$this->setSumaSubTotal(round($subtotalIva));
					$this->setArrayDistribucion($arrayDistribucion);
					$producto->calcularUnidades();
					$conexion = null;
					$statement=null;
					return SUCCESS;	 
				}else{
					return ERROR;
				}
			}else{
				return NOT_FOUND;
			}

		}

		public function desseleccionarProducto($idProductoXVenta){ 
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
						$conexion = null;
						return ERROR;
					}

				}
				$statement = $conexion->prepare("DELETE FROM `productoxventa` WHERE `id_productoxventa` = :idProductoXVenta ");
				$statement->bindValue(":idProductoXVenta", $productoxventa->getIdProductoxventa());
				$statement->execute();

				$precioProductoxventa=($unidades*$precio);
				$total=$this->getTotal()-$precioProductoxventa;
				$subtotalIva=$precioProductoxventa;

				if($producto->getTieneIva()){
					$subtotalIva = $precioProductoxventa/(1+IVA);
				}
				$subtotal = $this->getSubtotal()-$subtotalIva;
				$this->setTotal(round($total));
				$this->setSubtotal(round($subtotal));

				$producto->calcularUnidades();
				$conexion = null;
				return SUCCESS;
			}else{
				$conexion = null;
				return ERROR;
			}

		}


		public function cancelarVenta(){ 
			$idVenta=$this->getIdVenta();
			$arrayDistribucion = $this->getArrayDistribucion();
			foreach ($arrayDistribucion as $key => $value) {
				$this->desseleccionarProducto($key);
			}

			$conexion = Conexion::conectar();
			$statement= $conexion->prepare("DELETE FROM `ventas` WHERE `id_venta` = :idVenta");
			$statement->bindValue(":idVenta",$idVenta);
			$statement->execute();

			if(!$statement){
				$conexion = null;
				return ERROR;
			}else{
				$conexion = null;
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

		public function efectuarVenta($resolucion=1,$idEmpleado,$iva,$subtotal, $descuento = 0, $retefuente = 0, $tipoVenta = "Efectivo", $idCliente = 1,$plazo=0){ //$resolucion,$empleado->getIdUsuario(),$iva,$subtotal,$descuento,$descuentoPorcentual,$retefuente,$tipoVenta,$cliente->getIdUsuario());
		//Factura
			$total=$iva+$subtotal;
			$conexion = Conexion::conectar();
			$statement=$conexion->prepare("UPDATE `ventas` SET `descuento`=:descuento, `iva` = :iva , `retefuente` = :retefuente, `subtotal`=:subtotal,`total`=:total WHERE `id_venta` = :idVenta");
			$idVenta = $this->getIdVenta();
			$statement->bindValue(':idVenta',$idVenta);
			$statement->bindValue(':descuento',$descuento);
			$statement->bindValue(':retefuente',$retefuente);
			$this->setSubtotal($subtotal,$statement);
			$this->setTotal($total,$statement);
			$this->setIva($iva,$statement);
			$statement->execute();

			if ( $statement ){
				$statement = null;
				$resultado= null;
				$fecha = date('Y-m-d');
				$statement = $conexion->prepare("SELECT * FROM `resoluciones` WHERE `id_resolucion` = :idResolucion ");
				$statement->bindParam(':idResolucion',$resolucion,PDO::PARAM_INT);
				$statement->execute();
				$resultado=$statement->fetch(PDO::FETCH_ASSOC);
				if($resultado){
					$numeroDian = $resultado['numero_dian']+ 1;
					$idInformacionFactura=$resolucion;
					$factura = new factura($total,$fecha,$idInformacionFactura,$idVenta,$resolucion,$numeroDian); 
					if($factura){
						$this->asociarTipoVenta($idEmpleado,$tipoVenta,$idCliente,$plazo);
						$statement=null;
						$resultado=null;
						$numeroNuevoDian = $numeroDian;
						$statement=$conexion->prepare("UPDATE `resoluciones` SET `numero_dian`=:numeroNuevoDian WHERE `id_resolucion` = :idResolucion ");
						$statement->bindParam(':idResolucion',$resolucion,PDO::PARAM_INT);
						$statement->bindParam(':numeroNuevoDian',$numeroNuevoDian,PDO::PARAM_INT);
						$statement->execute();

						$conexion =null;
						return $factura;

					}else{
						$conexion = null;
						return ERROR;
					}
				}else{
					$conexion = null;
					return ERROR;
				}
			}else{
				$conexion = null;
				return Error;
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

		public static function verVentasStatement(){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `ventas` WHERE 1 ORDER BY `ventas`.`id_venta` DESC ");
			$statement->execute();
			$conexion=null;
			return $statement;
		}

		public static function verVentas($request,$papelera=true){
		// Database connection info
			$dbDetails = array(
				'host' => 'localhost',
				'user' => 'root',
				'pass' => '',
				'db'   => 'ferretruperbd2'
			);

            // DB table to use
			$table = 'ventas';

            // Table's primary key
			$primaryKey = 'id_venta';

            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database. 
            // The `dt` parameter represents the DataTables column identifier.

			$columns = array(
				array( 'db' => '`ventas`.`id_venta`', 'dt' => 0, 'field' => 'id_venta'),
				array( 'db' => '`ventas`.`fecha`',  'dt' => 1, 'field' => 'fecha'),
				array( 'db' => '`ventas`.`total`',
				       'dt' => 2,
				       'field' => 'total',
				       'formatter' => function( $d, $row ) {
					       	return number_format($d);
				       }
				   ),
				array( 'db' => '`facturas`.`numero_dian`',     'dt' => 3, 'field' => 'numero_dian'),
				array(
					'db'        => '`ventas`.`anulada`',
					'dt'        => 4,
					'field' => 'anulada',
					'formatter' => function( $d, $row ) {
						if($d==0){
							return "<center><button class='btn btn-danger btn-xs anular-factura'><i class='fa fa-trash-o'></i></button> </button><button class='btn btn-primary btn-xs emitir-factura'><i class='fa fa-print'></i></button></center>";
						}else  if($d==1){
							return "<center></button><button class='btn btn-warning btn-xs emitir-factura-anulada'><i class='fa fa-print'></i></button></center>";
						}else{
							return "";
						}
					}
				)


			);

			if(!$papelera){
				$whereStatement = '`ventas`.`anulada`=0';
			}else{
				$whereStatement = '`ventas`.`anulada`=1';
			}
            // Include SQL query processing class
			require('../ssp.customized.class.php');
			$joinQuery = "FROM `ventas` JOIN `facturas` ON (`ventas`.`id_venta` = `facturas`.`ventas_id_venta`)";

            // Output data
			return SSP::simple( $request, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $whereStatement);
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

		public function asociarTipoVenta($idEmpleado, $tipoVenta = "Efectivo", $idCliente = 1,$plazo){

			$tipoVenta = new TipoVenta ($idCliente,$idEmpleado,$this->getIdVenta(),$tipoVenta,$plazo);

		}

		public static function verCreditos($request,$pagado=false){
			/*$tipoVenta= "Credito";
			$conexion = Conexion::conectar();
			$statement= $conexion->prepare("SELECT * FROM `ventas` JOIN `tipo_venta` ON tipo_venta.VENTAS_id_venta = ventas.id_venta JOIN `usuarios` ON tipo_venta.USUARIOS_id_cliente = usuarios.id_usuario WHERE tipo_venta.estado = :estado and tipo_venta.tipo_venta = :tipoVenta"); 
			$statement->bindValue(":estado", $activos);
			$statement->bindValue(":tipoVenta", $tipoVenta);
			$statement->execute();
			$conexion=null;
			return $statement;*/

					// Database connection info
			$dbDetails = array(
				'host' => 'localhost',
				'user' => 'root',
				'pass' => '',
				'db'   => 'ferretruperbd2'
			);

			            // DB table to use
			$table = 'ventas';

			            // Table's primary key
			$primaryKey = 'id_venta';

			            // Array of database columns which should be read and sent back to DataTables.
			            // The `db` parameter represents the column name in the database. 
			            // The `dt` parameter represents the DataTables column identifier.

			$columns = array(
				array( 'db' => '`ventas`.`id_venta`', 'dt' => 0, 'field' => 'id_venta'),
				array( 'db' => 'id_tipo_venta','dt' => 1, 'field' => 'id_tipo_venta'),
				array( 'db' => '`usuarios`.`numero_identificacion`',  'dt' => 2, 'field' => 'numero_identificacion'),
				array( 'db' => '`ventas`.`total`',
					   'dt' => 3,
					   'field' => 'total',
					   'formatter' => function( $d, $row ) {
							return number_format($d);
						}
					),
				array( 'db' => '`ventas`.`fecha`',     'dt' => 4, 'field' => 'fecha'),
				array( 'db' => '`tipo_venta`.`plazo`',
					   'dt' => 5,
					   'field' => 'plazo',
					   'formatter' => function( $d, $row ) {
						$fecha = $row[4];
						$nuevafecha = strtotime ( '+'.$d.' day' , strtotime ( $fecha ) ) ;
						$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
						$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    					$dia = $dias[date('w', strtotime($nuevafecha))];
						$num = date("j", strtotime($nuevafecha));
						$anno = date("Y", strtotime($nuevafecha));
						$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
						$mes = $mes[(date('m', strtotime($nuevafecha))*1)-1];
						return '<strong>'.$dia.', '.$num.' de '.$mes.' del '.$anno.'</strong>';
						}
					),
				array( 'db' => '`tipo_venta`.`estado`',
					   'dt' => 6, 'field' => 'estado',
					   'formatter' => function( $d, $row ) {
							if($d==0){
								return "Activo";
							}else  if($d==1){
								return "Pagado";
							}else{
								return "";
							}
						}
					),
				array(
					'db'        => '`ventas`.`anulada`',
					'dt'        => 7,
					'field' => 'anulada',
					'formatter' => function( $d, $row ) {
						if($d==0){
							return "<span class='span-id-venta' id-venta='".$row[0]."'></span><center><button class='btn btn-warning btn-xs agregar-abono' id-venta='".$row[0]."' title='agregar abono'><i class='fa fa-money'></i></button> </button><button class='btn btn-primary btn-xs emitir-factura-credito' id-venta='".$row[0]."' title='ver factura'><i class='fa fa-print'></i></button></center>";
						}else  if($d==1){
							return "<center><button class='btn btn-danger btn-xs emitir-factura-credito' id-venta='".$row[0]."' title='ver factura anulada'><i class='fa fa-print'></i></button></center>";
						}else{
							return "";
						}
					}
				)

			);

			if(!$pagado){
				$whereStatement = "`tipo_venta`.`estado` = 0 and tipo_venta.tipo_venta = 'Credito'";
			}else{
				$whereStatement = "`tipo_venta`.`estado` = 1 and tipo_venta.tipo_venta = 'Credito'";
			}
			            // Include SQL query processing class
			require('../ssp.customized.class.php');
			$joinQuery = "FROM `ventas` JOIN `tipo_venta` ON tipo_venta.VENTAS_id_venta = ventas.id_venta JOIN `usuarios` ON tipo_venta.USUARIOS_id_cliente = usuarios.id_usuario";

			            // Output data
			return SSP::simple( $request, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $whereStatement);
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
					$statement2 = $conexion->prepare("SELECT * FROM `inventario` WHERE `productos_id_producto` = :idProducto AND `id_inventario` <> 0 ORDER BY `inventario`.`precio_inventario` DESC");
					$statement2->bindValue(":idProducto", $id_producto);
					$statement2->execute();
					$resultado2 =  $statement2->fetch(PDO::FETCH_ASSOC);
					if($resultado2){
						$id_inventario = $resultado2['id_inventario'];
						$unidades = $resultado2['unidades'] + $unidades;
						$statement2 = null;
						$statement2 = $conexion->prepare("UPDATE `inventario` SET `unidades`=:unidades WHERE `id_inventario`  = :idInventario AND `id_inventario` <> 0");
						$statement2->bindValue(":unidades", $unidades);
						$statement2->bindValue(":idInventario", $id_inventario);
						$statement2->execute();
						$producto=Producto::obtenerProducto($id_producto);
						$unidades = 0;
						if(!$statement2){
							$conexion = null;
							return ERROR;
						}
						$statement2 = null;

					}else{
						$conexion = null;
						return ERROR;
					}

					$resultado = $statement->fetch(PDO::FETCH_ASSOC);
				}

				$statement = null;
				$statement = $conexion->prepare("UPDATE `ventas` SET `anulada`= 1,`fecha_anulada`=:fechaAnulada WHERE id_venta = :idVenta");
				$fechaAnulada = date('Y-m-d');
				$statement->bindValue(":fechaAnulada", $fechaAnulada);
				$statement->bindValue(":idVenta", $idVenta);
				$statement->execute();

				if($statement){ 	
					$factura = Factura::obtenerFactura($idVenta,false);
					$factura ->anularFactura();
				}else{
					$conexion = null;
					return ERROR;
				}
				$statement = null;
				$conexion = null;
				return SUCCESS;

			}else{
				$conexion = null;
				return ERROR;
			}

		}
	}


	/*$fecha = date('Y-m-d');
	$venta = new Venta($fecha);
	$venta->seleccionarProducto(1,15);
	echo "Total 1 : " . $venta->getTotal();
	echo "<br>SubTotal 1 : " . $venta->getSubtotal();
	$venta->seleccionarProducto(2,15);
	echo "<br>Total 2 : " . $venta->getTotal();
	echo "<br>SubTotal 2 : " . $venta->getSubtotal();
	echo "<br>";
	$array = $venta-> getArrayDistribucion();
	var_dump($array);
	$factura = $venta->efectuarVenta(1,64,($venta->getTotal()-$venta->getSubtotal()),$venta->getSubtotal(),0,0,"Credito",61,35);//$resolucion,$idEmpleado,$iva,$subtotal, $descuento = 0, $retefuente = 0, $tipoVenta = "Efectivo", $idCliente = 1,$plazo=Null
	echo "<br>SubtotalTotal final : " . $venta->getSubtotal();
	echo "<br>Total final : " .$venta->getTotal();*/



	?>