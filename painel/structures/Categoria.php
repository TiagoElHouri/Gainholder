<?php  

/*******************************************************
* GETERS E SETERS - TABELA {CATEGORIAS}
*********************************************************/

class Categoria{

	private $id;
	private $nome;
	private $slug;
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

	public function setSlug($slug){
		$this->slug = $slug;
	}

	public function getSlug(){
		return $this->slug;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		return $this->status;
	}


}

?>