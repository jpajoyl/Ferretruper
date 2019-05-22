<?php 
/**
 * 
 */
class Inventario {
	
	private $idInventario;
	private $producto;
	private $precioInventario;
	private $unidades;
	private $unidadesDefectuosas;
	private $valorUtilidad;
	private $proveedor;
	private $precioCompra;

	public function __construct(){
		$params = func_get_args();
		$num_params = func_num_args();
		if($num_params>0){
			call_user_func_array(array($this,"__construct0"),$params);
		}
	}

	public function __construct0($precioInventario, $precioCompra, $unidades, $unidadesDefectuosas, $id_producto, $id_proveedor,$valorUtilidad){
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("INSERT INTO `inventario` (`id_inventario`, `precio_inventario`, `precio_compra`, `unidades`, `unidades_defectuosas`, `valor_utilidad`, `productos_id_producto`, `usuarios_id_usuario`) VALUES (NULL, :precioInventario, :precioCompra,:unidades, :unidadesDefectuosas,:valorUtilidad, :id_producto, :id_proveedor)");

		$this->setPrecioInventario($precioInventario,$statement);
		$this->setUnidades($unidades,$statement);
		$this->setUnidadesDefectuosas($unidadesDefectuosas,$statement);
		$this->setProducto($id_producto,$statement);
		$this->setProveedor($id_proveedor,$statement);
		$this->setValorUtilidad($valorUtilidad,$statement);
		$this->setPrecioCompra($precioCompra,$statement);
		$statement->execute();
		if(!$statement){
			throw new Exception("Error Processing Request", 1);
		}
		$this->setIdInventario($conexion->lastInsertId());
		$conexion = NULL;
		$statement = NULL;
	}

// get && set
	public function getProveedor()
	{
	    return $this->proveedor;
	}
	
	public function setProveedor($id_proveedor, $statement=NULL)
	{
		if($statement!=NULL){
			$statement->bindParam(':id_proveedor',$id_proveedor,PDO::PARAM_INT);
		}
		$this->proveedor = Proveedor::obtenerProveedor($id_proveedor,false);

	}
	public function getIdInventario(){
		return $this->idInventario;
	}

