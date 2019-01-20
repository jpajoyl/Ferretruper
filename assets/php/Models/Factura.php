<?php 

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

	public function __construct0($total, $fecha, $anulada, $fechaAnulada, $informacionFactura, $venta, $resolucion, $numeroDian){
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
		if(!$statement){
			throw new Exception("Error Processing Request", 1);
		}
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
			$factura->setVenta(Venta::obtenerVenta($resultado['ventas_id_venta']));
			$idResolucion = $resultado['resoluciones_id_resolucion'];
			$consulta=$conexion->prepare("SELECT descripcion FROM `resoluciones` WHERE id_resolucion = :idResolucion");
			$consulta->bindParam(':idResolucion',$idResolucion,PDO::PARAM_INT);
			$consulta->execute();
			$resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
			$factura->setResolucion($resultado2['descripcion']);
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
		$idFactura=$this->getidFactura();
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("UPDATE `facturas` SET `anulada` = '1' WHERE `facturas`.`id_factura` = :idFactura");
		$statement->bindParam(':idFactura',$idFactura,PDO::PARAM_INT);
		$statement->execute();
		$this->setAnulada(1);
		$conexion=null;
		$statement=null;
	}
	public function imprimirFacturaCarta(){
		include_once '../Controllers/CifrasEnLetras.php';
		require('../fpdf/fpdf.php');
		$pdf=new FPDF();  //crea el objeto
		$pdf->AddPage();  //añadimos una página. Origen coordenadas, esquina superior izquierda, posición por defeto a 1 cm de los bordes.
		$pdf->SetFillColor(215, 205, 203);
		$pdf->Image('../../images/LOGO FERRETRUPER.jpg' , 7 , 7 , 40 , 10,'JPG');
		$numeroDian = $this->getNumeroDian();
		$archivo="comprobanteEgreso-$numeroDian.pdf";
		$archivo_de_salida=$archivo;
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(115,5,utf8_decode('FERRETRUPER S.A.S'),0,0,'R', false);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(70,5, "Factura No. $numeroDian",0,1,'R',false);
		$pdf->ln(5);
		$pdf->Cell(40,10,"Fecha: ".$this->getFecha(),1,0,'L',false);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(110,4,"NIT: 900 307 086 - 7"."\n"."Carrera 51 # 40-74"."\n"."TEL:(4) 2327201"."\n".utf8_decode("Medellín - Colombia")."\n"."ferretrupersas@hotmail.com",0,"C",false);
		$pdf->ln();
		$venta = $this->getVenta();
		$idVenta = $venta->getIdVenta();
		$tipoVenta = TipoVenta::obtenerTipoVenta($idVenta);
		$idCliente = $tipoVenta->getCliente();
		$cliente = $tipoVenta->getCliente();
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
		$statementProductos = $venta->obtenerInfoProductosProductoXVenta();
		$array = array();
		while ($producto = $statementProductos->fetch(PDO::FETCH_ASSOC)) {
			$array[]=$producto;
		}
		foreach ($array as $item) {
			$descripcion =$item['id_producto'];
			$pdf->Cell(140,5, $descripcion,0,1,'J',false);//HHHHHHHHHHHHHHHHHHH
			//$pdf->Cell(190,5, number_format($compra->getTotalCompra()),0,1,'L',false);
			$pdf->ln(0.7);
		}

			$pdf->ln();

		// $pdf->SetXY(10, 70);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(70,10, "$                ",1,0,'L',false);//HHHHHHHHHHHHHHHHHHHHHHHH
		$pdf->Cell(30,10, "Efectivo: si | no",1,1,'C',false);//HHHHHHHHHHHHHHHHHHH
		$pdf->Cell(100,20, "Cheque No.",1,0,'L',false);
		$pdf->Cell(90,20, "Firma y Sello Beneficiario:",1,1,'L',false);




		$pdf->Output('I',$archivo_de_salida,true);
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





}



 ?>
