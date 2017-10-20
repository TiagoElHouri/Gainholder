<?php 

/*************************************
* CARREGAMENTO DAS PÁGINAS
**************************************/

class Loader{

	private $modulo;

	public function __construct($modulo){
		$this->modulo = $modulo;
	}

	private function listaPaginasPermitidas(){

		$paginas = array(

			'administradores' => array(
				'url'        => 'administradores/lista.php',
				'controller' => 'administrador'
			),

			'usuarios' => array(
				'url'        => 'usuarios/lista.php',
				'controller' => 'usuario'
			),

			'colunistas' => array(
				'url'  => 'colunistas/lista.php',
				'controller' => 'colunista'
			),

			'conteudos' => array(
				'url' => 'conteudos/lista.php',
				'controller' => 'conteudo'
			),

			'artigos' => array(
				'url' => 'artigos/lista.php',
				'controller' => 'artigo'
			),

			'solucoes' => array(
				'url' => 'solucoes/lista.php',
				'controller' => 'solucao'
			),

			'categorias' => array(
				'url' => 'categorias/lista.php',
				'controller' => 'categoria'
			),

			'logout' => array(
				'url' => '',
			)

		);

		return $paginas;
	}

	public function getControllerPage($acao = false){

		if(!empty($this->modulo)){
			$paginas = $this->listaPaginasPermitidas();
			$modulo  = $this->transformaUrl();

			if(isset($paginas[$modulo['modulo']])){

				if(!$acao){

					$resultado = $paginas[$modulo['modulo']]['controller'];
				}else{

					$resultado['controller'] = $paginas[$modulo['modulo']]['controller'];
					$resultado['acao']       = $modulo['acao'];

					if(isset($modulo['id'])){

						$resultado['id'] = $modulo['id'];
					}

					if(isset($modulo['pagina'])){
						$resultado['pagina'] = $modulo['pagina'];
					}

					if(isset($modulo['adicional'])){
						$resultado['adicional'] = $modulo['adicional'];
					}
				}
			}else{

				$resultado = null;
			}
		}else{

			$resultado = null;
		}

		return $resultado;
	}

	public function redirecionar(){
		$paginas = $this->listaPaginasPermitidas();
		$modulo  = $this->transformaUrl();

		if(isset($paginas[$modulo['modulo']])){

			if($modulo['modulo'] != 'logout'){				
				if(file_exists('views/'.$modulo['modulo'].'/lista.php')){
					include('views/template/view.php');
				}else{
					errorPage(ERROR_PAGE_NOT_FOUND);    
				}
			}else{
				$this->logout();
			}

		}else{
			errorPage(ERROR_CLASS_NOT_FOUND);    
		}
	}

	private function transformaUrl(){
		if(strstr($this->modulo,'/')){
			$acao = explode('/', $this->modulo);
			$modulo = array('modulo' => $acao[0], 'acao' => $acao[1]);
			
			if(isset($acao[2])){
				$modulo['id'] = $acao[2]; 
			}

			if(isset($acao[3])){
				$modulo['pagina'] = $acao[3];
			}

			if(isset($acao[4])){
				$modulo['adicional'] = $acao[4];
			}
			
		}else{
			$modulo = array('modulo' => $this->modulo, 'acao' => '');
		}

		return $modulo;
	}

	private function logout(){
		unset($_SESSION['ADMIN']);
		echo "<script>window.location='".URL.''."'</script>";
	}
}

?>