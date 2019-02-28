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

	public function __construct0($total, $fecha, $informacionFactura, $venta, $resolucion, $numeroDian, $anulada=0, $fechaAnulada=NULL){
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("INSERT INTO `facturas` (`id_factura`, `total`, `fecha`, `anulada`, `fecha_anulada`, `numero_dian`, `informacion_facturas_id_informacion_facturas`, `resoluciones_id_resolucion`, `ventas_id_venta`) VALUES (NULL, :total, :fecha, :anulada, :fechaAnulada, :numeroDian, :informacionFactura, :resolucion, :venta)");

		$this->setTotal($total,$statement);
		$this->setFecha($fecha,$statement);
		$this->setAnulada($anulada,$statement);
		$this->setFechaAnulada($fechaAnulada,$statement);
		$this->setInformacionFactura($informacionFactura,$statement);
		$consulta=$conexion->prepare("SELECT descripcion FROM `informacion_facturas` WHERE id_informacion_facturas = :informacionFactura");
		$consulta->bindParam(':informacionFactura',$informacionFactura,PDO::PARAM_INT);
		$consulta->execute();
		$resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
		$this->setInformacionFactura($resultado2['descripcion']);
		$this->setVenta($venta,$statement);
		$this->setResolucion($resolucion,$statement);
		$consulta=$conexion->prepare("SELECT descripcion FROM `resoluciones` WHERE id_resolucion = :idResolucion");
		$consulta->bindParam(':idResolucion',$resolucion,PDO::PARAM_INT);
		$consulta->execute();
		$resultado2 = $consulta->fetch(PDO::FETCH_ASSOC);
		$this->setResolucion($resultado2['descripcion']);
		$consulta=null;
		$this->setNumeroDian($numeroDian,$statement);
		$statement->execute();
		$this->setidFactura($conexion->lastInsertId());
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



			$idInformacionFacturas = $resultado['informacion_facturas_id_informacion_facturas'];
			$consulta2=$conexion->prepare("SELECT descripcion FROM `informacion_facturas` WHERE id_informacion_facturas = :informacionFactura");
			$consulta2->bindParam(':informacionFactura',$idInformacionFacturas,PDO::PARAM_INT);
			$consulta2->execute();
			$resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
			$factura->setInformacionFactura($resultado2['descripcion']);
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
	public function imprimirFacturaCarta($media=false){
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
		$pdf->Cell(70,5, "Factura No. $numeroDian",0,1,'R',false);
		$pdf->ln(5);
		$pdf->Cell(40,10,"Fecha: ".$this->getFecha(),1,0,'L',false);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(110,4,"NIT: 900 307 086 - 7"."\n"."Carrera 51 # 40-74"."\n"."TEL:(4) 2327201"."\n".utf8_decode("Medellín - Colombia")."\n"."ferretrupersas@hotmail.com",0,"C",false);
		$pdf->ln();
		$venta = $this->getVenta();
		$idVenta = $venta->getIdVenta();
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
		if ($media) {
			$pdf->Rect(10, 72, 190, 15);
			$pdf->ln(7);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(60,5, "Condiciones de pago: ",0,0,'J',false);//HHHHHHHHHHHHHHHHHHHHHHHH
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,5, $tipoVenta->getTipoVenta(),0,0,'J',false);
			$pdf->SetFont('Arial','B',10);
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
			$pdf->setX(120);
			// $pdf->Cell(110,7,"",0,0,'J',false);
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
			$pdf->MultiCell(190,4,utf8_decode($this->getInformacionFactura()) ,0,"C",false);
			$pdf->SetFont('Arial','',7);
			$pdf->MultiCell(190,4, utf8_decode($this->getResolucion()),0,"C",false);
		}else{
			$pdf->Rect(10, 80, 190, 130);
			$pdf->ln(119.5);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(60,7, "Condiciones de pago: ",0,0,'J',false);//HHHHHHHHHHHHHHHHHHHHHHHH
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(50,7, $tipoVenta->getTipoVenta(),0,0,'J',false);
			$pdf->SetFont('Arial','B',10);
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
			$pdf->ln(20);
			
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
			$pdf->MultiCell(190,6,utf8_decode($this->getInformacionFactura()) ,0,"C",false);
			$pdf->line(200,256,10,256);
			$pdf->SetFont('Arial','',9);
			$pdf->MultiCell(190,6, utf8_decode($this->getResolucion()),0,"J",false);
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
	public function imprimirFacturaPOS()
	{


		require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
/*		use Mike42\Escpos\Printer;
		use Mike42\Escpos\EscposImage;
		use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;*/

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
			$printer->setJustification(Printer::JUSTIFY_CENTER);

		/*
			Intentaremos cargar e imprimir
			el logo
		*/
			try{
				$logo = EscposImage::load("geek.png", false);
				$printer->bitImage($logo);
			}catch(Exception $e){/*No hacemos nada si hay error*/}

		/*
			Ahora vamos a imprimir un encabezado
		*/

			$printer->text("\n"."Nombre de la Empresa" . "\n");
			$printer->text("Direccion: Orquídeas #151" . "\n");
			$printer->text("Tel: 454664544" . "\n");
		#La fecha también
			date_default_timezone_set("America/Bogota");
			$printer->text(date("Y-m-d H:i:s") . "\n");
			$printer->text("-----------------------------" . "\n");
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->text("CANT  DESCRIPCION    P.U   IMP.\n");
			$printer->text("-----------------------------"."\n");
		/*
			Ahora vamos a imprimir los
			productos
		*/
			/*Alinear a la izquierda para la cantidad y el nombre*/
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->text("Producto Galletas\n");
			$printer->text( "2  pieza    10.00 20.00   \n");
			$printer->text("Sabrtitas \n");
			$printer->text( "3  pieza    10.00 30.00   \n");
			$printer->text("Doritos \n");
			$printer->text( "5  pieza    10.00 50.00   \n");
		/*
			Terminamos de imprimir
			los productos, ahora va el total
		*/
			$printer->text("-----------------------------"."\n");
			$printer->setJustification(Printer::JUSTIFY_RIGHT);
			$printer->text("SUBTOTAL: $100.00\n");
			$printer->text("IVA: $16.00\n");
			$printer->text("TOTAL: $116.00\n");


		/*
			Podemos poner también un pie de página
		*/
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("Muchas gracias por su compra\n");



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
