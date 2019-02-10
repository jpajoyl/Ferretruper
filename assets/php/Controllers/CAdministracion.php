<?php 
	if(!isset($include)){
		include_once '../Conexion.php';
		include_once 'SesionEmpleado.php';
		include_once '../Models/Usuario.php';
		include_once '../Models/Empleado.php';

		$objectSession =new SesionEmpleado();
		$method = isset($_GET['method'])?$_GET['method']:"";
		date_default_timezone_set("America/Bogota");
	}
	include_once 'Response.php';	
	if($method!="" && $objectSession->getEmpleadoActual()!=null){
		if(!strcmp($method,"comprobarAdministrador")){
			$usuario=$_POST['usuario'];
			$password=$_POST['password'];
			$empleado = new Empleado();
			echo $empleado->verificarCredenciales($usuario,$password);
		}
	}
 ?>