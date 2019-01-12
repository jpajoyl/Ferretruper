<?php 

	/**
	 * 
	 */
	class Garantia {
		

		//atributos
		private $idGarantia;
		private $fechaFinal;
		private $unidadesDefectuosas;
		private $reposicion;//boolean

		//get & set
		public function getIdGarantia()
		{
		    return $this->idGarantia;
		}
		
		public function setIdGarantia($idGarantia)
		{
		    $this->idGarantia = $idGarantia;
		    return $this;
		}

		public function getFechaFinal()
		{
		    return $this->fechaFinal;
		}
		
		public function setFechaFinal($fechaFinal)
		{
		    $this->fechaFinal = $fechaFinal;
		    return $this;
		}

		public function getUnidadesDefectuosas()
		{
		    return $this->unidadesDefectuosas;
		}
		
		public function setUnidadesDefectuosas($unidadesDefectuosas)
		{
		    $this->unidadesDefectuosas = $unidadesDefectuosas;
		    return $this;
		}

		public function getReposicion()
		{
		    return $this->reposicion;
		}
		
		public function setReposicion($reposicion)
		{
		    $this->reposicion = $reposicion;
		    return $this;
		}



	}




 ?>