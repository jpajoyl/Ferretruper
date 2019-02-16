<?php 
	include_once '../Conexion.php';
	include_once 'SesionEmpleado.php';
	include_once '../Models/Inventario.php';
	include_once '../Models/Usuario.php';
	include_once '../Models/Proveedor.php';
	include_once '../Models/Producto.php';
	include_once '../Models/Compra.php';
	include_once '../Models/ProductoXCompra.php';
	echo json_encode(Producto::verProductos($_GET));
 ?>