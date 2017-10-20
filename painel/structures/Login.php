<?php  

/*******************************************************
* GETERS E SETERS - TABELA {LOGIN}
*********************************************************/

class Login{

	private $id;
	private $email;
	private $senha;
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

	public function setEmail($email){
		$this->email = $email;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setSenha($senha){
		$this->senha = $senha;
	}

	public function getSenha(){
		return $this->senha;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		return $this->status;
	}

}

?>