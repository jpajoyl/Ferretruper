<?php 

if(!isset($include)){
	include_once '../Conexion.php';
	include_once 'SesionEmpleado.php';
	include_once '../Models/Inventario.php';
	include_once '../Models/Venta.php';
	include_once '../Models/TipoVenta.php';
	include_once '../Models/Abono.php';

	$objectSession =new SesionEmpleado();
	$method = isset($_GET['method'])?$_GET['method']:"";
	date_default_timezone_set("America/Bogota");
}
include_once 'Response.php';	
if($method!="" && $objectSession->getEmpleadoActual()!=null){
	if(!strcmp($method,"verCreditos")){
		$activos=$_GET['activos'];
		$creditos=Venta::verCreditos($activos);
		if($creditos->rowCount()>0){
			while ($credito = $creditos->fetch(PDO::FETCH_ASSOC)) {
				$array['creditos'][]=$credito;
			}
			echo json_encode($array);
		}else{
			echo NOT_FOUND;
		}
	}else if(!strcmp($method,"verAbonosCredito")){
		$idTipoVenta=$_POST['idTipoVenta'];
		$abonos=Abono::obtenerAbonos($idTipoVenta);
		if($abonos->rowCount()>0){
			while ($abono = $abonos->fetch(PDO::FETCH_ASSOC)) {
				$array['abonos'][]=$abono;
			}
			echo json_encode($array);
		}else{
			echo NOT_FOUND;
		}
	}
}

?>