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
        $this->setIdUsuario($conexion->lastInsertId());
        $conexion = null;
        $statement=null;
    }

    /*public static function verClientes(){
    	$conexion = Conexion::conectar();
    	$statement = $conexion->prepare("SELECT * FROM `usuarios` WHERE tipo_usuario = 'cliente' and activa = 1");

    	$statement->execute();
        $conexion=null;
        return $statement;
    	
    }*/

    public static function verClientes($request){
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
                                return "<center><button class='btn btn-primary btn-xs editar-cliente'><i class='fa fa-pencil'></i></button>
                                </button><button class='btn btn-danger btn-xs eliminar-cliente'><i class='fa fa-trash-o'></i></button></center>";
                                }else{
                                    return "";
                                }
                        }
                    ),
                    array( 'db' => 'celular',     'dt' => 9, 'field' => 'celular'),
                    array( 'db' => 'clasificacion',     'dt' => 10, 'field' => 'clasificacion')


                );
            $whereStatement = 'tipo_usuario= "cliente"';
            
            // Include SQL query processing class
            require('../ssp.customized.class.php');
            $joinQuery = NULL;

            // Output data
            return SSP::simple( $request, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $whereStatement);

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