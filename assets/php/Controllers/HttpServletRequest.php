<?php 
	class HttpServletRequest{
		public function __construct(){

		}
		public function setAtribute($variable,$valor){
			$this->$variable=$valor;
		}
		public function getAtribute($variable){
			if(isset($this->$variable)){
				return $this->$variable;
			}else{
				return false;
			}
		}
	}
 ?>
