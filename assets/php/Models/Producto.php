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
		private $valorUtilidad;//es un porcentaje
		private $activa;


		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($idProducto, $nombre, $descripcion, $referenciaFabrica, $tieneIva, $clasificacionTributaria, $valorUtilidad, $activa, $codigoBarras = NULL){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `productos` (`id_producto`, `codigo_barras`, `nombre`, `descripcion`, `referencia_fabrica`, `tiene_iva`, `clasificacion_tributaria`, `valor_utilidad`, `activa`) VALUES (:idProducto, :codigoBarras, :nombre, :descripcion, :referenciaFabrica, :tieneIva, :clasificacionTributaria, :valorUtilidad, :activa)");

			$this->setIdProducto($idProducto,$statement);
			$this->setCodigoBarras($codigoBarras,$statement);
			$this->setNombre($nombre,$statement);
			$this->setDescripcion($descripcion,$statement);
			$this->setReferenciaFabrica($referenciaFabrica,$statement);
			$this->setTieneIva($tieneIva,$statement);
			$this->setClasificacionTributaria($clasificacionTributaria,$statement);
			$this->setValorUtilidad($valorUtilidad,$statement);
			$this->setActiva($activa,$statement);
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

		public function getValorUtilidad(){
			return $this->valorUtilidad;
		}

		public function setValorUtilidad($valorUtilidad, $statement=NULL){
			if($statement!=NULL){
				$statement->bindParam(':valorUtilidad',$valorUtilidad,PDO::PARAM_INT);
			}
			$this->valorUtilidad = $valorUtilidad;
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
		//metodos

		//retorna un statement con todos los datos del inventario
		public static function verProductos(){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `productos`");
			$statement->execute();
			$conexion=null;
			return $statement;
		}

		public static function obtenerProducto($idProducto){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `productos` WHERE  `idProducto` = :idProducto");
			$statement->bindValue(":idProducto", $idProducto);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado!=false){
				$producto = new Producto();
				$producto->setIdProducto($resultado['id_producto']);
				$producto->setCodigoBarras($resultado['codigo_barras']);
				$producto->setNombre($resultado['nombre']);
				$producto->setDescripcion($resultado['descripcion']);
				$producto->setReferenciaFabrica($resultado['referencia_fabrica']);
				$producto->setTieneIva($resultado['tiene_iva']);
				$producto->setClasificacionTributaria($resultado['clasificacion_tributaria']);
				$producto->setValorUtilidad($resultado['valor_utilidad']);
				$producto->setActiva($resultado['activa']);
				$conexion=null;
				$statement=null;
				return $producto;
			}else{
				return false;
			}

		}






	}

	?>