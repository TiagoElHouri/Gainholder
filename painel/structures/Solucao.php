<?php  

/*******************************************************
* GETERS E SETERS - TABELA {SOLUÇÕES}
*********************************************************/

class Solucao{

	private $id;
	private $id_categoria;
	private $banner;
	private $banner_titulo;
	private $banner_descricao;
	private $titulo;
	private $texto;
	private $status;
	private $tipo;
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

	public function setBannerTitulo($bannerTitulo){
		$this->banner_titulo = $bannerTitulo;
	}

	public function getBannerTitulo(){
		return $this->banner_titulo;
	}

	public function setBannerDescricao($bannerDescricao){
		$this->banner_descricao = $bannerDescricao;
	}

	public function getBannerDescricao(){
		return $this->banner_descricao;
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

	public function setNivel($nivel){
		$this->nivel = $nivel;
	}

	public function getNivel(){
		return $this->nivel;
	}

}

?>