<?php

/**
 * 
 */
class Empleado extends Usuario {
    private $usuario;
    private $password;
    private $permiso;
    public function __construct(){
        $params = func_get_args();
        $num_params = func_num_args();
        if($num_params>0){
            call_user_func_array(array($this,"__construct0"),$params);
        }
    }

    public function __construct0($usuario,$password,$permiso,$tipoDeIdentificacion, $numeroDeIdentificacion, $nombre, $direccion, $ciudad, $telefono, $clasificacion='', $digitoDeVerificacion=NULL, $email="", $celular=""){
        $conexion = Conexion::conectar();
        $statement = $conexion->prepare("INSERT INTO `usuarios` (`id_usuario`, `tipo_usuario`, `tipo_identificacion`, `numero_identificacion`, `digito_de_verificacion`, `nombre`, `direccion`, `email`, `ciudad`, `celular`, `telefono`, `activa`, `clasificacion`) VALUES (NULL, 'empleado', :tipoDeIdentificacion, :numeroDeIdentificacion, :digitoDeVerificacion, :nombre, :direccion, :email, :ciudad, :celular, :telefono, '1', :clasificacion)");
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
        
        $this->setIdUsuario($conexion->lastInsertId());
        if(!$statement){
            throw new Exception("Error Processing Request", 1);
        }

        $statement = null;
        $resultado = Usuario::buscarDatosUsuario($numeroDeIdentificacion);
        $id_usuario= $resultado['id_usuario'];
        
        $statement = $conexion->prepare("INSERT INTO `credenciales_de_acceso`(`id_credencial`, `USUARIOS_id_usuario`, `usuario`, `password`, `permiso`) VALUES (NULL,:id_usuario,:usuario,:password,:permiso)");
        $this->setUsuario($usuario,$statement);
        $this->setPassword($password,$statement);
        $this->setPermiso($permiso,$statement);
        $statement->bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
        $statement->execute();
        
        if(!$statement){
            $deleteStatement = $conexion->prepare("DELETE FROM `usuarios` WHERE `id_usuario` = :id_usuario");
            $deleteStatement->bindParam(":id_usuario",$id_usuario);
            $deleteStatement.execute();
            throw new Exception("Error Processing Request", 1);
        }
    }



