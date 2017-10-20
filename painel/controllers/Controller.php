<?php  

/*****************************************
* CONTROLLER COM OS PRINCIPAIS MÉTODO QUE HAVERÁ EM TODOS OS 
* CONTROLLERS RESTANTES
* ***************************************/

abstract class Controller{

	private   $modulo;
	private   $paginasPermitidas = array();
	protected $limite;
	protected $colunas;
 	protected $ordenacao;
 	protected $tabela;

 	public function iniciaTabela(){
 		$this->tabela = new Tabela();
 	}

	public function setModulo($modulo){

		$this->modulo = $modulo;
	}

	public function setPaginasPermitidas(Permissions $permissao){

	    $paginas = $permissao->makeMenu(); 

	    if($paginas != null){
	    	
	    	$this->iniciaTabela();

	    	foreach ($paginas as $pagina){

	    		if(is_object($pagina)):

	    			array_push($this->paginasPermitidas, $pagina->getUrl());
	    		else:

	    			array_push($this->paginasPermitidas,"administradores");
	    		endif;
	    	}
	    }
	}

	protected function loadView($view, array $dados){

		if(file_exists('views/'.$this->modulo.'/'.$view)){

			extract($dados);
			include_once('views/'.$this->modulo.'/'.$view);
		}else{

			errorPage(ERROR_PAGE_NOT_FOUND); 
			exit;
		}
	}

	protected function verifyPermissionPage(){

		$sessao = isset($_SESSION['ADMIN']) ? $_SESSION['ADMIN']['PERMISSOES'] :  null ;

		if($sessao != null){

			if (in_array($this->modulo, $this->paginasPermitidas)) {

				$acesso = true;
			}else{

				$acesso = false;
			}
		}else{

			$acesso = false;
		}

		return $acesso;
	}

	public function buscar(){

		$campos = substr($_GET['pag'], strpos($_GET['pag'], "buscar/")+7);
		$urlPg  = substr($campos,0, strrpos($campos, "/"));
		$campos = explode('/', $campos);

		if(count($this->colunas) == count($campos)):
			
			$where = "";
			$busca = "";

			for($i=0; $i<=count($this->colunas); $i++):

				if(!empty($this->colunas[$i]) AND $campos[$i] != "indefinido"):

					$where = " WHERE ";
					
					$novaString = trim(mb_ereg_replace("'", "", $campos[$i]));
					$busca     .= $this->colunas[$i]." LIKE '%".$novaString ."%'";

					if(!empty($this->colunas[$i+1]) AND $campos[$i+1] != "indefinido"):

						$busca .= " OR ";	
					endif;

				endif;

			endfor;

			$busca   .= $this->ordenacao;
			$pg       = $campos[(count($campos)-1)];
			$inicio   = ($pg * $this->limite) - $this->limite;
			$limite   = " LIMIT $inicio, ".$this->limite;
			$sqlBusca = $where.$busca.$limite;
			
			return array('busca' => $sqlBusca, 'condicaoPaginacao' => $where.$busca, 'indicePaginacao' => $pg, 'paginaAtual' => $urlPg);

		else:

			errorPage(ERROR_SEARCH_FORMAT);
			exit;
		endif;
	}
}

?>