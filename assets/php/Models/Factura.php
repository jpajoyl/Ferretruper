<?php 
use ticket\src\Mike42\Escpos\Printer;
use ticket\src\Mike42\Escpos\EscposImage;
use ticket\src\Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
/**
 * 
 */
class Factura {
	// atributos
	private $idFactura;
	private $total;
	private $fecha;
	private $anulada;//tinyInt
	private $fechaAnulada;
	private $venta;//objeto venta
	private $informacionFactura;
	private $resolucion;
	private $numeroDian;

	public function getNumeroDian()
	{
		return $this->numeroDian;
	}
	
	public function setNumeroDian($numeroDian, $statement=NULL)
	{
		if($statement!=NULL){
			$statement->bindParam(':numeroDian',$numeroDian,PDO::PARAM_INT);
		}
		$this->numeroDian = $numeroDian;
		return $this;
	}

	public function __construct(){
		$params = func_get_args();
		$num_params = func_num_args();
		if($num_params>0){
			call_user_func_array(array($this,"__construct0"),$params);
		}
	}

	public function __construct0($total, $fecha, $informacionFactura, $venta, $resolucion, $numeroDian, $anulada=0, $fechaAnulada=NULL){
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("INSERT INTO `facturas` (`id_factura`, `total`, `fecha`, `anulada`, `fecha_anulada`, `numero_dian`, `informacion_facturas_id_informacion_facturas`, `resoluciones_id_resolucion`, `ventas_id_venta`) VALUES (NULL, :total, :fecha, :anulada, :fechaAnulada, :numeroDian, :informacionFactura, :resolucion, :venta)");

		$this->setTotal($total,$statement);
		$this->setFecha($fecha,$statement);
		$this->setAnulada($anulada,$statement);
		$this->setFechaAnulada($fechaAnulada,$statement);
		$this->setInformacionFactura($informacionFactura,$statement);
		$this->setVenta($venta,$statement);
		$this->setResolucion($resolucion,$statement);
		$this->setNumeroDian($numeroDian,$statement);
		$statement->execute();
		$this->setidFactura($conexion->lastInsertId());
		if(!$statement){
			throw new Exception("Error Processing Request", 1);
		}

		/*$consulta=$conexion->prepare("SELECT descripcion FROM `informacion_facturas` WHERE id_informacion_facturas = :informacionFactura");
		$consulta->bindParam(':informacionFactura',$informacionFactura,PDO::PARAM_INT);
		$consulta->execute();
		$resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
		$this->setInformacionFactura($resultado2['descripcion']);*/

		/*$consulta=$conexion->prepare("SELECT descripcion FROM `resoluciones` WHERE id_resolucion = :idResolucion");
		$consulta->bindParam(':idResolucion',$resolucion,PDO::PARAM_INT);
		$consulta->execute();
		$resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
		$this->setResolucion($resultado2['descripcion']);
		$consulta=null;*/
		$conexion = NULL;
		$statement = NULL;
	}

	//get & set 
	public function getidFactura(){
		return $this->idFactura;
	}

