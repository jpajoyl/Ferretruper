<?php

/**
 * 
 */
class Empleado extends Usuario {
    private $usuario;
    private $password;
    public function __construct(){
        $params = func_get_args();
        $num_params = func_num_args();
        if($num_params>0){
            call_user_func_array(array($this,"__construct0"),$params);
        }
    }

    public function __construct0($usuario,$password,$tipoDeIdentificacion, $numeroDeIdentificacion, $nombre, $direccion, $ciudad, $telefono, $clasificacion='', $digitoDeVerificacion=NULL, $email="", $celular=""){
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
        
        $statement = $conexion->prepare("INSERT INTO `credenciales_de_acceso`(`id_credencial`, `usuario`, `password`, `USUARIOS_id_usuario`) VALUES (NULL,:usuario,:password,:id_usuario)");
        $this->setUsuario($usuario,$statement);
        $this->setPassword($password,$statement);
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

    public static function obtenerEmpleado($numeroConsulta,$modo=true) {
        try {

            $conexion = Conexion::conectar();
            $resultado = Usuario::buscarDatosUsuario($numeroConsulta,$modo);
            $consulta2= $conexion->prepare("SELECT usuario FROM `credenciales_de_acceso` WHERE USUARIOS_id_usuario=:id_usuario");
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
}

?>