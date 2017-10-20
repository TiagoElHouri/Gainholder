<?php  

/*******************************************************
* GETERS E SETERS - TABELA {MODULOS}
*********************************************************/

class Modulos{

	private $id;
	private $nome;
	private $url;
	private $idPai;
	private $icone;
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

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setUrl($url){
		$this->url = $url;
	}

	public function getUrl(){
		return $this->url;
	}

	public function setIdPai($idPai){
		$this->idPai = $idPai;
	}

	public function getIdPai(){
		return $this->idPai;
	}

	public function setIcone($icone){
		$this->icone = $icone;
	}

	public function getIcone(){
		return $this->icone;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		return $this->status;
	}


}

?>