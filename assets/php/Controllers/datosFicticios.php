<?php 

	include '../Conexion.php';
	include '../Models/Usuario.php';
	include '../Models/Cliente.php';
	include '../Models/Empleado.php';
	include '../Models/Proveedor.php';
	try {
		$cliente=new Cliente("CC", "1017276358", "Jose Antonio", "Cra 26 # 89a-68", "Medellin", "2265874", "", $digitoDeVerificacion=NULL, "joseAntonio@gmail.com", "3116598462");
	} catch (Exception $e) {
		
	}
	try {
		$cliente=new Cliente("CC", "1001549652", "Manuela Mejia", "Cra 24 # 34-12", "Medellin", "2265874", "", $digitoDeVerificacion=NULL, "ManuRosita@gmail.com", "3135698475");
	} catch (Exception $e) {
		
	}
	try {
		$empleado=new Empleado("juan","1234","CC", "1056146298", "Juan", "La del corazon", "MEDALLO", "2248595", $clasificacion='', $digitoDeVerificacion=NULL, $email="", $celular="");
	} catch (Exception $e) {
		
	}
	try {
		$proveedor=new Proveedor("NIT", "900826318", "HOMELAB SAS", "Cra 68a # 65-96 int 214", "Medellin", "4256398", "1.-GRANDE CONTRIB", "4","homelab@gmail.com", $celular="");
	} catch (Exception $e) {
		
	}
	try {
		$proveedor=new Proveedor("NIT", "900632784", "WAM SOFTWARE", "Cra 27 # 54-20", "Medellin", "2268795", "3.-REGIMEN COMUN", "4","wamsoft@wamail.com","3113323869");
	} catch (Exception $e) {
		
	}
	
	
 ?>