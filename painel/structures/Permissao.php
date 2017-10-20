<?php  

/*******************************************************
* GETERS E SETERS - TABELA {PERMISSÕES}
*********************************************************/

class Permissao{

	private $id_permissao;
	private $id_login;
	private $id_modulo;
	private $status;

	public function __construct($id=-1){
		$this->id = $id;
	}	

	public function setId($id){
		$this->id = $id;
	}	

	public function getId(){
		return $this->id;
	}

	public function setIdLogin($idLogin Login){
		$this->id_login = $idLogin;
	}

	public function getIdLogin(){
		return $this->id_login;
	}

	public function setIdModulo($idModulo Modulos){
		$this->id_modulo = $idModulo;
	}

	public function getIdModulo(){
		return $this->id_modulo;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		return $this->status;
	}


}

?>