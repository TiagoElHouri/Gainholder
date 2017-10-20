<?php  

/*******************************************************
* GETERS E SETERS - TABELA {CONTEÚDOS}
*********************************************************/

class Conteudo{

	private $id;
	private $id_categoria;
	private $banner;
	private $titulo;
	private $texto;
	private $data_publicacao;
	private $status;
	private $tipo;
	private $id_autor;
	private $nivel;

	
	public function __construct($id=-1){
		$this->id = $id;
	}	

	public function setId($id){
		$this->id = $id;
	}	

	public function getId(){
		return $this->id;
	}

	public function setCategoria($idCategoria Categoria){
		$this->id_categoria = $idCategoria;
	}

	public function getCategoria(){
		return $this->id_categoria;
	}

	public function setBanner($banner){
		$this->banner = $bannner;
	}

	public function getBanner(){
		return $this->banner;
	}

	public function setTitulo($titulo){
		$this->titulo = $titulo;
	}

	public function getTitulo(){
		return $this->titulo;
	}

	public function setTexto($texto){
		$this->texto = $texto;
	}

	public function getTexto(){
		return $this->texto;
	}

	public function setDataPublicacao($dataPublicacao){
		$this->dataPublicacao = $dataPublicacao;
	}

	public function getDataPublicacao(){
		return $this->dataPublicacao;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function setAutor($idAutor Colunista){
		$this->id_autor = $idAutor;
	}	

	public function getAutor(){
		return $this->id_autor;
	}

	public function setNivel($nivel){
		$this->nivel = $nivel;
	}

	public function getNivel(){
		return $this->nivel;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		return $this->status;
	}


}

?>