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
	private $valorUtilitad;
	private $proveedor;
	private $precioCompra;

	public function __construct(){
		$params = func_get_args();
		$num_params = func_num_args();
		if($num_params>0){
			call_user_func_array(array($this,"__construct0"),$params);
		}
	}

	public function __construct0($precio, $unidades, $unidadesDefectuosas, $producto, $proveedor,$valorUtilidad){
		$conexion = Conexion::conectar();
		$statement = $conexion->prepare("INSERT INTO `inventario` (`id_inventario`, `precio`, `unidades`, `unidades_defectuosas`, `valor_utilidad`, `productos_id_producto`, `usuarios_id_usuario`) VALUES (NULL, :precio, :unidades, :unidadesDefectuosas,:valorUtilidad, :producto, :proveedor)");

		$this->setPrecio($precio,$statement);
		$this->setUnidades($unidades,$statement);
		$this->setUnidadesDefectuosas($unidadesDefectuosas,$statement);
		$this->setProducto($producto,$statement);
		$this->setProveedor($proveedor,$statement);
		$this->setValorUtilidad($valorUtilidad,$statement)
		$statement->execute();
		if(!$statement){
			throw new Exception("Error Processing Request", 1);
		}
		$conexion = NULL;
		$statement = NULL;
	}

// get && set
	public function getProveedor()
	{
	    return $this->proveedor;
	}
	
	public function setProveedor($proveedor, $statement=NULL)
	{
		if($statement!=NULL){
			$statement->bindParam(':proveedor',$proveedor,PDO::PARAM_INT);
		}
		$this->proveedor = $proveedor;
		return $this;
	}
	public function getIdInventario(){
		return $this->idInventario;
	}

	public function setIdInventario($idInventario, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':idInventario',$idInventario,PDO::PARAM_INT);
		}
		$this->idInventario = $idInventario;
		return $this;
	}

	public function getProducto(){
		return $this->producto;
	}

	public function setProducto($producto, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':producto',$producto,PDO::PARAM_INT);
		}
		$this->producto = $producto;
		return $this;
	}

	public function getPrecio(){
		return $this->precio;
	}

	public function setPrecio($precio, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':precio',$precio,PDO::PARAM_INT);
		}
		$this->precio = $precio;
		return $this;
	}

	public function getUnidades(){
		return $this->unidades;
	}

	public function setUnidades($unidades, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':unidades',$unidades,PDO::PARAM_INT);
		}
		$this->unidades = $unidades;
		return $this;
		
	}

	public function getUnidadesDefectuosas(){
		return $this->unidadesDefectuosas;
	}

	public function setUnidadesDefectuosas($unidadesDefectuosas, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':unidadesDefectuosas',$unidadesDefectuosas,PDO::PARAM_INT);
		}
		$this->unidadesDefectuosas = $unidadesDefectuosas;
		return $this;
	}

	public function getValorUtilidad(){
		return $this->valorUtilitad;
	}

	public function setValorUtilidad($valorUtilitad, $statement=NULL){
		if($statement!=NULL){
			$statement->bindParam(':valorUtilitad',$valorUtilitad,PDO::PARAM_INT);
		}
		$this->valorUtilitad = $valorUtilitad;
		return $this;
	}

	public static function obtenerInventario($numeroDeConsulta, $id_usuario=-1, $modo=false){
		//idProducto->True, idInventario->False
		$conexion = Conexion::conectar();
		if ($modo) {
			$statement = $conexion->prepare("SELECT * FROM `inventario` WHERE  `PRODUCTOS_id_producto` = :numeroDeConsulta and `usuarios_id_usuario` = :id_usuario");
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
			$inventario->setProducto($resultado['PRODUCTOS_id_producto']);
			$inventario->setPrecio($resultado['precio']);
			$inventario->setUnidades($resultado['unidades']);
			$inventario->setUnidadesDefectuosas($resultado['unidades_defectuosas']);
			$inventario->setValorUtilidad($resultado['valor_utilidad'])
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
			$statement = $conexion->prepare("SELECT * FROM `inventario` WHERE productos_id_producto = $numeroDeConsulta");
		}else{
			$statement = $conexion->prepare("SELECT * FROM `inventario` WHERE usuarios_id_usuario = $numeroDeConsulta");
		}
		$statement->execute();
		$conexion=null;
		return $statement;
	}





}




?>