<?php 

	/**
	 * 
	 */

	class SesionEmpleado {
		
		public function __construct(){
			session_start();
		}

		public function setEmpleadoActual($numero_identificacion){
			$_SESSION['empleado'] = $numero_identificacion;
		}

		public function getEmpleadoActual(){
			return $_SESSION['empleado'];
		}

		public function cerrarSesion(){
			session_unset();
			session_destroy();
		}

	}




 ?>