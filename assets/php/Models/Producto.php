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
			$this->setValorUtilidad($valorUtilidad,$statement);
			$this->setActiva($activa,$statement);
			$this->setUnidadesTotales(0,$statement);
			$this->setPrecioMayorInventario(0,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
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
		public static function verProductos(){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `productos` and activa = 1");
			$statement->execute();
			$conexion=null;
			return $statement;
		}

		public function calcularUnidades(){
			$unidadesTotalesContador=0
			$conexion = Conexion::conectar();
			$statement = Inventario::obtenerInventarios($this->getIdProducto());
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			while($resultado){
				$unidadesTotalesContador+=$resultado['unidades']
				$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			}
			$cambiarUnidades=$this->cambiarUnidadesTotales($unidadesTotalesContador)
			$conexion=null;
			if($cambiarUnidadaes == SUCCESS){
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
			$PrecioMayor=0
			$conexion = Conexion::conectar();
			$statement = Inventario::obtenerInventarios($this->getIdProducto());
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			while($resultado){
				$precioActual=$resultado['unidades']
				$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			}
			$cambiarUnidades=$this->cambiarUnidadesTotales($unidadesTotalesContador)
			$conexion=null;
			if($cambiarUnidadaes == SUCCESS){
				return $unidadesTotalesContador;
			}else{
				return ERROR;
			}
			


		}
		public static function obtenerProducto($idProducto,$returnStatement=false){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `productos` WHERE  `id_producto` = :idProducto");
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
		public function editarProducto($codigoBarras, $nombre, $descripcion, $referenciaFabrica, $tieneIva, $clasificacionTributaria, $valorUtilidad){

			$idProducto=$this->getIdProducto();
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("UPDATE `productos` SET `codigo_barras` = :codigoBarras, `nombre` = :nombre, `descripcion` = :descripcion, `referencia_fabrica` = :referenciaFabrica, `tiene_iva` = :tieneIva, `clasificacion_tributaria` = :clasificacionTributaria, `unidades_totales` = :unidadesTotales  WHERE `productos`.`id_producto` = :idProducto");
			$statement->bindValue(":idProducto", $idProducto);
			$this->setCodigoBarras($codigoBarras,$statement);
			$this->setNombre($nombre,$statement);
			$this->setDescripcion($descripcion,$statement);
			$this->setReferenciaFabrica($referenciaFabrica,$statement);
			$this->setTieneIva($tieneIva,$statement);
			$this->setClasificacionTributaria($clasificacionTributaria,$statement);
			$this->setUnidadesTotales($producto->calcularUnidades());
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$conexion = NULL;
			$statement = NULL;

		}

		public function desactivarProducto(){
			$conexion = Conexion::conectar();
			$idProducto=$this->getIdProducto();
			$statement = $conexion->prepare("UPDATE `productos` SET `activa` = '0' WHERE `productos`.`id_producto` = :idProducto");
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
			$statement = $conexion->prepare("SELECT * FROM `productos` WHERE  `nombre` LIKE ?");
			$statement->bindValue(1, "%$nombre%", PDO::PARAM_STR);
			$statement->execute();
			if($statement->rowCount()>0){
				return $statement;
			}else{
				return false;
			}
			
		}


	}

	?>