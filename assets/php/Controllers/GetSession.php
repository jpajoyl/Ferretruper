<?php 
	$objectSession = new SesionEmpleado();
	$paginaActual=basename($_SERVER['PHP_SELF']);  
	if (isset($_SESSION['empleado'])) {
		if($paginaActual=="login.php"){
			header('Location: index.php');
		}
		$empleado=Empleado::obtenerEmpleado($objectSession->getEmpleadoActual());
		if($empleado->getPermiso()==0 and $paginaActual!="index.php"){
			header('Location: index.php');
		}
	}else{
		if(!$paginaActual){
			header('Location: login.php');
		}
	}


 ?>