	public function setIdInventario($idInventario, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':idInventario',$idInventario,PDO::PARAM_INT);
		}
		$this->idInventario = $idInventario;

	}

	public function getProducto(){
		return $this->producto;
	}

	public function setProducto($id_producto, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':id_producto',$id_producto,PDO::PARAM_INT);
		}
		$this->producto = Producto::obtenerProducto($id_producto);

	}

	public function getPrecioInventario(){
		return $this->precioInventario;
	}

	public function setPrecioInventario($precioInventario, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':precioInventario',$precioInventario,PDO::PARAM_INT);
		}
		$this->precioInventario = $precioInventario;

	}

	public function getPrecioCompra(){
		return $this->precioCompra;
	}

	public function setPrecioCompra($precioCompra, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':precioCompra',$precioCompra,PDO::PARAM_INT);
		}
		$this->precioCompra = $precioCompra;

	}

	public function getUnidades(){
		return $this->unidades;
	}

	public function setUnidades($unidades, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':unidades',$unidades,PDO::PARAM_INT);
		}
		$this->unidades = $unidades;

		
	}

	public function getUnidadesDefectuosas(){
		return $this->unidadesDefectuosas;
	}

	public function setUnidadesDefectuosas($unidadesDefectuosas, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':unidadesDefectuosas',$unidadesDefectuosas,PDO::PARAM_INT);
		}
		$this->unidadesDefectuosas = $unidadesDefectuosas;

	}

	public function getValorUtilidad(){
		return $this->valorUtilidad;
	}

	public function setValorUtilidad($valorUtilidad, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':valorUtilidad',$valorUtilidad,PDO::PARAM_INT);
		}
		$this->valorUtilidad = $valorUtilidad;

	}


	public static function obtenerInventario($numeroDeConsulta, $id_usuario=-1, $modo=false){
		//idProducto->True, idInventario->False
		$conexion = Conexion::conectar();
		if ($modo) {
			$statement = $conexion->prepare("SELECT * FROM `inventario` WHERE `productos_id_producto` = :numeroDeConsulta and `usuarios_id_usuario` = :id_usuario");
			$statement->bindValue(":id_usuario", $id_usuario);
		}else{
			$statement = $conexion->prepare("SELECT * FROM `inventario` WHERE  `id_inventario` = :numeroDeConsulta");
		}
		
		$statement->bindValue(":numeroDeConsulta", $numeroDeConsulta);
		$statement->execute();
		$resultado = $statement->fetch(PDO::FETCH_ASSOC);
		if($resultado!=false){	
			$inventario = new Inventario();
			$inventario->setIdInventario($resultado['id_inventario']);
			$inventario->setProducto($resultado['productos_id_producto']);
			$inventario->setPrecioInventario($resultado['precio_inventario']);
			$inventario->setUnidades($resultado['unidades']);
			$inventario->setUnidadesDefectuosas($resultado['unidades_defectuosas']);
			$inventario->setValorUtilidad($resultado['valor_utilidad']);
			$inventario->setPrecioCompra($resultado['precio_compra']);
			$inventario->setProveedor($resultado['usuarios_id_usuario']);
			$conexion=null;
			$statement=null;
			return $inventario;
		}else{
			return false;
		}

	}
	public static function obtenerInventarios($numeroDeConsulta, $modo=true)
	{//true->>busca por idProducto     //false busca por idProveedor
		$conexion = Conexion::conectar();
		if ($modo) {
			$statement = $conexion->prepare("SELECT * FROM `inventario` WHERE `productos_id_producto` = :idProducto");
			$statement->bindValue(":idProducto", $numeroDeConsulta);
		}else{
			$statement = $conexion->prepare("SELECT * FROM `inventario` WHERE `usuarios_id_usuario` = :idProveedor");
			$statement->bindValue(":idProveedor", $numeroDeConsulta);
		}
		$statement->execute();
		$conexion=null;
		return $statement;
	}


	public static function obtenerInventariosConProveedor($numeroDeConsulta, $modo=true)
	{//true->>busca por idProducto     //false busca por idProveedor
		$conexion = Conexion::conectar();
		if ($modo) {
			$statement = $conexion->prepare("SELECT * FROM `inventario` INNER JOIN `usuarios` ON inventario.usuarios_id_usuario = usuarios.id_usuario WHERE inventario.productos_id_producto = :idProducto");
			$statement->bindValue(":idProducto", $numeroDeConsulta);
		}else{
			$statement = $conexion->prepare("SELECT * FROM `inventario` INNER JOIN `usuarios` ON inventario.usuarios_id_usuario = usuarios.id_usuario WHERE inventario.usuarios_id_usuario = :idProveedor");
			$statement->bindValue(":idProveedor", $numeroDeConsulta);
		}
		$statement->execute();
		$conexion=null;
		return $statement;
	}
	//"

		public static function obtenerInventariosParaVenta($numeroDeConsulta, $modo=true)
	{//true->>busca por idProducto     //false busca por idProveedor
		$conexion = Conexion::conectar();
		if ($modo) {
			$statement = $conexion->prepare("SELECT * FROM `inventario` WHERE `productos_id_producto` = $numeroDeConsulta AND `unidades` > 0 ORDER BY `inventario`.`precio_inventario` DESC");
		}else{
			$statement = $conexion->prepare("SELECT * FROM `inventario` WHERE `usuarios_id_usuario` = $numeroDeConsulta AND `unidades` > 0 ORDER BY `inventario`.`precio_inventario` DESC");
		}
		$statement->execute();
		$conexion=null;
		return $statement;
	}

	public function cambiarPrecio($dato,$modo= true){   //modo = True  PrecioInventario -- modo = False ValorUtilidad
		$conexion = Conexion::conectar();
		$statement=$conexion->prepare("UPDATE `inventario` SET `precio_inventario`=:precioInventario,`valor_utilidad`=:valorUtilidad WHERE `id_inventario` = :idInventario");
		$statement->bindValue(":idInventario", $this->getIdInventario());
		if($modo){
			$nuevaUtilidad = (($dato-$this->getPrecioCompra())/($this->getPrecioCompra()))*100;
			$statement->bindValue(":valorUtilidad", $nuevaUtilidad);
			$statement->bindValue(":precioInventario", $dato);
		}else{
			$nuevoPrecioInventario = (($this->getPrecioCompra()*$dato)/100) + $this->getPrecioCompra();
			$statement->bindValue(":valorUtilidad", $dato);
			$statement->bindValue(":precioInventario", $nuevoPrecioInventario);
		}
		$statement->execute();
		$conexion=null;
		if($statement){
			return SUCCESS;
		}else{
			return ERROR;
		}
	}

	public function eliminarInventario(){
		$idInventario = $this->getIdInventario();
		$conexion = Conexion::conectar();
		$statement="DELETE FROM `inventario` WHERE `id_inventario` = :idInventario";
		$statement->bindValue(":idInventario", $idInventario);
		$statement->execute();
		if($statement){
			$conexion=null;
	    	$statement=null;
			return true;
		}else {
			$conexion=null;
	    	$statement=null;
			return false;
		}
	}






}






?>