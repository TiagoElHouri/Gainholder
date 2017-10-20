<?php  

/*******************************************************
* GETERS E SETERS - TABELA {USUÁRIO NÍVEL ADMINISTRADOR}
*********************************************************/

class Administrador{

	private $id;
	private $id_login;
	private $foto_perfil;
	private $nome_completo;
	private $status;
	private $tipo;
	private $permissoes;

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

	public function setFotoPerfil($fotoPerfil){
		$this->foto_perfil = $fotoPerfil;
	}

	public function getFotoPerfil(){
		return $this->foto_perfil;
	}

	public function setNomeCompleto($nomeCompleto){
		$this->nome_completo = $nomeCompleto;
	}

	public function getNomeCompleto(){
		return $this->nome_completo;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setPermissoes($permissoes Permissoes){
		$this->permissoes = $permissoes;
	}

	public function getPermissoes(){
		return $this->permissoes;
	}
}

?>