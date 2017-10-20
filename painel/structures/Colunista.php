<?php  

/*******************************************************
* GETERS E SETERS - TABELA {COLUNISTAS}
*********************************************************/

class Colunista{

	private $id;
	private $id_login;
	private $nome_completo;
	private $foto_perfil;
	private $descricao;
	private $status;
	private $tipo;

	public function __construct($id=-1){
		$this->id = $id;
	}	

	public function setId($id){
		$this->id = $id;
	}	

	public function getId(){
		return $this->id;
	}	
	
	public function setLogin($idLogin Login){
		$this->id_login = $idLogin;
	}

	public function getLogin(){
		return $this->id_login;
	}

	public function setNomeCompleto($nomeCompleto){
		$this->nome_completo = $nomeCompleto;
	}

	public function getNomeCompleto(){
		return $this->nome_completo;
	}

	public function setFotoPerfil($fotoPerfil){
		$this->foto_perfil = $fotoPerfil; 
	}

	public function getFotoPerfil(){
		return $this->foto_perfi;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setTtipo($tipo){
		$this->tipo = $tipo;
	}

	public function getTipo(){
		return $this->tipo;
	}
}

?>