<?php 

	/*******************************************************
	* GETERS E SETERS - TABELA {EXEMPLO}
	*********************************************************/

	class Exemplo{

		private $id;
		private $campo1;
		private $campo2;
		private $campo3;
		private $campo4;

		public function __construct($id=-1){
			$this->id = $id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

		public function setCampo1($campo1){
			$this->campo1 = $campo1;
		}

		public function getCampo1(){
			return $this->campo1;
		}

		public function setCampo2($campo2){
			$this->campo2 = $campo2;
		}

		public function getCampo2(){
			return $this->campo2;
		}

		public function setCampo3($campo3){
			$this->campo3 = $campo3;
		}

		public function getCampo3(){
			return $this->campo3;
		}

		public function setCampo4($campo4){
			$this->campo4 = $campo4;
		}

		public function getCampo4(){
			return $this->campo4;
		}
	}

?>