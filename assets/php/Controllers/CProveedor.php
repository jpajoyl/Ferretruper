<?php 
	if(!isset($include)){
		include_once '../Conexion.php';
		include_once 'SesionEmpleado.php';
		include_once '../Models/Usuario.php';
		include_once '../Models/Proveedor.php';
		$objectSession =new SesionEmpleado();
		$method = isset($_GET['method'])?$_GET['method']:"";
	}
	include_once 'Response.php';	
	if($method!="" && $objectSession->getEmpleadoActual()!=null){
		if(!strcmp($method,"verProveedores")){
			$listaProveedores=Proveedor::verProveedores();
			if($listaProveedores->rowCount()>0){
				while ($proveedor = $listaProveedores->fetch(PDO::FETCH_ASSOC)) {
					$array['data'][]=$proveedor;
				}
				echo json_encode($array);
			}else{
				echo NOT_FOUND;
			}
		}else if(!strcmp($method,"registrarProveedor")){
			$nit=$_POST['nit'];
			$digitoDeVerificacion=$_POST['digitoDeVerificacion'];
			$nombre=$_POST['nombre'];
			$direccion=$_POST['direccion'];
			$ciudad=$_POST['ciudad'];
			$email=$_POST['email'];
			$telefono=$_POST['telefono'];
			$celular=$_POST['celular'];
			$clasificacion=$_POST['clasificacion'];

			if(Proveedor::obtenerProveedor($nit)==false){
				try{
					$proveedor = new Proveedor("nit", $nit, $nombre, $direccion, $ciudad, $telefono, $clasificacion, $digitoDeVerificacion, $email, $celular);
					echo SUCCESS;
				}catch(Exception $e){
					echo ERROR;
				}
			}else{
				echo ALREADY_EXIST;
			}
			
		}else if(!strcmp($method,"editarProveedor")){
			$nit=$_POST['nit'];
			$digitoDeVerificacion=$_POST['digitoDeVerificacion'];
			$nombre=$_POST['nombre'];
			$direccion=$_POST['direccion'];
			$ciudad=$_POST['ciudad'];
			$email=$_POST['email'];
			$telefono=$_POST['telefono'];
			$celular=$_POST['celular'];
			$clasificacion=$_POST['clasificacion'];

			$proveedor=Proveedor::obtenerProveedor($nit);
			if($proveedor!=false){
				$id_usuario=$proveedor->getIdUsuario();
				$proveedor->actualizarUsuario($id_usuario, $nombre, $direccion, $ciudad, $telefono, $clasificacion, $digitoDeVerificacion, $email, $celular);
				if($proveedor){
					echo SUCCESS;
				}else{
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
			
		}else if(!strcmp($method,"desactivarProveedor")){
			$nit=$_POST['nit'];
			$proveedor=Proveedor::obtenerProveedor($nit);
			if($proveedor!=false){
				$proveedor->desactivarUsuario();
				if($proveedor){
					echo SUCCESS;
				}else{
					echo ERROR;
				}
			}else{
				echo NOT_FOUND;
			}
		}else if(!strcmp($method,"verProveedor")){
			if(isset($id)){
				$proveedor=Proveedor::obtenerProveedor($id,false);
				if($proveedor!=false){
					$servletRequest->setAtribute("proveedor",$proveedor);
				}else{
					$servletRequest->setAtribute("proveedor",null);
				}
			}else{
				echo NOT_FOUND;
			}
		}else if(!strcmp($method,"productosProveedor")){
			$idProveedor=$_POST['idProveedor'];
			$proveedor=Proveedor::obtenerProveedor($idProveedor,false);
			$listaProductos=$proveedor->verProductoPorProveedor();
			if($listaProductos->rowCount()>0){
				while ($producto = $listaProductos->fetch(PDO::FETCH_ASSOC)) {
					$array['data'][]=$producto;
				}
				echo json_encode($array);
			}else{
				echo NOT_FOUND;
			}
		}else if(!strcmp($method,"buscarNombreONit")){
			$valor=$_POST['valor'];
			$statement=Proveedor::buscarProveedorXNombreONit($valor);
			if($statement!=false){
				$data=array();
				while ($proveedor = $statement->fetch(PDO::FETCH_ASSOC)){
					$data['info'][]=$proveedor;
				}	
				echo json_encode($data);
			}else{
				echo NOT_FOUND;
			}
		}

	}

 ?>