	public function setidFactura($idFactura, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':idFactura',$idFactura,PDO::PARAM_INT);
		}
		$this->idFactura = $idFactura;
		return $this;
	}

	public function getTotal(){
		return $this->total;
	}

	public function setTotal($total, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':total',$total,PDO::PARAM_INT);
		}
		$this->total = $total;
		return $this;
	}

	public function getFecha(){
		return $this->fecha;
	}

	public function setFecha($fecha, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':fecha',$fecha,PDO::PARAM_STR,45);
		}
		$this->fecha = $fecha;
		return $this;
	}

	public function getAnulada(){
		return $this->anulada;
	}

	public function setAnulada($anulada, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':anulada',$anulada,PDO::PARAM_INT);
		}
		$this->anulada = $anulada;
		return $this;
	}

	public function getFechaAnulada(){
		return $this->fechaAnulada;
	}

	public function setFechaAnulada($fechaAnulada, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':fechaAnulada',$fechaAnulada,PDO::PARAM_STR,45);
		}
		$this->fechaAnulada = $fechaAnulada;
		return $this;
	}

	public function getVenta(){
		return $this->venta;
	}

	public function setVenta($venta, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':venta',$venta,PDO::PARAM_INT);
		}
		$this->venta = $venta;
		return $this;
	}

	public function getInformacionFactura(){
		return $this->informacionFactura;
	}

	public function setInformacionFactura($informacionFactura, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':informacionFactura',$informacionFactura,PDO::PARAM_STR,500);
		}
		$this->informacionFactura = $informacionFactura;
		return $this;
	}
	public function getResolucion()
	{
		return $this->resolucion;
	}
	
	public function setResolucion($resolucion, $statement=NULL)
	{
		if($statement!=NULL){
			$statement->bindParam(':resolucion',$resolucion,PDO::PARAM_INT);
		}
		$this->resolucion = $resolucion;
		return $this;
	}

	public static function obtenerFactura($numeroDeConsulta, $modo=true){
		//idFactura->True, idVenta->False
		$conexion = Conexion::conectar();
		if ($modo) {
			$statement = $conexion->prepare("SELECT * FROM `facturas` WHERE  `id_factura` = :numeroDeConsulta");
		}else{
			$statement = $conexion->prepare("SELECT * FROM `facturas` WHERE  `ventas_id_venta` = :numeroDeConsulta");
		}
		
		$statement->bindValue(":numeroDeConsulta", $numeroDeConsulta);
		$statement->execute();
		$resultado = $statement->fetch(PDO::FETCH_ASSOC);
		if($resultado!=false){
			$factura = new Factura();
			$factura->setidFactura($resultado['id_factura']);
			$factura->setTotal($resultado['total']);
			$factura->setFecha($resultado['fecha']);
			$factura->setAnulada($resultado['anulada']);
			$factura->setFechaAnulada($resultado['fecha_anulada']);
			$factura->setResolucion($resultado['resoluciones_id_resolucion']);
			$factura->setNumeroDian($resultado['numero_dian']);
			$factura->setVenta($resultado['ventas_id_venta']);
			$factura->setInformacionFactura($resultado['informacion_facturas_id_informacion_facturas']);
			$idResolucion = $resultado['resoluciones_id_resolucion'];
			



			$idInformacionFacturas = $resultado['informacion_facturas_id_informacion_facturas'];

			$consulta=null;
			$conexion=null;
			$statement=null;
			return $factura;
		}else{
			$conexion=null;
			$statement=null;
			return false;
		}
	}

	public function anularFactura(){
		$fechaAnulada = date('Y-m-d');
		$idFactura=$this->getidFactura();
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("UPDATE `facturas` SET `anulada` = '1' , `fecha_anulada` = :fechaAnulada WHERE `facturas`.`id_factura` = :idFactura");
		$statement->bindParam(':idFactura',$idFactura,PDO::PARAM_INT);
		$statement->bindValue(":fechaAnulada", $fechaAnulada);
		$statement->execute();
		$this->setAnulada(1);
		$conexion=null;
		$statement=null;
	}


	public static function obtenerInfoFactura($tipo){
		//carta es el id 1!!!!
		//pos es el id 2!!!!
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("SELECT * FROM informacion_facturas, resoluciones WHERE informacion_facturas.id_informacion_facturas = $tipo and resoluciones.id_resolucion = $tipo");
		$statement->execute();
		$conexion=null;
		return $statement;
	}

	public static function editarInfoFactura($tipo, $numeroDian, $IDescripcion, $RDescripcion)
	{
		$conexion = Conexion::conectar();
		$statement1 = $conexion->prepare("UPDATE `informacion_facturas` SET `i_descripcion` = :IDescripcion WHERE `informacion_facturas`.`id_informacion_facturas` = :tipo");
		$statement1->bindParam(':IDescripcion',$IDescripcion,PDO::PARAM_STR,500);
		$statement1->bindParam(':tipo',$tipo,PDO::PARAM_INT);
		$statement1->execute();
		$statement2 = $conexion->prepare("UPDATE `resoluciones` SET `r_descripcion` = :RDescripcion, `numero_dian` = :numeroDian WHERE `resoluciones`.`id_resolucion` = :tipo");
		$statement2->bindParam(':RDescripcion',$RDescripcion,PDO::PARAM_STR,500);
		$statement2->bindParam(':tipo',$tipo,PDO::PARAM_INT);
		$statement2->bindParam(':numeroDian',$numeroDian,PDO::PARAM_INT);
		$statement2->execute();
		if ($statement1 and $statement2) {
			return true;
		}else{
			return false;
		}
	}


	public function imprimirFacturaCarta($media=false){
		$conexion = Conexion::conectar();
		//EL FORMATO MEDIA CARTA ES PARA 3 ARTICULOS O MENOS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		include_once '../Controllers/CifrasEnLetras.php';
		require('../fpdf/fpdf.php');
		ob_start ();
		if ($media) {
			$pdf=new FPDF('P','mm',array(210 ,297));
		}else{
			$pdf=new FPDF('P','mm',array(210 ,297));  //crea el objeto
		}
		$pdf->AddPage();  //añadimos una página. Origen coordenadas, esquina superior izquierda, posición por defeto a 1 cm de los bordes.
		$pdf->SetFillColor(215, 205, 203);
		$pdf->Image('../../images/LOGO FERRETRUPER.jpg' , 7 , 7 , 40 , 10,'JPG');
		if ($this->getAnulada()==1) {
			$pdf->Image('../../images/anulado.png' , 25 , 50 , 160 , 160,'PNG');
		}
		$numeroDian = $this->getNumeroDian();
		if ($media) {
			$archivo="FacturaMediaCarta-$numeroDian.pdf";
		}else{
			$archivo="FacturaCarta-$numeroDian.pdf";
		}
		$archivo_de_salida=$archivo;
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(115,5,utf8_decode('FERRETRUPER S.A.S'),0,0,'R', false);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(70,5, "Factura de venta No. $numeroDian",0,1,'R',false);
		$pdf->Text(160,20,utf8_decode("Régimen común"));
		$pdf->ln(5);
		$pdf->Cell(40,10,"Fecha: ".$this->getFecha(),1,0,'L',false);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(110,4,"NIT: 900 307 086 - 7"."\n"."Carrera 51 # 40-74"."\n"."TEL:(4) 2327201"."\n".utf8_decode("Medellín - Colombia")."\n"."ferretrupersas@hotmail.com",0,"C",false);
		$pdf->ln();
		$venta = Venta::obtenerVenta($this->getVenta());
		$idVenta = $this->getVenta();
		$tipoVenta = TipoVenta::obtenerTipoVenta($idVenta);
		$cliente = Cliente::obtenerCliente($tipoVenta->getCliente(),false);
		if ($media) {
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(85,5, utf8_decode("SEÑORES:"),0,0,'J',true);
			$pdf->Cell(105,5, utf8_decode($cliente->getNombre()),1,1,'J',false);
			$pdf->Cell(35,5,"NIT: ",0,0,'J',true);//HHHHHHHHHHHHHHHHHHH
			$numeroIdentificacion = $cliente->getNumeroDeIdentificacion()." - ".$cliente->getDigitoDeVerificacion();
			$pdf->Cell(50,5, utf8_decode($numeroIdentificacion),1,0,'J',false);
			$pdf->Cell(35,5, "TELEFONO:",0,0,'J',true);
			$pdf->Cell(70,5,$cliente->getTelefono() ,1,1,'J',false);//HHHHHHHHHHHHHHHHHHH
			$pdf->Cell(35,5, utf8_decode("DIRECCIÓN:"),0,0,'J',true);
			$pdf->Cell(50,5, $cliente->getDireccion(),1,0,'J',false);
			$pdf->Cell(35,5, "CIUDAD:",0,0,'J',true);
			$pdf->Cell(70,5,$cliente->getCiudad() ,1,1,'J',false);
		}else{
			$pdf->SetFont('Arial','',11);
			$pdf->Cell(85,7, utf8_decode("SEÑORES:"),0,0,'J',true);
			$pdf->Cell(105,7, utf8_decode($cliente->getNombre()),1,1,'J',false);
			$pdf->Cell(35,7,"NIT: ",0,0,'J',true);//HHHHHHHHHHHHHHHHHHH
			$numeroIdentificacion = $cliente->getNumeroDeIdentificacion()." - ".$cliente->getDigitoDeVerificacion();
			$pdf->Cell(50,7, utf8_decode($numeroIdentificacion),1,0,'J',false);
			$pdf->Cell(35,7, "TELEFONO:",0,0,'J',true);
			$pdf->Cell(70,7,$cliente->getTelefono() ,1,1,'J',false);//HHHHHHHHHHHHHHHHHHH
			$pdf->Cell(35,7, utf8_decode("DIRECCIÓN:"),0,0,'J',true);
			$pdf->Cell(50,7, $cliente->getDireccion(),1,0,'J',false);
			$pdf->Cell(35,7, "CIUDAD:",0,0,'J',true);
			$pdf->Cell(70,7,$cliente->getCiudad() ,1,1,'J',false);
		}
		$statementProductos = $venta->obtenerInfoProductosProductoXVenta();
		$array = array();
		while ($producto = $statementProductos->fetch(PDO::FETCH_ASSOC)) {
			$array[]=$producto;
		}
		$pdf->ln();
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(15,5, "CODIGO:",1,0,'J',false);
		$pdf->Cell(74,5, "NOMBRE PRODUCTO:",1,0,'J',false);
		$pdf->Cell(35,5, "REFERENCIA:",1,0,'J',false);
		$pdf->Cell(20,5, "CANTIDAD:",1,0,'J',false);
		$pdf->Cell(23,5, "VR UNITARIO:",1,0,'J',false);
		$pdf->Cell(23,5, "VR TOTAL:",1,0,'J',false);
		$pdf->ln(10);
		$totalBruto=0;
		$totalFinal=0;
		$totalDescuento=0;
		$totalIva=0;
		$descuento = $venta->getDescuento();
		if ($descuento==NULL) {
			$descuento = 0;
		}
		$descuento = $descuento/100;
		foreach ($array as $item) {
			$pdf->Cell(15,3.5, $item['id_producto'],0,0,'J',false);
			$pdf->Cell(74,3.5, utf8_decode($item['nombre']),0,0,'J',false);
			$pdf->Cell(35,3.5, utf8_decode($item['referencia_fabrica']),0,0,'J',false);
			$pdf->Cell(20,3.5, $item['unidades'],0,0,'J',false);
			$pdf->Cell(23,3.5, number_format($item['precio_venta']),0,0,'J',false);
			$valorTotal = $item['unidades'] * $item['precio_venta'];
			$pdf->Cell(23,3.5, number_format($valorTotal),0,1,'J',false);
			$tieneIva = $item['tiene_iva'];

			if ($tieneIva==1) {
				$descuentoUnitarioSinIva=(($item['precio_venta']/(1+IVA))*$descuento);
				$descuentoTotalSinIva=$descuentoUnitarioSinIva*$item['unidades'];

				$precioBrutoUnitario=($item['precio_venta']/(1+IVA))-$descuentoUnitarioSinIva;
				$totalBruto+=($precioBrutoUnitario)*$item['unidades'];
				$totalFinal+=$precioBrutoUnitario *$item['unidades']* (1+IVA);
				$totalDescuento+=$descuentoTotalSinIva;
				$totalIva+=$precioBrutoUnitario*IVA*$item['unidades'];
			}else{
				$descuentoUnitario=(($item['precio_venta'])*$descuento);
				$descuentoTotal=$descuentoUnitario*$item['unidades'];

				$precioBrutoUnitario=$item['precio_venta']-$descuentoUnitario;
				$totalBruto+=(($precioBrutoUnitario)*$item['unidades']);
				$totalFinal+=(($precioBrutoUnitario)*$item['unidades']);
				$totalDescuento+=$descuentoTotal;

			}
		}
		$idResolucion=$this->getResolucion();
		$idInformacionFacturas=$this->getInformacionFactura();
		$consulta=$conexion->prepare("SELECT r_descripcion FROM `resoluciones` WHERE id_resolucion = :idResolucion");
		$consulta->bindParam(':idResolucion',$idResolucion,PDO::PARAM_INT);
		$consulta->execute();
		$resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
		$descripcionResolucion=$resultado2['r_descripcion'];
		$consulta2=$conexion->prepare("SELECT i_descripcion FROM `informacion_facturas` WHERE id_informacion_facturas = :informacionFactura");
		$consulta2->bindParam(':informacionFactura',$idInformacionFacturas,PDO::PARAM_INT);
		$consulta2->execute();
		$resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
		$infoFactura=$resultado2['i_descripcion'];
		if ($media) {
			$pdf->Rect(10, 72, 190, 15);
			$pdf->ln(7);
			$pdf->SetFont('Arial','B',10);
			$pdf->setY(91.5);
			$pdf->Cell(60,5, "Condiciones de pago: ",0,0,'J',false);//HHHHHHHHHHHHHHHHHHHHHHHH
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,5, $tipoVenta->getTipoVenta(),0,0,'J',false);
			$pdf->SetFont('Arial','B',10);
			$pdf->setY(91.5);
			$pdf->setX(120);
			$pdf->Cell(50,5, "Descuento: ",1,0,'J',false);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(30,5,number_format($totalDescuento,2),1,1,'R',false);
			$bool=false;
			if ($tipoVenta->getTipoVenta()=="Credito") {
				$plazo=$tipoVenta->getPlazo();
				$statmentAbonos = Abono::obtenerAbonos($tipoVenta->getIdTipoVenta());
				$arrayAbonos=array();
				while ($abono = $statmentAbonos->fetch(PDO::FETCH_ASSOC)) {
					$pdf->Cell(60,5,"Cuota:        ".$abono['fecha']."        $".number_format($abono['valor']),0,1,'J',false);
				}
			}
			


			// $pdf->MultiCell(110,4,"NIT: 900 307 086 - 7"."\n"."Carrera 51 # 40-74"."\n"."TEL:(4) 2327201"."\n".utf8_decode("Medellín - Colombia")."\n"."ferretrupersas@hotmail.com",0,"C",false);
/*			$pdf->ln(20);
					
$pdf->setY(219);*/
$pdf->setY(96.5);
$pdf->setX(120);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,5, "Total Bruto: ",1,0,'J',false);
$pdf->SetFont('Arial','',10);
$pdf->Cell(30,5,number_format($totalBruto,2),1,1,'R',false);
// $pdf->Cell(110,7,"",0,0,'J',false);
$pdf->SetFont('Arial','B',10);
$pdf->setX(120);
$pdf->Cell(50,5, "Iva: ",1,0,'J',false);
$pdf->SetFont('Arial','',10);
$pdf->Cell(30,5,number_format($totalIva,2),1,1,'R',false);
												// $pdf->Cell(110,7,"",0,0,'J',false);
