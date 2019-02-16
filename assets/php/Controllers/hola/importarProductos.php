<?php 

/*ini_set('max_execution_time', 300);
	require 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
	$mysqli= new mysqli("localhost", "root", "", "ferretruperbd2");
	if (mysqli_connect_errno()) {
		echo "conexion fallida : ", mysql_connect_error();
		exit();
	}
	$nombreArchivo = "INVENTARIO2018.xlsx";
	$ocjPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
	$ocjPHPExcel->setActiveSheetIndex(0);
	$numRows=$ocjPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	for ($i=1; $i <=$numRows ; $i++) { 
		$codigo = $ocjPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$nombre = utf8_decode($ocjPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
		$marca = utf8_decode($ocjPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
		$cantidad = $ocjPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$costo = $ocjPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		$precioVenta = $ocjPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		$utilidad = $ocjPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
		$sql = "INSERT INTO `productos` (`id_producto`, `codigo_barras`, `nombre`, `descripcion`, `referencia_fabrica`, `tiene_iva`, `clasificacion_tributaria`, `unidades_totales`, `precio_mayor_inventario`, `activa`) VALUES ($codigo, NULL, '$nombre', '', '$marca', '1', 'GRAVADO', '$cantidad', '$precioVenta', '1')";
		$sql2 = "INSERT INTO `inventario` (`id_inventario`, `precio_inventario`, `precio_compra`, `unidades`, `unidades_defectuosas`, `valor_utilidad`, `productos_id_producto`, `usuarios_id_usuario`) VALUES (NULL, '$precioVenta', '$costo', '$cantidad', '0', '$utilidad', '$codigo', '682')";
		$result = $mysqli->query($sql);
		$result2 = $mysqli->query($sql2);
	}*/
	ini_set('max_execution_time', 300);
		require 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
		$mysqli= new mysqli("localhost", "root", "", "ferretruperbd2");
		if (mysqli_connect_errno()) {
			echo "conexion fallida : ", mysql_connect_error();
			exit();
		}
		$nombreArchivo = "INVENTARIO2018.xlsx";
		$ocjPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
		$ocjPHPExcel->setActiveSheetIndex(0);
		$numRows=$ocjPHPExcel->setActiveSheetIndex(0)->getHighestRow();
		for ($i=1; $i <=2000 ; $i++) { 
			$codigo = $i+10000;
			$nombre = "ensayo".strval($i);
			$marca = "marca".strval($i);
			$cantidad = 20;
			$costo = 20000;
			$precioVenta = 25000;
			$utilidad = 25;
			$sql = "INSERT INTO `productos` (`id_producto`, `codigo_barras`, `nombre`, `descripcion`, `referencia_fabrica`, `tiene_iva`, `clasificacion_tributaria`, `unidades_totales`, `precio_mayor_inventario`, `activa`) VALUES ($codigo, NULL, '$nombre', '', '$marca', '1', 'GRAVADO', '$cantidad', '$precioVenta', '1')";
			$sql2 = "INSERT INTO `inventario` (`id_inventario`, `precio_inventario`, `precio_compra`, `unidades`, `unidades_defectuosas`, `valor_utilidad`, `productos_id_producto`, `usuarios_id_usuario`) VALUES (NULL, '$precioVenta', '$costo', '$cantidad', '0', '$utilidad', '$codigo', '682')";
			$result = $mysqli->query($sql);
			$result2 = $mysqli->query($sql2);
		}
 ?>