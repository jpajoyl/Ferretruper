<?php 
	$objectSession = new SesionEmpleado();
	$paginaActual=basename($_SERVER['PHP_SELF'])=="login.php";  
	if (isset($_SESSION['empleado'])) {
		if($paginaActual){
			header('Location: index.php');
		}
		$empleado=Empleado::obtenerEmpleado($objectSession->getEmpleadoActual());
	}else{
		if(!$paginaActual){
			header('Location: login.php');
		}
	}


 ?>