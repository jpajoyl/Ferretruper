<?php 

	/**
	 * 
	 */
	class Conexion {



		public static function conectar(){

			
			try {
				$options = [
					PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_EMULATE_PREPARES=>false,


				];
				$conexion= new PDO("mysql:host=localhost;dbname=ferretruperbd2", "root", "", $options);
				$conexion->exec("SET CHARACTER SET utf8");
				return $conexion;



			} catch (Exception $e) {
				die($e->getMessage());
			}
		}
	}
?>