<?php 

	/**
	 * 
	 */
	class Producto {
		

		//Atributos
		private $idProducto;
		private $codigoBarras;
		private $nombre;
		private $descripcion;
		private $referenciaFabrica;
		private $tieneIva;//tinyInt
		private $clasificacionTributaria;
		private $activa;
		private $unidadesTotales;
		private $precioMayorInventario;
		

		private $inventario;

		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($idProducto, $nombre, $descripcion, $referenciaFabrica, $tieneIva, $clasificacionTributaria, $activa = 1, $codigoBarras = NULL){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `productos` (`id_producto`, `codigo_barras`, `nombre`, `descripcion`, `referencia_fabrica`, `tiene_iva`, `clasificacion_tributaria`, `unidades_totales`, `precio_mayor_inventario`, `activa`) VALUES (:idProducto, :codigoBarras, :nombre, :descripcion, :referenciaFabrica, :tieneIva, :clasificacionTributaria,:unidadesTotales,:precioMayorInventario, :activa)");

			$this->setIdProducto($idProducto,$statement);
			$this->setCodigoBarras($codigoBarras,$statement);
			$this->setNombre($nombre,$statement);
			$this->setDescripcion($descripcion,$statement);
			$this->setReferenciaFabrica($referenciaFabrica,$statement);
			$this->setTieneIva($tieneIva,$statement);
			$this->setClasificacionTributaria($clasificacionTributaria,$statement);
			$this->setActiva($activa,$statement);
			$this->setUnidadesTotales(0,$statement);
			$this->setPrecioMayorInventario(0,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$this->setIdProducto($conexion->lastInsertId());
			$conexion = NULL;
			$statement = NULL;
		}

		//get & set
		public function getIdProducto(){
			return $this->idProducto;
		}

		public function setIdProducto($idProducto, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':idProducto',$idProducto,PDO::PARAM_INT);
			}
			$this->idProducto = $idProducto;
			return $this;
		}

		public function getCodigoBarras(){
			return $this->codigoBarras;
		}

		public function setCodigoBarras($codigoBarras, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':codigoBarras',$codigoBarras,PDO::PARAM_INT);
			}
			$this->codigoBarras = $codigoBarras;
			return $this;
		}

		public function getNombre(){
			return $this->nombre;
		}

		public function setNombre($nombre, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':nombre',$nombre,PDO::PARAM_STR,255);
			}
			$this->nombre = $nombre;
			return $this;
		}

		public function getDescripcion(){
			return $this->descripcion;
		}

		public function setDescripcion($descripcion, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':descripcion',$descripcion,PDO::PARAM_STR,500);
			}
			$this->descripcion = $descripcion;
			return $this;
		}

		public function getReferenciaFabrica(){
			return $this->referenciaFabrica;
		}

		public function setReferenciaFabrica($referenciaFabrica, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':referenciaFabrica',$referenciaFabrica,PDO::PARAM_STR,45);
			}
			$this->referenciaFabrica = $referenciaFabrica;
			return $this;
		}

		public function getTieneIva(){
			return $this->tieneIva;
		}

		public function setTieneIva($tieneIva, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':tieneIva',$tieneIva,PDO::PARAM_INT);
			}
			$this->tieneIva = $tieneIva;
			return $this;
		}

		public function getClasificacionTributaria(){
			return $this->clasificacionTributaria;
		}

		public function setClasificacionTributaria($clasificacionTributaria, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':clasificacionTributaria',$clasificacionTributaria,PDO::PARAM_STR,45);
			}
			$this->clasificacionTributaria = $clasificacionTributaria;
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

		public function getUnidadesTotales(){
			return $this->unidadesTotales;
		}

		public function setUnidadesTotales($unidadesTotales, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':unidadesTotales',$unidadesTotales,PDO::PARAM_INT);
			}
			$this->unidadesTotales = $unidadesTotales;
			return $this;
		}

		public function getPrecioMayorInventario(){
			return $this->precioMayorInventario;
		}

		public function setPrecioMayorInventario($precioMayorInventario, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':precioMayorInventario',$precioMayorInventario,PDO::PARAM_INT);
			}
			$this->precioMayorInventario = $precioMayorInventario;
			return $this;
		}
		//metodos

		//retorna un statement con todos los datos del inventario
		public static function verProductos($request,$modo=true){
			// Database connection info
			$dbDetails = array(
			    'host' => 'localhost',
			    'user' => 'root',
			    'pass' => '',
			    'db'   => 'ferretruperbd2'
			);

			// DB table to use
			$table = 'productos';

			// Table's primary key
			$primaryKey = 'id_producto';

			// Array of database columns which should be read and sent back to DataTables.
			// The `db` parameter represents the column name in the database. 
			// The `dt` parameter represents the DataTables column identifier.
			$columns = array(
			    array( 'db' => 'id_producto', 'dt' => 0,'field' => 'id_producto'),
			    array( 'db' => 'nombre',  'dt' => 1,'field' => 'nombre'),
			    array( 'db' => 'referencia_fabrica',      'dt' => 2,'field' => 'referencia_fabrica'),
			    array( 'db' => 'codigo_barras',     'dt' => 3,'field' => 'codigo_barras'),
			    array( 'db' => 'unidades_totales',    'dt' => 4,'field' => 'unidades_totales'),
			    array(
			        'db'        => 'precio_mayor_inventario',
			        'dt'        => 5,
			        'field' => 'precio_mayor_inventario',
			        'formatter' => function( $d, $row ) {
			            return number_format($d);
			        }
			    ),
			    array(
			        'db'        => 'unidades_totales',
			        'dt'        => 6,
			        'field' => 'unidades_totales',
			        'formatter' => function( $d, $row ) {
			            if($d>0){
			            	return "<center><button class='btn btn-success btn-xs añadir-producto'><i class='fa fa-plus-circle'></i></button></button></center>";
			            }else{
			            	return "";
			            }
			        }
			    )
			);

			// Include SQL query processing class
            require('../ssp.customized.class.php');


            // Output data
            return SSP::simple( $request, $dbDetails, $table, $primaryKey, $columns);

		}

		public static function verProductosInventario($request,$papelera=false){
			// Database connection info
			$dbDetails = array(
			    'host' => 'localhost',
			    'user' => 'root',
			    'pass' => '',
			    'db'   => 'ferretruperbd2'
			);

			// DB table to use
			$table = 'productos';

			// Table's primary key
			$primaryKey = 'id_producto';

			// Array of database columns which should be read and sent back to DataTables.
			// The `db` parameter represents the column name in the database. 
			// The `dt` parameter represents the DataTables column identifier.
			$columns = array(
			    array( 'db' => 'id_producto', 'dt' => 1,'field' => 'id_producto'),
			    array( 'db' => 'nombre',  'dt' => 2,'field' => 'nombre'),
			    array( 'db' => 'referencia_fabrica',      'dt' => 3,'field' => 'referencia_fabrica'),
			    array( 'db' => 'codigo_barras',     'dt' => 4,'field' => 'codigo_barras'),
			    array( 'db' => 'unidades_totales',    'dt' => 5,'field' => 'unidades_totales'),
			    array(
			        'db'        => 'precio_mayor_inventario',
			        'dt'        => 6,
			        'field' => 'precio_mayor_inventario',
			        'formatter' => function( $d, $row ) {
			            return number_format($d);
			        }
			    ),
			    array(
			        'db'        => 'activa',
			        'dt'        => 7,
			        'field' => 'activa',
			        'formatter' => function( $d, $row ) {
			            if($d==1){
			            	return "<center><button class='btn btn-danger btn-xs eliminar-producto'><i class='fa fa-trash-o'></i></center>";
			            }else if($d==0){
			            	return "<center><button class='btn btn-success btn-xs rehabilitar-producto'><i class='fa fa-chevron-circle-left'></i></center>";
			            }else{
			            	return "";
			            }
			        }
			    ),
			    array( 'db' => 'descripcion',    'dt' => 8,'field' => 'descripcion'),
			    array( 'db' => 'tiene_iva',    'dt' => 9,'field' => 'tiene_iva')
			);

			// Include SQL query processing class
            require('../ssp.customized.class.php');

            if(!$papelera){
	            $whereStatement = '`activa`=1';
        	}else{
	            $whereStatement = '`activa`=0';
        	}

            // Output data
            return SSP::simple( $request, $dbDetails, $table, $primaryKey, $columns,null,$whereStatement);

		}

		public function calcularUnidades(){
			$unidadesTotalesContador=0;
			$conexion = Conexion::conectar();
			$statement = Inventario::obtenerInventarios($this->getIdProducto());
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado){
				while($resultado ){
					$unidadesTotalesContador+=$resultado['unidades'];
					$resultado = $statement->fetch(PDO::FETCH_ASSOC);
				}
			}
			$cambiarUnidades=$this->cambiarUnidadesTotales($unidadesTotalesContador);
			$conexion=null;
			if($cambiarUnidades == SUCCESS){
				return $unidadesTotalesContador;
			}else{
				return ERROR;
			}
			

		}
		public function cambiarUnidadesTotales($unidadesTotales){
			$conexion = Conexion::conectar();
			$idProducto = $this->getIdProducto();
			$statement = $conexion->prepare("UPDATE `productos` SET `unidades_totales`=:unidadesTotales WHERE  `id_producto` = :idProducto");
			$statement->bindValue(":idProducto", $idProducto);
			$statement->bindValue(":unidadesTotales", $unidadesTotales);
			$statement->execute();
			if($statement){
				return SUCCESS;
			}else{
				return ERROR;
			}

			
		}

		public function obtenerPrecioMayorInventario(){
			$precioMayor=0;
			$conexion = Conexion::conectar();
			$statement = Inventario::obtenerInventarios($this->getIdProducto());
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			while($resultado){
				$precioActual=$resultado['precio_inventario'];
				if ($precioActual > $precioMayor){
					$precioMayor = $precioActual;
				}
				$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			}
			$cambiarPrecioMayorInventario=$this->cambiarPrecioMayorInventario($precioMayor);
			$conexion=null;
			if($cambiarPrecioMayorInventario == SUCCESS){
				return $precioMayor;
			}else{
				return ERROR;
			}
			


		}

		public function cambiarPrecioMayorInventario($precioMayorInventario) {
			$conexion = Conexion::conectar();
			$idProducto = $this->getIdProducto();
			$statement = $conexion->prepare("UPDATE `productos` SET `precio_mayor_inventario`=:precioMayorInventario WHERE  `id_producto` = :idProducto");
			$statement->bindValue(":idProducto", $idProducto);
			$statement->bindValue(":precioMayorInventario", $precioMayorInventario);
			$statement->execute();
			if($statement){
				return SUCCESS;
			}else{
				return ERROR;
			}
		}

		public static function obtenerProducto($idProducto,$returnStatement=false,$deshabilitado=false){
			$conexion = Conexion::conectar();
			if(!$deshabilitado){
				$statement = $conexion->prepare("SELECT * FROM `productos` WHERE  `id_producto` = :idProducto AND `activa` = 1");
			}else{
				$statement = $conexion->prepare("SELECT * FROM `productos` WHERE  `id_producto` = :idProducto AND `activa` = 0");
			}
			
			$statement->bindValue(":idProducto", $idProducto);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado!=false){
				if($returnStatement==false){
					$producto = new Producto();
					$producto->setIdProducto($resultado['id_producto']);
					$producto->setCodigoBarras($resultado['codigo_barras']);
					$producto->setNombre($resultado['nombre']);
					$producto->setDescripcion($resultado['descripcion']);
					$producto->setReferenciaFabrica($resultado['referencia_fabrica']);
					$producto->setTieneIva($resultado['tiene_iva']);
					$producto->setClasificacionTributaria($resultado['clasificacion_tributaria']);
					$producto->setActiva($resultado['activa']);
					$producto->setUnidadesTotales($producto->calcularUnidades());
					$producto->setPrecioMayorInventario($producto->obtenerPrecioMayorInventario());

					$conexion=null;
					$statement=null;
					return $producto;
				}else{
					return $resultado;
				}
				
			}else{
				return false;
			}

		}
		public function editarProducto($codigoBarras, $nombre, $descripcion, $referenciaFabrica, $tieneIva, $clasificacionTributaria){

			$idProducto=$this->getIdProducto();
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("UPDATE `productos` SET `codigo_barras` = :codigoBarras, `nombre` = :nombre, `descripcion` = :descripcion, `referencia_fabrica` = :referenciaFabrica, `tiene_iva` = :tieneIva, `clasificacion_tributaria` = :clasificacionTributaria  WHERE `productos`.`id_producto` = :idProducto");
			$statement->bindValue(":idProducto", $idProducto);
			$this->setCodigoBarras($codigoBarras,$statement);
			$this->setNombre($nombre,$statement);
			$this->setDescripcion($descripcion,$statement);
			$this->setReferenciaFabrica($referenciaFabrica,$statement);
			$this->setTieneIva($tieneIva,$statement);
			$this->setClasificacionTributaria($clasificacionTributaria,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$this->calcularUnidades();
			$this->obtenerPrecioMayorInventario();
			$conexion = NULL;
			$statement = NULL;

		}

		public function editarPrecioMayorInventarioManual($precioMayorInventario){

			$idProducto=$this->getIdProducto();
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("UPDATE `productos` SET `precio_mayor_inventario` = :precioMayorInventario  WHERE `productos`.`id_producto` = :idProducto");
			$statement->bindValue(":idProducto", $idProducto);
			$this->setPrecioMayorInventario($precioMayorInventario,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$this->calcularUnidades();
			$conexion = NULL;
			$statement = NULL;

		}

		public function desactivarProducto($modo=true){
			$conexion = Conexion::conectar();
			$idProducto=$this->getIdProducto();
			if($modo){
				$statement = $conexion->prepare("UPDATE `productos` SET `activa` = '0' WHERE `productos`.`id_producto` = :idProducto");
			}else{
				$statement = $conexion->prepare("UPDATE `productos` SET `activa` = '1' WHERE `productos`.`id_producto` = :idProducto");
			}
			$statement->bindValue(":idProducto", $idProducto);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$conexion = NULL;
			$statement = NULL;
		}

		public static function buscarPorNombre($nombre){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `productos` WHERE  `nombre` LIKE ? LIMIT 10");
			$statement->bindValue(1, "%$nombre%", PDO::PARAM_STR);
			$statement->execute();
			if($statement->rowCount()>0){
				return $statement;
			}else{
				return false;
			}
			
		}

		public function igualarPreciosInventario(){
			$conexion = Conexion::conectar();
			$statement=Inventario::obtenerInventarios($this->getIdProducto());
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			$precioMayor=$this->obtenerPrecioMayorInventario();
			while($resultado){
				$inventario=Inventario::obtenerInventario($resultado['id_inventario']);
				$result= $inventario->cambiarPrecio($precioMayor);
				if ($result == ERROR){
					return ERROR;
				}
				$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			}
			return SUCCESS;

		}

		public function agregarInventarioEmergente(){
			$conexion = Conexion::conectar();
			$idProducto=$this->getIdProducto();
			$precio = $this->getPrecioMayorInventario();
			$inventario = new Inventario($precio, $precio, 0, 0, $idProducto, 0,0);
			$conexion = null;
			if($inventario){
				return $inventario;
			}else{
				return false;
			}
		}

		public function agregarUnidadesEmergentes($unidades){
			$conexion = Conexion::conectar();
			$idProducto=$this->getIdProducto();
			$inventario = Inventario::obtenerInventario($idProducto,0);
			if(! $inventario){
				$inventario = $this->agregarInventarioEmergente();
			}
			$idInventario= $inventario->getIdInventario();
			$unidadesInventario= $inventario->getUnidades();
			$unidadesFinales= $unidades + $unidadesInventario
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("UPDATE `inventario` SET `unidades`=:unidades WHERE 1");
			$statement->bindValue(":unidades", $unidadesFinales);
			$statement->execute();
			
		}

		public static function verificarEspecial($idProducto){
			$inventario = Inventario::obtenerInventario($idProducto,0,true);
			if(! $inventario){
				return false;
			}else{
				return $inventario;
			}
		}


	}

	/*
		public static function verProductos($modo=true){
			$conexion = Conexion::conectar();
			if($modo){
				$statement = $conexion->prepare("SELECT * FROM `productos` WHERE `activa` = 1");
			}else{
				$statement = $conexion->prepare("SELECT * FROM `productos` WHERE `activa` = 0");
			}
			$statement->execute();
			$conexion=null;
			return $statement;
		}
	*/

	?>