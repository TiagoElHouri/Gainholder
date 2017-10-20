<?php

	/*******************************************************
	* GETERS E SETERS - TABELA {NIVEL}
	*********************************************************/

	class Nivel{

		private $id;
		private $nome;

		public function __construct($id=-1){
			$this->id = $id;
		}	

		public function setId($id){
			$this->id = $id;
		}	

		public function getId(){
			return $this->id;
		}

		public function setNome($nome){
			$this->nome = $nome;
		}

		public function getNome(){
			return $this->nome;
		}
	}

?>