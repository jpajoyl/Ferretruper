<?php 
	include_once '../Conexion.php';
	include_once 'SesionEmpleado.php';
	include_once '../Models/Usuario.php';
	include_once '../Models/Cliente.php';
	$objectSession =new SesionEmpleado();
	$method = isset($_GET['method'])?$_GET['method']:"";
	include_once 'Response.php';	
	if($method!="" && $objectSession->getEmpleadoActual()!=null){
		if(!strcmp($method,"verClientes")){
			$listaClientes=Cliente::verClientes();
			if($listaClientes->rowCount()>0){
				while ($cliente = $listaClientes->fetch(PDO::FETCH_ASSOC)) {
					$array['data'][]=$cliente;
				}
				echo json_encode($array);
			}else{
				echo NOT_FOUND;
			}
		}else if(!strcmp($method,"registrarCliente")){
			$id=$_POST['id'];
			$digitoDeVerificacion=$_POST['digitoDeVerificacion'];
			$nombre=$_POST['nombre'];
			$direccion=$_POST['direccion'];
			$ciudad=$_POST['ciudad'];
			$email=$_POST['email'];
			$telefono=$_POST['telefono'];
			$celular=$_POST['celular'];
			$clasificacion=$_POST['clasificacion'];

			if(Cliente::obtenerCliente($id)==false){
				try{
					$cliente = new Cliente("CC", $id, $nombre, $direccion, $ciudad, $telefono, $clasificacion, $digitoDeVerificacion, $email, $celular);
					echo SUCCESS;
				}catch(Exception $e){
					echo ERROR;
				}
			}else{
				echo ALREADY_EXIST;
			}
			
		}else if(!strcmp($method,"editarCliente")){
			$id=$_POST['id'];
			$digitoDeVerificacion=$_POST['digitoDeVerificacion'];
			$nombre=$_POST['nombre'];
			$direccion=$_POST['direccion'];
			$ciudad=$_POST['ciudad'];
			$email=$_POST['email'];
			$telefono=$_POST['telefono'];
			$celular=$_POST['celular'];
			$clasificacion=$_POST['clasificacion'];

			$cliente=Cliente::obtenerCliente($id);
			if($cliente!=false){
				$id_usuario=$cliente->getIdUsuario();
				$cliente->actualizarUsuario($id_usuario, $nombre, $direccion, $ciudad, $telefono, $clasificacion, $digitoDeVerificacion, $email, $celular);
				if($cliente){
					echo SUCCESS;
				}else{
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
			
		}else if(!strcmp($method,"desactivarCliente")){
			$id=$_POST['id'];
			$cliente=Cliente::obtenerCliente($id);
			if($cliente!=false){
				$cliente->desactivarUsuario();
				if($cliente){
					echo SUCCESS;
				}else{
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
		}

	}

 ?>