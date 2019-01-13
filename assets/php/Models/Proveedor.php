<?php 
	/**
	 * 
	 */
	class Proveedor extends Usuario {

		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($tipoDeIdentificacion, $numeroDeIdentificacion, $nombre, $direccion, $ciudad, $telefono, $clasificacion, $digitoDeVerificacion=NULL, $email="", $celular=""){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `usuarios` (`id_usuario`, `tipo_usuario`, `tipo_identificacion`, `numero_identificacion`, `digito_de_verificacion`, `nombre`, `direccion`, `email`, `ciudad`, `celular`, `telefono`, `activa`, `clasificacion`) VALUES (NULL, 'proveedor', :tipoDeIdentificacion, :numeroDeIdentificacion, :digitoDeVerificacion, :nombre, :direccion, :email, :ciudad, :celular, :telefono, '1', :clasificacion)");
			$this->setNumeroDeIdentificacion($numeroDeIdentificacion,$statement);
			$this->setTipoDeIdentificacion($tipoDeIdentificacion,$statement);
			$this->setDigitoDeVerificacion($digitoDeVerificacion,$statement);
			$this->setNombre($nombre,$statement);
			$this->setDireccion($direccion,$statement);
			$this->setCiudad($ciudad,$statement);
			$this->setEmail($email,$statement);
			$this->setCelular($celular,$statement);
			$this->setTelefono($telefono,$statement);
			$this->setClasificacion($clasificacion,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$conexion = null;
        	$statement=null;
		}


		public static function verProveedores(){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `usuarios` WHERE tipo_usuario = 'proveedor' and activa = 1");

			$statement->execute();
			return $statement;
			$conexion=null;
			$statement=null;
		}

		public static function obtenerProveedor($numeroConsulta,$modo=true) {
			$resultado = Usuario::buscarDatosUsuario($numeroConsulta,$modo);
			if ($resultado['tipo_usuario']=='proveedor' and $resultado['activa']=='1') {
				if($resultado!=false){
					$proveedor = new Proveedor();
					$proveedor->setIdUsuario($resultado['id_usuario']);
					$proveedor->setDigitoDeVerificacion($resultado['digito_de_verificacion']);
					$proveedor->setTipoDeIdentificacion($resultado['tipo_identificacion']);
					$proveedor->setNumeroDeIdentificacion($resultado['numero_identificacion']);
					$proveedor->setNombre($resultado['nombre']);
					$proveedor->setDireccion($resultado['direccion']);
					$proveedor->setCiudad($resultado['ciudad']);
					$proveedor->setEmail($resultado['email']);
					$proveedor->setCelular($resultado['celular']);
					$proveedor->setTelefono($resultado['telefono']);
					$proveedor->setClasificacion($resultado['clasificacion']);
					$conexion=null;
					$statement=null;
					return $proveedor;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		public function verProductoPorProveedor(){
			$idProveedor=$this->getIdUsuario();
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM productos INNER JOIN productoxproveedor ON productoxproveedor.productos_id_producto = productos.id_producto WHERE productoxproveedor.usuarios_id_usuario = :idProveedor");
			$statement->bindParam(':idProveedor',$idProveedor,PDO::PARAM_INT);
			$statement->execute();
			$conexion=null;
			return $statement;
		}

		public function añadirProductoxproveedor($idProducto){

			$idProveedor = $this->getIdUsuario();
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `productoxproveedor` (`idProductoxproveedor`, `usuarios_id_usuario`, `productos_id_producto`) VALUES (NULL, :idProveedor, :idProducto)");
			$statement->bindParam(':idProveedor',$idProveedor,PDO::PARAM_INT);
			$statement->bindParam(':idProducto',$idProducto,PDO::PARAM_INT);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$conexion = null;
			$statement = null;
		}


	}



	?>