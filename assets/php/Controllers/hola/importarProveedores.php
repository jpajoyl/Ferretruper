<?php 
/*
ini_set('max_execution_time', 300);
	require 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
	$mysqli= new mysqli("localhost", "root", "", "ferretruperbd2");
	if (mysqli_connect_errno()) {
		echo "conexion fallida : ", mysql_connect_error();
		exit();
	}
	$nombreArchivo = "PROVEEDORES.xlsx";
	$ocjPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
	$ocjPHPExcel->setActiveSheetIndex(0);
	$numRows=$ocjPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	for ($i=1; $i <=$numRows ; $i++) { 
		$numeroIdentificacion = $ocjPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$dVerificacion = $ocjPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$nombre = utf8_decode($ocjPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
		$numeroIdentificacion = $ocjPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$direccion = utf8_decode($ocjPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
		$ciudad = utf8_decode($ocjPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue());
		$telefono = $ocjPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		$telefono2 = $ocjPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
		$clasificacion = utf8_decode($ocjPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue());

		$sql = "INSERT INTO `usuarios` (`id_usuario`, `tipo_usuario`, `tipo_identificacion`, `numero_identificacion`, `digito_de_verificacion`, `nombre`, `direccion`, `email`, `ciudad`, `celular`, `telefono`, `activa`, `clasificacion`) VALUES (NULL, 'proveedor', 'NIT', '$numeroIdentificacion', '$dVerificacion', '$nombre', '$direccion', NULL, '$ciudad', $telefono2, '$telefono', '1', '$clasificacion')";
		$result = $mysqli->query($sql);
	}
*/
 ?>