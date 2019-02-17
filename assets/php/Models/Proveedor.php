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
			$this->setIdUsuario($conexion->lastInsertId());
			$conexion = null;
        	$statement=null;
		}


		/*public static function verProveedores(){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `usuarios` WHERE tipo_usuario = 'proveedor' and activa = 1");

			$statement->execute();
			return $statement;
			$conexion=null;
			$statement=null;
		}*/

		public static function verProveedores($request){

		            $dbDetails = array(
		                'host' => 'localhost',
		                'user' => 'root',
		                'pass' => '',
		                'db'   => 'ferretruperbd2'
		            );

		            // DB table to use
		            $table = 'usuarios';

		            // Table's primary key
		            $primaryKey = 'id_usuario';

		            // Array of database columns which should be read and sent back to DataTables.
		            // The `db` parameter represents the column name in the database. 
		            // The `dt` parameter represents the DataTables column identifier.
		            
			        $columns = array(
			     			array(
						        'db'        => 'id_usuario',
						        'dt'        => 0,
						        'field' => 'id_usuario',
						        'formatter' => function( $d, $row ) {
						        	if($d>0){
						           		return "";
						           }
						        }
						    ),
			                array( 'db' => 'numero_identificacion', 'dt' => 1, 'field' => 'numero_identificacion'),
			                array( 'db' => 'digito_de_verificacion',  'dt' => 2, 'field' => 'digito_de_verificacion'),
			                array( 'db' => 'nombre',      'dt' => 3, 'field' => 'nombre'),
			                array( 'db' => 'email',     'dt' => 4, 'field' => 'email'),
			                array( 'db' => 'Direccion',     'dt' => 5, 'field' => 'Direccion'),
			                array( 'db' => 'ciudad',     'dt' => 6, 'field' => 'ciudad'),
			                array( 'db' => 'telefono',     'dt' => 7, 'field' => 'telefono'),
							array(
						        'db'        => 'id_usuario',
						        'dt'        => 8,
						        'field' => 'id_usuario',
						        'formatter' => function( $d, $row ) {
						        	if($d>0){
						           		return "<center><button class='btn btn-primary btn-xs editar-proveedor'><i class='fa fa-pencil'></i></button>
						           		</button><button class='btn btn-danger btn-xs eliminar-proveedor'><i class='fa fa-trash-o'></i></button></center>";
						           		}else{
						           			return "";
						           		}
						        }
						    )


			            );
			        $whereStatement = 'tipo_usuario= "proveedor"';
		        	
		            // Include SQL query processing class
		            require('../ssp.customized.class.php');
		            $joinQuery = NULL;

		            // Output data
		            return SSP::simple( $request, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $whereStatement);
						// Database connection info
//:.---------------------------------------------------------------------------------------------------------------.:

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

		public static function buscarProveedorXNombreONit($valor){
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM `usuarios` WHERE  ( `nombre` LIKE :nombre OR `numero_identificacion` LIKE :nit ) and `tipo_usuario` = 'proveedor' LIMIT 10");
			$statement->bindValue(":nombre","%$valor%",PDO::PARAM_STR);
			$statement->bindValue(":nit","%$valor%",PDO::PARAM_STR);
			$statement->execute();
			if($statement->rowCount()>0){
				return $statement;
			}else{
				return false;
			}
		}

		public function verProductoPorProveedor(){
			$idProveedor=$this->getIdUsuario();
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("SELECT * FROM productos INNER JOIN inventario ON inventario.productos_id_producto = productos.id_producto WHERE inventario.usuarios_id_usuario = :idProveedor and productos.activa = 1");
			$statement->bindParam(':idProveedor',$idProveedor,PDO::PARAM_INT);
			$statement->execute();
			$conexion=null;
			return $statement;
		}


	}



	?>