$pdf->SetFont('Arial','B',10);
$retefuente=$venta->getRetefuente();
if ($retefuente==NULL) {
	$retefuente=0;
}
$pdf->setX(120);
$pdf->Cell(50,5, "Retefuente ".$retefuente."% : ",1,0,'J',false);
$pdf->SetFont('Arial','',10);
$totalRetefuente = $totalBruto*($retefuente/100);
$pdf->Cell(30,5,number_format($totalRetefuente,2),1,1,'R',false);
// $pdf->Cell(110,7,"",0,0,'J',false);
$pdf->SetFont('Arial','B',10);
$pdf->setX(120);
$pdf->Cell(50,5, "Total: ",1,0,'J',false);
$pdf->SetFont('Arial','',10);
$pdf->Cell(30,5,number_format($totalFinal-$totalRetefuente,2),1,1,'R',false);
$pdf->ln(3);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(190,4,utf8_decode($infoFactura) ,0,"C",false);
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(190,4, utf8_decode($descripcionResolucion),0,"C",false);
}else{
	$pdf->Rect(10, 80, 190, 130);
	$pdf->SetFont('Arial','B',10);
	$pdf->setY(212);
			$pdf->Cell(60,7, "Condiciones de pago: ",0,0,'J',false);//HHHHHHHHHHHHHHHHHHHHHHHH
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,7, $tipoVenta->getTipoVenta(),0,0,'J',false);
			$pdf->SetFont('Arial','B',10);
			$pdf->setY(212);
			$pdf->setX(120);
			$pdf->Cell(50,7, "Descuento: ",1,0,'J',false);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(30,7,number_format($totalDescuento,2),1,1,'R',false);
			$bool=false;
			if ($tipoVenta->getTipoVenta()=="Credito") {
				$plazo=$tipoVenta->getPlazo();
				$statmentAbonos = Abono::obtenerAbonos($tipoVenta->getIdTipoVenta());
				$arrayAbonos=array();
				while ($abono = $statmentAbonos->fetch(PDO::FETCH_ASSOC)) {
					$pdf->Cell(60,5,"Cuota:        ".$abono['fecha']."        $".number_format($abono['valor']),0,1,'J',false);
				}
			}
			


			// $pdf->MultiCell(110,4,"NIT: 900 307 086 - 7"."\n"."Carrera 51 # 40-74"."\n"."TEL:(4) 2327201"."\n".utf8_decode("Medellín - Colombia")."\n"."ferretrupersas@hotmail.com",0,"C",false);
			
			$pdf->setY(219);
			$pdf->setX(120);
			// $pdf->Cell(110,7,"",0,0,'J',false);
			$pdf->SetFont('Arial','B',10);

			$pdf->Cell(50,7, "Total Bruto: ",1,0,'J',false);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(30,7,number_format($totalBruto,2),1,1,'R',false);
			// $pdf->Cell(110,7,"",0,0,'J',false);
			$pdf->SetFont('Arial','B',10);
			$pdf->setX(120);
			$pdf->Cell(50,7, "Iva: ",1,0,'J',false);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(30,7,number_format($totalIva,2),1,1,'R',false);
			// $pdf->Cell(110,7,"",0,0,'J',false);
			$pdf->SetFont('Arial','B',10);
			$retefuente=$venta->getRetefuente();
			if ($retefuente==NULL) {
				$retefuente=0;
			}
			$pdf->setX(120);
			$pdf->Cell(50,7, "Retefuente ".$retefuente."% : ",1,0,'J',false);
			$pdf->SetFont('Arial','',10);
			$totalRetefuente = $totalBruto*($retefuente/100);
			$pdf->Cell(30,7,number_format($totalRetefuente,2),1,1,'R',false);
			// $pdf->Cell(110,7,"",0,0,'J',false);
			$pdf->SetFont('Arial','B',10);
			$pdf->setX(120);
			$pdf->Cell(50,7, "Total: ",1,0,'J',false);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(30,7,number_format($totalFinal-$totalRetefuente,2),1,1,'R',false);
			$pdf->ln(3);
			$pdf->SetFont('Arial','',12);
			$pdf->MultiCell(190,6,utf8_decode($infoFactura) ,0,"C",false);
			$pdf->SetFont('Arial','',9);
			$pdf->MultiCell(190,6, utf8_decode($descripcionResolucion),0,"C",false);
		}
		
