<?php 


	/**
	 * 
	 */
	class ComprobanteEgreso {
		

		//atributos
		private $numeroConsecutivo;
		private $fechaPago;
		private $descripcion;
		private $compra;//objeto compra


		public function __construct(){
			$params = func_get_args();
			$num_params = func_num_args();
			if($num_params>0){
				call_user_func_array(array($this,"__construct0"),$params);
			}
		}

		public function __construct0($fechaPago, $descripcion){ //compra es un objeto de ese tipo
			$conexion = Conexion::conectar();
			$statement = $conexion->prepare("INSERT INTO `comprobantes_egreso`(`id_comprobante_egreso`, `fecha_pago`, `descripcion`, `COMPRAS_id_compra`) VALUES (NULL,:fechaPago,:descripcion,:compra)");

			$this->setFechaPago($fechaPago,$statement);
			$this->setDescripcion($descripcion,$statement);
			$statement->execute();
			if(!$statement){
				throw new Exception("Error Processing Request", 1);
			}
			$conexion = NULL;
			$statement = NULL;
		}

		//get & set
		public function getDescripcion()
		{
		    return $this->descripcion;
		}
		
		public function setDescripcion($descripcion, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':descripcion',$descripcion,PDO::PARAM_STR, 500);
			}
			$this->descripcion = $descripcion;
			return $this;
		}
		public function getNumeroConsecutivo()
		{
		    return $this->numeroConsecutivo;
		}
		
		public function setNumeroConsecutivo($numeroConsecutivo, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':numeroConsecutivo',$numeroConsecutivo,PDO::PARAM_INT);
			}
			$this->numeroConsecutivo = $numeroConsecutivo;
			return $this;
		}

		public function getFechaPago()
		{
		    return $this->fechaPago;
		}
		
		public function setFechaPago($fechaPago, $statement=NULL)
		{
			if($statement!=NULL){
				$statement->bindParam(':fechaPago',$fechaPago,PDO::PARAM_STR, 45);
			}
			$this->fechaPago = $fechaPago;
			return $this;
		}

		public static function obtenerComprobanteEgreso($numeroDeConsulta){
			//idcomprobanteEgreso
			$conexion = Conexion::conectar();
				$statement = $conexion->prepare("SELECT * FROM `comprobantes_egreso` WHERE  `id_comprobante_egreso` = :numeroDeConsulta");
			
			$statement->bindValue(":numeroDeConsulta", $numeroDeConsulta);
			$statement->execute();
			$resultado = $statement->fetch(PDO::FETCH_ASSOC);
			if($resultado!=false){
				$comprobanteEgreso = new comprobanteEgreso();
				$comprobanteEgreso->setNumeroConsecutivo($resultado['id_comprobante_egreso']);
				$comprobanteEgreso->setFechaPago($resultado['fecha_pago']);
				$comprobanteEgreso->setDescripcion($resultado['descripcion']);
				$conexion=null;
				$statement=null;
				return $comprobanteEgreso;
			}else{
				$conexion=null;
				$statement=null;
				return false;
			}
		}


		public function imprimirComprobante(){
			include_once '../Controllers/CifrasEnLetras.php';
			require('../fpdf/fpdf.php');
			$pdf=new FPDF();  //crea el objeto
			$pdf->AddPage();  //añadimos una página. Origen coordenadas, esquina superior izquierda, posición por defeto a 1 cm de los bordes.
			$pdf->Image('../../images/LOGO FERRETRUPER.jpg' , 7 , 7 , 40 , 10,'JPG');
			$idComprobanteEgreso = $this->getNumeroConsecutivo();
			$archivo="comprobanteEgreso-$idComprobanteEgreso.pdf";
			$archivo_de_salida=$archivo;
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(190,5,utf8_decode('régimen común'),0,1,'C', false);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(190,5, "Comprobante de egreso No. $idComprobanteEgreso",0,1,'C',false);
			$pdf->Cell(190,5,"Fecha: ".$this->getFechaPago(),0,1,'R',false);
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(190,4,"NIT: 900 307 086 - 7"."\n"."DIRECCION: Carrera 51 Bolivar No.40-74"."\n"."TELEFAX: 2327201 / 2328306",0,"L",false);
			$pdf->ln(2);
			$pdf->SetFont('Arial','U',11);
			$pdf->Cell(190,5, "PAGADO A:",0,1,'J',false);
			$pdf->SetFont('Arial','',11);
			$compra=$this->getCompra();
			$proveedor = $compra->getProveedor();
			$nombreProveedor = $proveedor->getNombre();
			$nitProveedor = $proveedor->getNumeroDeIdentificacion()." - ".$proveedor->getDigitoDeVerificacion();
			$pdf->Cell(190,5, $nombreProveedor."     nit: ".$nitProveedor,0,1,'J',false);//HHHHHHHHHHHHHHHHHHH
			$pdf->SetFont('Arial','U',11);
			$pdf->Cell(190,5, "LA SUMA DE:",0,1,'J',false);
			$pdf->SetFont('Arial','',11);
			$totalCompra = $compra->getTotalCompra();
			$pdf->Cell(190,5,CifrasEnLetras::convertirNumeroEnLetras($totalCompra)." pesos" ,0,1,'J',false);//HHHHHHHHHHHHHHHHHHH
			$pdf->SetFont('Arial','U',11);
			$pdf->Cell(190,5, "POR CONCEPTO:",0,1,'J',false);
			$pdf->SetFont('Arial','',11);
			$descripcion = $this->getDescripcion();
			$pdf->Cell(190,5, $descripcion,0,1,'J',false);//HHHHHHHHHHHHHHHHHHH
			$pdf->ln(2);

			$pdf->SetXY(10, 70);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(70,10, "$                ".strval(number_format($totalCompra)),1,0,'L',false);//HHHHHHHHHHHHHHHHHHHHHHHH
			$pdf->Cell(30,10, "Efectivo: si | no",1,1,'C',false);//HHHHHHHHHHHHHHHHHHH
			$pdf->Cell(100,20, "Cheque No.",1,0,'L',false);
			$pdf->Cell(90,20, "Firma y Sello Beneficiario:",1,1,'L',false);




			$pdf->Output('F',$archivo_de_salida,true);
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