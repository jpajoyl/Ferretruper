<?php

/**
 * 
 */
class Cliente extends Usuario {

    public function __construct(){
    	$params = func_get_args();
    	$num_params = func_num_args();
    	if($num_params>0){
    		call_user_func_array(array($this,"__construct0"),$params);
    	}
    }

    public function __construct0($tipoDeIdentificacion, $numeroDeIdentificacion, $nombre, $direccion, $ciudad, $telefono, $clasificacion, $digitoDeVerificacion=NULL, $email="", $celular=""){
    	$conexion = Conexion::conectar();
    	$statement = $conexion->prepare("INSERT INTO `usuarios` (`id_usuario`, `tipo_usuario`, `tipo_identificacion`, `numero_identificacion`, `digito_de_verificacion`, `nombre`, `direccion`, `email`, `ciudad`, `celular`, `telefono`, `activa`, `clasificacion`) VALUES (NULL, 'cliente', :tipoDeIdentificacion, :numeroDeIdentificacion, :digitoDeVerificacion, :nombre, :direccion, :email, :ciudad, :celular, :telefono, '1', :clasificacion)");
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

    public static function verClientes(){
    	$conexion = Conexion::conectar();
    	$statement = $conexion->prepare("SELECT * FROM `usuarios` WHERE tipo_usuario = 'cliente' and activa = 1");

    	$statement->execute();
        $conexion=null;
        return $statement;
    	
    }
        
    public static function obtenerCliente($numeroConsulta,$modo=true) {
        $resultado = Usuario::buscarDatosUsuario($numeroConsulta,$modo);
        if ($resultado['tipo_usuario']=='cliente' and $resultado['activa']=='1') {
            if($resultado!=false){
                $cliente = new Cliente();
                $cliente->setIdUsuario($resultado['id_usuario']);
                $cliente->setDigitoDeVerificacion($resultado['digito_de_verificacion']);
                $cliente->setTipoDeIdentificacion($resultado['tipo_identificacion']);
                $cliente->setNumeroDeIdentificacion($resultado['numero_identificacion']);
                $cliente->setNombre($resultado['nombre']);
                $cliente->setDireccion($resultado['direccion']);
                $cliente->setCiudad($resultado['ciudad']);
                $cliente->setEmail($resultado['email']);
                $cliente->setCelular($resultado['celular']);
                $cliente->setTelefono($resultado['telefono']);
                $cliente->setClasificacion($resultado['clasificacion']);
                $conexion=null;
                $statement=null;
                return $cliente;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}


?>