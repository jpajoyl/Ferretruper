<?php 

	include_once '../Conexion.php';
	include_once 'SesionEmpleado.php';
	include_once "../Models/Usuario.php";
	include_once '../Models/Empleado.php';

	$empleado = new Empleado();
	$empleado->logout();
	header('Location: ../../../pages/login.php');


 ?>