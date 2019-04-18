<?php 
if(!isset($include)){
	include_once '../Conexion.php';
	include_once 'SesionEmpleado.php';
	include_once '../Models/Inventario.php';
	include_once '../Models/Usuario.php';
	include_once '../Models/Cliente.php';
	include_once '../Models/Proveedor.php';
	include_once '../Models/Producto.php';
	include_once '../Models/Factura.php';
	include_once '../Models/Venta.php';
	include_once '../Models/ProductoXVenta.php';
	include_once '../Models/TipoVenta.php';
	include_once '../Models/Abono.php';

	$objectSession =new SesionEmpleado();
	$method = isset($_GET['method'])?$_GET['method']:"";
	date_default_timezone_set("America/Bogota");
}
include_once 'Response.php';
if($method!="" && $objectSession->getEmpleadoActual()!=null){
	if(!strcmp($method,"obtenerInfoFacturaCarta")){
		$statementCarta=Factura::obtenerInfoFactura("1");
		if($statementCarta->rowCount()>0){
			while ($infoCarta = $statementCarta->fetch(PDO::FETCH_ASSOC)) {
				$array['informacion'][]=$infoCarta;
			}
			echo json_encode($array);
		}else{
			echo NOT_FOUND;
		}
	}else if(!strcmp($method,"obtenerInfoFacturaPos")){
		$statementPos=Factura::obtenerInfoFactura("2");
		if($statementPos->rowCount()>0){
			while ($infoPos = $statementPos->fetch(PDO::FETCH_ASSOC)) {
				$array['informacion'][]=$infoPos;
			}
			echo json_encode($array);
		}else{
			echo NOT_FOUND;
		}
	}else if(!strcmp($method,"editarFacturaPos")){
		$numeroDian=$_POST['numeroDianPos'];
		$RDescripcion=$_POST['RDescripcionPos'];
		$IDescripcion=$_POST['IDescripcionPos'];
		$val=Factura::editarInfoFactura(2, $numeroDian, $IDescripcion, $RDescripcion);
		echo $val;
	}else if(!strcmp($method,"editarFacturaCarta")){
		$numeroDian=$_POST['numeroDianCarta'];
		$RDescripcion=$_POST['RDescripcionCarta'];
		$IDescripcion=$_POST['IDescripcionCarta'];
		$val=Factura::editarInfoFactura(1, $numeroDian, $IDescripcion, $RDescripcion);
		echo $val;
	}
}
?>