<?php 
	include_once '../Conexion.php';
	include_once "../Controllers/Response.php";
	include_once 'SesionEmpleado.php';
	include_once "../Models/Usuario.php";
	include_once '../Models/Empleado.php';
	
	if(isset($_POST['user']) && isset($_POST['password'])){
		$user=$_POST['user'];
		$password=$_POST['password'];
		$empleado = new Empleado();
		if($empleado->login($user,$password)==0){
			echo ERROR;
		}else{
			echo SUCCESS;
		}
	}

 ?>