/*		$fecha=date('Y-m-d');
		$carpeta = 'C:/xampp/htdocs/Ferretruper/assets/php/Facturas/'.$fecha;
		if (!file_exists($carpeta)) {
		    mkdir($carpeta, 0777, true);
		}*/


		$pdf->Output('I', $archivo);
		//$pdf->Output('D',$archivo_de_salida,true);
		ob_end_flush();
		header("Content-type:application/pdf");
		//Creacion de las cabeceras que generarán el archivo pdf
		header ("Content-Type: application/download");
		header ("Content-Disposition: attachment; filename=$archivo");
		header("Content-Length: " . filesize("$archivo"));
		$fp = fopen($archivo, "r");
		fpassthru($fp);
		fclose($fp);

		//Eliminación del archivo en el servidor
		unlink($archivo);
	}

	public function facturaPOSPDF(){
		$conexion = Conexion::conectar();
		require('../fpdf/fpdf.php');
		ob_start ();
		$numeroDian = $this->getNumeroDian();
		$pdf = new FPDF($orientation='P',$unit='mm', array(45,350));
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',9);    //Letra Arial, negrita (Bold), tam. 20
		$textypos = 10;
		$pdf->setY(2);
		$pdf->setX(2);
		$pdf->Image('../../images/LOGO FERRETRUPER.jpg' , 13 , 3 , 18 , 4,'JPG');
		$pdf->SetFont('Arial','',5);    //Letra Arial, negrita (Bold), tam. 20
		if ($this->getAnulada()==1) {
			$pdf->Image('../../images/anulado.png' , 13 , 10 , 20 , 20,'PNG');
		}
		$archivo="FacturaPOS-$numeroDian.pdf";
		$archivo_de_salida=$archivo;
		$pdf->setY(10);
		$pdf->setX(10);	
		$pdf->MultiCell(25,1.5,"NIT: 900 307 086 - 7"."\n"."Carrera 51 # 40-74"."\n"."TEL:(4) 2327201"."\n".utf8_decode("Medellín - Colombia")."\n"."ferretrupersas@hotmail.com",0,"C",false);
		$pdf->SetFont('Arial','',4);
		$pdf->Cell(15,5, "Factura de venta No. $numeroDian",0,0,'R',false);
		$pdf->Cell(20,5,"Fecha: ".$this->getFecha(),0,0,'L',false);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(110,4,"NIT: 900 307 086 - 7"."\n"."Carrera 51 # 40-74"."\n"."TEL:(4) 2327201"."\n".utf8_decode("Medellín - Colombia")."\n"."ferretrupersas@hotmail.com",0,"C",false);
		$pdf->SetFont('Arial','',4);
		$pdf->Text(17,23,utf8_decode("Régimen común"));
		$venta = Venta::obtenerVenta($this->getVenta());
		$idVenta = $this->getVenta();
		$tipoVenta = TipoVenta::obtenerTipoVenta($idVenta);
		$cliente = Cliente::obtenerCliente($tipoVenta->getCliente(),false);
		$pdf->SetFont('Arial','',4);
		$pdf->setY(25);
		$pdf->setX(5);
		$pdf->Cell(10,1.5, utf8_decode("SEÑORES:"),0,0,'J',false);
		$pdf->Cell(10,1.5, utf8_decode($cliente->getNombre()),0,1,'J',false);
		$pdf->setX(5);
		$pdf->Cell(10,1.5,"NIT: ",0,0,'J',false);//HHHHHHHHHHHHHHHHHHH
		$numeroIdentificacion = $cliente->getNumeroDeIdentificacion()." - ".$cliente->getDigitoDeVerificacion();
		$pdf->Cell(10,1.5, utf8_decode($numeroIdentificacion),0,1,'J',false);
		$pdf->setX(5);
		$pdf->Cell(10,1.5, "TELEFONO:",0,0,'J',false);
		$pdf->Cell(10,1.5,$cliente->getTelefono() ,0,1,'J',false);//HHHHHHHHHHHHHHHHHHH
		$pdf->setX(5);
		$pdf->Cell(10,1.5, utf8_decode("DIRECCIÓN:"),0,0,'J',false);
		$pdf->Cell(10,1.5, $cliente->getDireccion(),0,1,'J',false);
		$pdf->setX(5);
		$pdf->Cell(10,1.5, "CIUDAD:",0,0,'J',false);
		$pdf->Cell(10,1.5,$cliente->getCiudad() ,0,1,'J',false);
		$textypos+=-7;
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,'------------------------------------------------------------------------------------');
		$statementProductos = $venta->obtenerInfoProductosProductoXVenta();
		$productos = array();
		while ($producto = $statementProductos->fetch(PDO::FETCH_ASSOC)) {
			$productos[]=$producto;
		}
		$textypos+=6;
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,utf8_decode('Cód    Artículo    Referencia    Cantidad  Vr.Unitario    Vr.Total'));
		$totalBruto=0;
		$totalFinal=0;
		$totalDescuento=0;
		$totalIva=0;
		$descuento = $venta->getDescuento();
		if ($descuento==NULL) {
			$descuento = 0;
		}
		$descuento = $descuento/100;
		$off = $textypos+6;
		$pdf->SetFont('Arial','',3);
		$pdf->ln(7);
		foreach($productos as $item){
			$pdf->setX(2);
			$pdf->Cell(5,2,$item["id_producto"]);
			$pdf->setX(6);
			$pdf->Cell(11,2,  strtoupper(substr($item["nombre"], 0,7)),0,1 );
			$pdf->setX(6);
			$pdf->Cell(11,2,  strtoupper(substr($item["nombre"], 7,7))."..." );
			$pdf->setX(9);
			$pdf->Cell(11,2, $item["referencia_fabrica"] ,0,0,"R");
			$pdf->setX(16);
			$pdf->Cell(11,2,  number_format($item["unidades"],2,".",",") ,0,0,"R");
			$pdf->setX(24.5);
			$pdf->Cell(11,2,  number_format($item["precio_venta"],2,".",",") ,0,0,"R");
			$pdf->setX(32);
			$pdf->Cell(11,2,  number_format($item['unidades'] * $item['precio_venta'],2,".",",") ,0,1,"R");
			$off+=3;
			$tieneIva = $item['tiene_iva'];

			if ($tieneIva==1) {
				$descuentoUnitarioSinIva=(($item['precio_venta']/(1+IVA))*$descuento);
				$descuentoTotalSinIva=$descuentoUnitarioSinIva*$item['unidades'];

				$precioBrutoUnitario=($item['precio_venta']/(1+IVA))-$descuentoUnitarioSinIva;
				$totalBruto+=($precioBrutoUnitario)*$item['unidades'];
				$totalFinal+=$precioBrutoUnitario *$item['unidades']* (1+IVA);
				$totalDescuento+=$descuentoTotalSinIva;
				$totalIva+=$precioBrutoUnitario*IVA*$item['unidades'];
			}else{
				$descuentoUnitario=(($item['precio_venta'])*$descuento);
				$descuentoTotal=$descuentoUnitario*$item['unidades'];

				$precioBrutoUnitario=$item['precio_venta']-$descuentoUnitario;
				$totalBruto+=(($precioBrutoUnitario)*$item['unidades']);
				$totalFinal+=(($precioBrutoUnitario)*$item['unidades']);
				$totalDescuento+=$descuentoTotal;

			}
		}
		$pdf->ln(2);
		$pdf->SetFont('Arial','',4);
		$pdf->setX(4);
		$pdf->Cell(23,3, "Descuento: ",0,0,'J',false);
		$pdf->Cell(13,3,number_format($totalDescuento,2),0,1,'R',false);
		$pdf->setX(4);
		$pdf->Cell(23,3, "Total Bruto: ",0,0,'J',false);
		$pdf->Cell(13,3,number_format($totalBruto,2),0,1,'R',false);
		$pdf->setX(4);
		$pdf->Cell(23,3, "Iva: ",0,0,'J',false);
		$pdf->Cell(13,3,number_format($totalIva,2),0,1,'R',false);
		$pdf->setX(4);
		$retefuente=$venta->getRetefuente();
		if ($retefuente==NULL) {
			$retefuente=0;
		}
		$pdf->Cell(23,3, "Retefuente ".$retefuente."% : ",0,0,'J',false);
		$totalRetefuente = $totalBruto*($retefuente/100);
		$pdf->Cell(13,3,number_format($totalRetefuente,2),0,1,'R',false);
		$pdf->setX(4);
		$pdf->Cell(23,3, "Total: ",0,0,'J',false);
		$pdf->Cell(13,3,number_format($totalFinal-$totalRetefuente,2),0,1,'R',false);
		$pdf->setX(2);
		$pdf->Cell(1,1, "------------------------------------------------------------------------------------",0,1,'J',false);
		$pdf->setX(4);
		$pdf->SetFont('Arial','B',4);
		$pdf->Cell(16,5, "Condiciones de pago: ",0,0,'J',false);//HHHHHHHHHHHHHHHHHHHHHHHH
		$pdf->SetFont('Arial','',4);
		$pdf->Cell(12,5, $tipoVenta->getTipoVenta(),0,1,'J',false);
		$bool=false;
		if ($tipoVenta->getTipoVenta()=="Credito") {
			$plazo=$tipoVenta->getPlazo();
			$statmentAbonos = Abono::obtenerAbonos($tipoVenta->getIdTipoVenta());
			$arrayAbonos=array();
			while ($abono = $statmentAbonos->fetch(PDO::FETCH_ASSOC)) {
				$pdf->setX(5);
				$pdf->Cell(4,3,"Cuota:        ".$abono['fecha']."        $".number_format($abono['valor']),0,1,'J',false);
			}
		}
		$idResolucion=$this->getResolucion();
		$idInformacionFacturas=$this->getInformacionFactura();
		$consulta=$conexion->prepare("SELECT r_descripcion FROM `resoluciones` WHERE id_resolucion = :idResolucion");
		$consulta->bindParam(':idResolucion',$idResolucion,PDO::PARAM_INT);
		$consulta->execute();
		$resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
		$descripcionResolucion=$resultado2['r_descripcion'];
		$consulta2=$conexion->prepare("SELECT i_descripcion FROM `informacion_facturas` WHERE id_informacion_facturas = :informacionFactura");
		$consulta2->bindParam(':informacionFactura',$idInformacionFacturas,PDO::PARAM_INT);
		$consulta2->execute();
		$resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
		$infoFactura=$resultado2['i_descripcion'];
		$pdf->setX(2);
		$pdf->Cell(1,1, "------------------------------------------------------------------------------------",0,1,'J',false);
		$pdf->setX(4);
		$pdf->SetFont('Arial','',5);
		$pdf->MultiCell(37,2,utf8_decode($infoFactura) ,0,"J",false);
		$pdf->SetFont('Arial','',4);
		$pdf->setX(4);
		$pdf->Cell(1,3, "",0,1,'J',false);
		$pdf->setX(4);
		$pdf->MultiCell(37,2, utf8_decode($descripcionResolucion),0,"C",false);
		$pdf->output();
		ob_end_flush();
	}
	public function imprimirFacturaPOS()
	{


		require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea


		/*
			Este ejemplo imprime un
			ticket de venta desde una impresora térmica
		*/


		/*
		    Aquí, en lugar de "POS" (que es el nombre de mi impresora)
			escribe el nombre de la tuya. Recuerda que debes compartirla
			desde el panel de control
		*/

			$nombre_impresora = "POS"; 


			$connector = new WindowsPrintConnector($nombre_impresora);
			$printer = new Printer($connector);
		#Mando un numero de respuesta para saber que se conecto correctamente.
			echo 1;
		/*
			Vamos a imprimir un logotipo
			opcional. Recuerda que esto
			no funcionará en todas las
			impresoras

			Pequeña nota: Es recomendable que la imagen no sea
			transparente (aunque sea png hay que quitar el canal alfa)
			y que tenga una resolución baja. En mi caso
			la imagen que uso es de 250 x 250
		*/

		# Vamos a alinear al centro lo próximo que imprimamos
			$numeroDian = $this->getNumeroDian();
			$printer->setJustification(Printer::JUSTIFY_CENTER);

		/*
			Intentaremos cargar e imprimir
			el logo
		*/
			try{
				$logo = EscposImage::load("../../images/LOGO FERRETRUPER.jpg", false);
				$printer->bitImage($logo);
			}catch(Exception $e){/*No hacemos nada si hay error*/}

		/*
			Ahora vamos a imprimir un encabezado
		*/
			$printer->text("\n"."FERRETRUPER S.A.S" . "\n");
			$printer->text("NIT: 900 307 086 - 7" . "\n");
			$printer->text("Direccion: Carrera 51 # 40-74" . "\n");
			$printer->text("Tel:(4) 2327201" . "\n");
			$printer->text("Medellín - Colombia" . "\n");
			$printer->text("ferretrupersas@hotmail.com" . "\n");
		#La fecha también
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->text(date($this->getFecha()));
			$printer->setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text(utf8_decode("Régimen común") . "\n");
			$printer->text(utf8_decode("SEÑORES: ") . $cliente->getNombre() ."\n");
			$numeroIdentificacion = $cliente->getNumeroDeIdentificacion()." - ".$cliente->getDigitoDeVerificacion();
			$printer->text(utf8_decode("NIT: "). $numeroIdentificacion. "\n");
			$printer->text(utf8_decode("TELÉFONO: "). $cliente->getTelefono() . "\n");
			$printer->text(utf8_decode("DIRECCIÓN: "). $cliente->getDireccion() . "\n");
			$printer->text(utf8_decode("CIUDAD: "). $cliente->getCiudad() . "\n");

			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$statementProductos = $venta->obtenerInfoProductosProductoXVenta();
			$productos = array();
			while ($producto = $statementProductos->fetch(PDO::FETCH_ASSOC)) {
				$productos[]=$producto;
			}
			$printer->text("-----------------------------" . "\n");
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$venta = Venta::obtenerVenta($this->getVenta());
			$idVenta = $this->getVenta();
			$tipoVenta = TipoVenta::obtenerTipoVenta($idVenta);
			$cliente = Cliente::obtenerCliente($tipoVenta->getCliente(),false);

			$printer->text("Cód    Artículo    Referencia    Cantidad  Vr.Unitario    Vr.Total"."\n");
			$printer->text("-----------------------------"."\n");
		/*
			Ahora vamos a imprimir los
			productos
		*/
			/*Alinear a la izquierda para la cantidad y el nombre*/
			$totalBruto=0;
			$totalFinal=0;
			$totalDescuento=0;
			$totalIva=0;
			$descuento = $venta->getDescuento();
			if ($descuento==NULL) {
				$descuento = 0;
			}
			$descuento = $descuento/100;
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			foreach ($productos as $item) {
				$printer->text($item["id_producto"]." ".strtoupper(substr($item["nombre"], 0,7))." " .$item["referencia_fabrica"]." ". number_format($item["unidades"],2,".",","). " ". number_format($item["precio_venta"],2,".",","). " ". number_format($item['unidades'] * $item['precio_venta'],2,".",",")."\n");
				$tieneIva = $item['tiene_iva'];

				if ($tieneIva==1) {
					$descuentoUnitarioSinIva=(($item['precio_venta']/(1+IVA))*$descuento);
					$descuentoTotalSinIva=$descuentoUnitarioSinIva*$item['unidades'];

					$precioBrutoUnitario=($item['precio_venta']/(1+IVA))-$descuentoUnitarioSinIva;
					$totalBruto+=($precioBrutoUnitario)*$item['unidades'];
					$totalFinal+=$precioBrutoUnitario *$item['unidades']* (1+IVA);
					$totalDescuento+=$descuentoTotalSinIva;
					$totalIva+=$precioBrutoUnitario*IVA*$item['unidades'];
				}else{
					$descuentoUnitario=(($item['precio_venta'])*$descuento);
					$descuentoTotal=$descuentoUnitario*$item['unidades'];

					$precioBrutoUnitario=$item['precio_venta']-$descuentoUnitario;
					$totalBruto+=(($precioBrutoUnitario)*$item['unidades']);
					$totalFinal+=(($precioBrutoUnitario)*$item['unidades']);
					$totalDescuento+=$descuentoTotal;

				}

			}
		/*
			Terminamos de imprimir
			los productos, ahora va el total
		*/
			$printer->text("-----------------------------"."\n");
			$printer->setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("Descuento: ".number_format($totalDescuento,2)."\n");
			$printer->text("Total Bruto: ".number_format($totalBruto,2)."\n");
			$printer->text("Iva: ".number_format($totalIva,2)."\n");
			$retefuente=$venta->getRetefuente();
			if ($retefuente==NULL) {
				$retefuente=0;
			}
			$totalRetefuente = $totalBruto*($retefuente/100);
			$printer->text("Retefuente: ".number_format($totalRetefuente,2)."\n");
			$printer->text("Total: ".number_format($totalFinal-$totalRetefuente,2)."\n");
			$printer->text("-----------------------------"."\n");
			$printer->text("Condiciones de pago: ".$tipoVenta->getTipoVenta()."\n");
			if ($tipoVenta->getTipoVenta()=="Credito") {
				$plazo=$tipoVenta->getPlazo();
				$statmentAbonos = Abono::obtenerAbonos($tipoVenta->getIdTipoVenta());
				$arrayAbonos=array();
				while ($abono = $statmentAbonos->fetch(PDO::FETCH_ASSOC)) {
					$printer->text("Cuota: ".$abono['fecha']." $".number_format($abono['valor'])."\n");
				}
			}
			$printer->text("-----------------------------"."\n");
		/*
			Podemos poner también un pie de página
		*/
			$idResolucion=$this->getResolucion();
			$idInformacionFacturas=$this->getInformacionFactura();
			$consulta=$conexion->prepare("SELECT r_descripcion FROM `resoluciones` WHERE id_resolucion = :idResolucion");
			$consulta->bindParam(':idResolucion',$idResolucion,PDO::PARAM_INT);
			$consulta->execute();
			$resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
			$descripcionResolucion=$resultado2['r_descripcion'];
			$consulta2=$conexion->prepare("SELECT i_descripcion FROM `informacion_facturas` WHERE id_informacion_facturas = :informacionFactura");
			$consulta2->bindParam(':informacionFactura',$idInformacionFacturas,PDO::PARAM_INT);
			$consulta2->execute();
			$resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
			$infoFactura=$resultado2['i_descripcion'];

			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text(utf8_decode($infoFactura)."\n");
			$printer->text(utf8_decode($descripcionResolucion)."\n");



			/*Alimentamos el papel 3 veces*/
			$printer->feed(3);

		/*
			Cortamos el papel. Si nuestra impresora
			no tiene soporte para ello, no generará
			ningún error
		*/
			$printer->cut();

		/*
			Por medio de la impresora mandamos un pulso.
			Esto es útil cuando la tenemos conectada
			por ejemplo a un cajón
		*/
			$printer->pulse();

		/*
			Para imprimir realmente, tenemos que "cerrar"
			la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
		*/
			$printer->close();


		}





	}



	?>
