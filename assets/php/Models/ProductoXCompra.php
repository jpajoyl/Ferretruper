<?php 

	/**
	 * 
	 */
	class ProductoXCompra {
		

		//atributtos
		private $precioCompra;
		private $numeroUnidades;
		private $descuentoProducto;
		//idk
		private $compra;
		private $proveedor;
		private $producto;

		//get & set
		public function getPrecioCompra()
		{
		    return $this->precioCompra;
		}
		
		public function setPrecioCompra($precioCompra)
		{
		    $this->precioCompra = $precioCompra;
		    return $this;
		}

		public function getNumeroUnidades()
		{
		    return $this->numeroUnidades;
		}
		
		public function setNumeroUnidades($numeroUnidades)
		{
		    $this->numeroUnidades = $numeroUnidades;
		    return $this;
		}

		public function getDescuentoProducto()
		{
		    return $this->descuentoProducto;
		}
		
		public function setDescuentoProducto($descuentoProducto)
		{
		    $this->descuentoProducto = $descuentoProducto;
		    return $this;
		}

	}


	//Ver todos productos por compra jajjajajajajja jueputa 


 ?>