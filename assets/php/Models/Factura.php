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

	public function __construct0($total, $fecha, $informacionFactura, $venta, $resolucion, $numeroDian, $anulada=NULL, $fechaAnulada=NULL){
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
		$archivo="FacturaCarta-$numeroDian.pdf";
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
			$pdf->Cell(15,5, $item['id_producto'],0,0,'J',false);
			$pdf->Cell(74,5, utf8_decode($item['nombre']),0,0,'J',false);
			$pdf->Cell(35,5, utf8_decode($item['referencia_fabrica']),0,0,'J',false);
			$pdf->Cell(20,5, $item['unidades'],0,0,'J',false);
			$pdf->Cell(23,5, number_format($item['precio_venta']),0,0,'J',false);
			$valorTotal = $item['unidades'] * $item['precio_venta'];
			$pdf->Cell(23,5, number_format($valorTotal),0,1,'J',false);
			$tieneIva = $item['tiene_iva'];

			if ($tieneIva==1) {
				$descuentoUnitarioSinIva=(($item['precio_venta']/1.19)*$descuento);
				$descuentoTotalSinIva=$descuentoUnitarioSinIva*$item['unidades'];

				$precioBrutoUnitario=($item['precio_venta']/1.19)-$descuentoUnitarioSinIva;
				$totalBruto+=($precioBrutoUnitario)*$item['unidades'];
				$totalFinal+=$precioBrutoUnitario *$item['unidades']* 1.19;
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
		$pdf->Rect(10, 80, 190, 130);
		$pdf->ln(120);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(60,7, "Condiciones de pago: ",0,0,'J',false);//HHHHHHHHHHHHHHHHHHHHHHHH
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(50,7, $tipoVenta->getTipoVenta(),0,0,'J',false);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,7, "Descuento: ",1,0,'J',false);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30,7,number_format($totalDescuento,2),1,1,'R',false);
		$pdf->Cell(110,7,"",0,0,'J',false);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,7, "Total Bruto: ",1,0,'J',false);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30,7,number_format($totalBruto,2),1,1,'R',false);
		$pdf->Cell(110,7,"",0,0,'J',false);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,7, "Iva: ",1,0,'J',false);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30,7,number_format($totalIva,2),1,1,'R',false);
		$pdf->Cell(110,7,"",0,0,'J',false);
		$pdf->SetFont('Arial','B',10);
		$retefuente=$venta->getRetefuente();
		if ($retefuente==NULL) {
			$retefuente=0;
		}
		$pdf->Cell(50,7, "Retefuente ".$retefuente."% : ",1,0,'J',false);
		$pdf->SetFont('Arial','',10);
		$totalRetefuente = $totalBruto*($retefuente/100);
		$pdf->Cell(30,7,number_format($totalRetefuente,2),1,1,'R',false);
		$pdf->Cell(110,7,"",0,0,'J',false);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,7, "Total: ",1,0,'J',false);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30,7,number_format($totalFinal-$totalRetefuente,2),1,1,'R',false);
		$pdf->ln(3);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(190,6,utf8_decode($this->getInformacionFactura()) ,0,"C",false);
		$pdf->line(200,256,10,256);
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(190,6, utf8_decode($this->getResolucion()),0,"J",false);




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
	public function imprimirFacturaPOS()
	{
		include_once '../Controllers/CifrasEnLetras.php';
		require('../fpdf/fpdf.php');
		$pdf = new FPDF($orientation='P',$unit='mm', array(45,350));
		$pdf->AddPage();
		$numeroDian = $this->getNumeroDian();
		$archivo="FacturaCarta-$numeroDian.pdf";
		$archivo_de_salida=$archivo;
		$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 20
		$textypos = 5;
		$pdf->setY(2);
		$pdf->setX(2);
		$pdf->Cell(41,4, "FERRETRUPER S.A.S",0,1,'C',false);
		$pdf->SetFont('Arial','',4);
		$pdf->setX(2);
		$pdf->MultiCell(41,2,"NIT: 900 307 086 - 7"."\n"."Carrera 51 # 40-74"."\n"."TEL:(4) 2327201"."\n".utf8_decode("Medellín - Colombia")."\n"."ferretrupersas@hotmail.com",0,"C",false);
		$pdf->SetFont('Arial','',5);    //Letra Arial, negrita (Bold), tam. 20
		$textypos+=6;
		$pdf->setY(11);
		$pdf->setX(2);
		$pdf->Cell(41,11,'-------------------------------------------------------------------',0,1,"C",false);
		$pdf->setY(17);
		$pdf->setX(2);
		$pdf->SetFont('Arial','B',4);
		$pdf->Cell(41,3, "Factura No. $numeroDian",0,1,'C',false);
		$pdf->setX(2);
		$pdf->SetFont('Arial','',4);
		$venta = $this->getVenta();
		$idVenta = $venta->getIdVenta();
		$tipoVenta = TipoVenta::obtenerTipoVenta($idVenta);
		$cliente = $tipoVenta->getCliente();
		$pdf->Cell(41,2,"Fecha: ".$this->getFecha(),0,1,'L',false);
		$pdf->setX(2);
		$pdf->Cell(41,2,"Vendedor: ".$tipoVenta->getEmpleado()->getNombre(),0,1,'L',false);
		$pdf->setX(2);
		$pdf->Cell(41,2,"Cliente: ".$cliente->getNombre(),0,1,'L',false);
		$pdf->setX(2);
		$pdf->Cell(41,2,"Nit / C.C.: ".$cliente->getNumeroDeIdentificacion(),0,1,'L',false);
		$pdf->setX(2);
		$pdf->Cell(41,2,"Direccion: ".$cliente->getDireccion(),0,1,'L',false);
		$pdf->setX(2);
		$pdf->Cell(41,3,'-------------------------------------------------------------------------------------',0,1,"C",false);
		$pdf->setX(2);
		$pdf->SetFont('Arial','',3);
		$pdf->Cell(6,4, "CODIGO",1,0,'L',false);
		$pdf->MultiCell(9, 2, "NOMBRE PRODUCTO",1,'C', false);
		$pdf->ln(-6);
		$pdf->setX(17);
		$pdf->Cell(6.8,2, "REFERENCIA",1,0,'J',false);
		$pdf->Cell(6.8,2, "CANT",1,0,'J',false);
		$pdf->Cell(6.8,2, "VR UNITARIO",1,0,'J',false);
		$pdf->Cell(6.8,2, "VR TOTAL",1,0,'J',false);
		$total =0;
		$off = $textypos+6;
		$producto = array(
			"q"=>1,
			"name"=>"Computadora Lenovo i5",
			"price"=>100
		);
		$productos = array($producto, $producto, $producto, $producto, $producto );
		foreach($productos as $pro){
			$pdf->setX(2);
			$pdf->Cell(5,$off,$pro["q"]);
			$pdf->setX(6);
			$pdf->Cell(35,$off,  strtoupper(substr($pro["name"], 0,12)) );
			$pdf->setX(20);
			$pdf->Cell(11,$off,  "$".number_format($pro["price"],2,".",",") ,0,0,"R");
			$pdf->setX(32);
			$pdf->Cell(11,$off,  "$ ".number_format($pro["q"]*$pro["price"],2,".",",") ,0,0,"R");
			$total += $pro["q"]*$pro["price"];
			$off+=6;
		}
		$textypos=$off+6;
		$pdf->setX(2);
		$pdf->Cell(5,$textypos,"TOTAL: " );
		$pdf->setX(38);
		$pdf->Cell(5,$textypos,"$ ".number_format($total,2,".",","),0,0,"R");
		$pdf->setX(2);
		$pdf->Cell(5,$textypos+6,'GRACIAS POR TU COMPRA ');
		$pdf->output();
	}





}



?>
