<?php 
	include_once '../Conexion.php';
	include_once 'SesionEmpleado.php';
	include_once '../Models/Usuario.php';
	include_once '../Models/Cliente.php';
	include_once '../Models/Empleado.php';
	$objectSession =new SesionEmpleado();
	$method = isset($_GET['method'])?$_GET['method']:"";
	include_once 'Response.php';	
	if($method!="" && $objectSession->getEmpleadoActual()!=null){
		if(!strcmp($method,"verEmpleado")){
			echo json_encode(Empleado::verEmpleados($_GET));
		}else if(!strcmp($method,"registrarEmpleado")){
			$id=$_POST['id'];
			$tipoId="CC";
			$digitoDeVerificacion=0;
			$nombre=$_POST['nombre'];
			$direccion=$_POST['direccion'];
			$ciudad=$_POST['ciudad'];
			$email=$_POST['email'];
			$telefono=$_POST['telefono'];
			$celular=$_POST['celular'];
			$clasificacion="Empleado";
			$usuario=$_POST['usuario'];
			$contraseña=$_POST['contraseña'];

			if(Empleado::obtenerEmpleado($id)==false){
				try{
					$empleado = new Empleado($usuario,$contraseña,0,$tipoId, $id, $nombre, $direccion, $ciudad, $telefono, $clasificacion, $digitoDeVerificacion, $email, $celular);
					echo SUCCESS;
				}catch(Exception $e){
					echo ERROR;
				}
			}else{
				echo ALREADY_EXIST;
			}
			
		}else if(!strcmp($method,"editarEmpleado")){
			$id=$_POST['id'];
			$digitoDeVerificacion=0;
			$nombre=$_POST['nombre'];
			$direccion=$_POST['direccion'];
			$ciudad=$_POST['ciudad'];
			$email=$_POST['email'];
			$telefono=$_POST['telefono'];
			$celular=$_POST['celular'];
			$clasificacion="Empleado";
			$usuario=['usuario'];
			$contrasena=['contrasena'];


			$empleado=Empleado::obtenerEmpleado($id);
			if($empleado!=false){
				$id_usuario=$empleado->getIdUsuario();
				$empleado->actualizarUsuario($id_usuario, $nombre, $direccion, $ciudad, $telefono, $clasificacion, $digitoDeVerificacion, $email, $celular);
				if($empleado){
					echo SUCCESS;
				}else{
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
			
		}else if(!strcmp($method,"desactivarEmpleado")){
			$id=$_POST['id'];
			$empleado=Empleado::obtenerEmpleado($id);
			if($empleado!=false){
				$empleado->desactivarUsuario();
				if($empleado){
					echo SUCCESS;
				}else{
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
		}else if(!strcmp($method,"buscarEmpleado")){
			$id=$_POST['id'];
			$empleado=Empleado::obtenerEmpleado($id);
			if($empleado!=false){
				$response['response'] = SUCCESS;
				$response['nombre'] = $empleado->getNombre();
				echo json_encode($response);
			}else{
				echo NOT_FOUND;
			}
		}else if(!strcmp($method,"obtenerEmpleado")){
			$id=$_POST['numero_identificacion'];
			$empleado=Empleado::obtenerEmpleado($id);
			if($empleado!=false){
				$response['response'] = SUCCESS;
				$response['nombre'] = $empelado->getNombre();
				$response['direccion'] = $empleado->getDireccion();
				$response['telefono'] = $empleado->getTelefono();
				$response['celular'] = $empleado->getCelular();
				echo json_encode($response);
			}else{
				echo NOT_FOUND;
			}
		}

	}

 ?>