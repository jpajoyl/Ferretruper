<?php 

if(!isset($include)){
	include_once '../Conexion.php';
	include_once 'SesionEmpleado.php';
	include_once '../Models/Usuario.php';
	include_once '../Models/Proveedor.php';
	$objectSession =new SesionEmpleado();
	$method = isset($_GET['method'])?$_GET['method']:"";
}







?>