    //get & set


    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario, $statement=NULL) {
    	if($statement!=NULL){
    		$statement->bindParam(':usuario',$usuario,PDO::PARAM_STR,45);
    	}
    	$this->usuario = $usuario;
    	return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password, $statement=NULL) {
    	if($statement!=NULL){
    		$statement->bindParam(':password',$password,PDO::PARAM_STR,45);
    	}
    	$this->password = $password;
    	return $this;
    }

    public function getPermiso() {
        return $this->permiso;
    }

    public function setPermiso($permiso, $statement=NULL) {
        if($statement!=NULL){
            $statement->bindParam(':permiso',$permiso,PDO::PARAM_STR,45);
        }
        $this->permiso = $permiso;
        return $this;
    }

    public function login($usuario, $password) {
        //Mirar si esta activo

        try {
            $conexion = Conexion::conectar();
            $statement = $conexion->prepare('SELECT * FROM `credenciales_de_acceso` WHERE usuario=:usuario AND password=:password');
            $statement->execute(['usuario' => $usuario, 'password' => $password]);
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            $idUsuario = $resultado['USUARIOS_id_usuario'];
            $consulta = $conexion->prepare("SELECT numero_identificacion FROM usuarios WHERE id_usuario = :id_usuario");
            $consulta->execute(['id_usuario' => $idUsuario]);
            $resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
            $numero_identificacion = $resultado2['numero_identificacion'];
            if ($statement->rowCount()) {
                $SesionEmpleado = new SesionEmpleado();
                $SesionEmpleado->setEmpleadoActual($numero_identificacion);
                $conexion = null;
                $statement = null;
                return SUCCESS;
            } else {
            	$conexion = null;
            	$statement = null;
                return ERROR;
            }
        } catch (Exception $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    public function logout() {
        $empleado = new SesionEmpleado();
        $empleado->cerrarSesion();
    }

    public function verificarCredenciales($usuario,$password){
        $conexion = Conexion::conectar();
        $statement = $conexion->prepare('SELECT * FROM `credenciales_de_acceso` WHERE usuario=:usuario AND password=:password');
        $statement->execute(['usuario' => $usuario, 'password' => $password]);
        if($statement->rowCount()>0){
            $credenciales=$statement->fetch(PDO::FETCH_ASSOC);
            if($credenciales['permiso']==1){
                $conexion=null;
                return SUCCESS;
            }else{
                $conexion=null;
                return ERROR;
            }
        }else{
            $conexion=null;
            return NOT_FOUND;
        }

    }

    public static function obtenerEmpleado($numeroConsulta,$modo=true) {
        try {

            $conexion = Conexion::conectar();
            $resultado = Usuario::buscarDatosUsuario($numeroConsulta,$modo);
            $consulta2= $conexion->prepare("SELECT * FROM `credenciales_de_acceso` WHERE USUARIOS_id_usuario=:id_usuario");
            $consulta2->execute(['id_usuario' => $resultado['id_usuario']]);
            $resultado2=$consulta2->fetch(PDO::FETCH_ASSOC);
            $empleado = new Empleado();
            if($resultado){
                $empleado = new Empleado();
                $empleado->setIdUsuario($resultado['id_usuario']);
                $empleado->setNombre($resultado['nombre']);
                $empleado->setNumeroDeIdentificacion($resultado['numero_identificacion']);
                $empleado->setTipoDeIdentificacion($resultado['tipo_identificacion']);
                $empleado->setEmail($resultado['email']);
                $empleado->setTelefono($resultado['telefono']);
                $empleado->setCelular($resultado['celular']);
                $empleado->setUsuario($resultado2['usuario']);
                $empleado->setPermiso($resultado2['permiso']);
            }
            $conexion = null;
            $consulta = null;
            $consulta2 = null;
            return $empleado;
        } catch (Exception $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    public function cambiarPassword($nuevaPassword, $viejaPassword) {
        $id_usuario=$this->getIdUsuario();
        $conexion = Conexion::conectar();
        $statement= $conexion->prepare('UPDATE `credenciales_de_acceso` SET `password`= :nuevaPassword WHERE  `USUARIOS_id_usuario`= :id_usuario AND `password` = :viejaPassword ');
        $statement->bindParam(":nuevaPassword",$nuevaPassword);
        $statement->bindParam(":id_usuario",$id_usuario);
        $statement->bindParam(":viejaPassword",$viejaPassword);
        $statement->execute();
        if($statement){
            if($statement->rowCount() > 0 ){
                return SUCCESS;
            }
            return ERROR;
        }
    }

    public static function verEmpleados($request){
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
                        'dt'        => 0
                    ),
                    array( 'db' => 'numero_identificacion', 'dt' => 0, 'field' => 'numero_identificacion'),
                    array( 'db' => 'nombre',      'dt' => 1, 'field' => 'nombre'),
                    array( 'db' => 'email',     'dt' => 2, 'field' => 'email'),
                    array( 'db' => 'Direccion',     'dt' => 3, 'field' => 'Direccion'),
                    array( 'db' => 'ciudad',     'dt' => 4, 'field' => 'ciudad'),
                    array( 'db' => 'telefono',     'dt' => 5, 'field' => 'telefono'),
                    array( 'db' => 'celular',     'dt' => 6, 'field' => 'celular'),
                    array(
                        'db'        => 'id_usuario',
                        'dt'        => 7,
                        'field' => 'id_usuario',
                        'formatter' => function( $d, $row ) {
                            if($d>0){
                                return "<center><button class='btn btn-primary btn-xs editar-empleado'><i class='fa fa-pencil'></i></button>
                                </button><button class='btn btn-danger btn-xs eliminar-empleado'><i class='fa fa-trash-o'></i></button></center>";
                                }else{
                                    return "";
                                }
                        }
                    )
                    


                );
            $whereStatement = 'tipo_usuario= "empleado" AND activa="1"';
            
            // Include SQL query processing class
            require('../ssp.customized.class.php');
            $joinQuery = NULL;

            // Output data
            return SSP::simple( $request, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $whereStatement);

    }
}

?>