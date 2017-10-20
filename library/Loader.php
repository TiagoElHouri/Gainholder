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

				'usuarios' => array(
					'url'        => 'perfil.php',
					'controller' => 'usuarioSite',
					'nicknames'  => array('perfil')
				),
				'logout' => array(
					'url' => '',
					'controller' => '',
					'nicknames'  => ''
				)
			);

			return $paginas;
		}

		public function getControllerPage($acao = false){

			if(!empty($this->modulo)){

				$paginas = $this->listaPaginasPermitidas();
				$modulo  = $this->transformaUrl();

				$subPagina       = 2;
				$paginaPrincipal = '';

				// UTILIZADO PARA VERIFICAR NICKNAMES
				foreach ($paginas as $pagina) {

					// VERIFICA SE PARA A PÁGINA ATUAL EXISTEM O NICKNAME
					if(is_array($pagina['nicknames'])){

						$subPagina     = in_array($modulo['modulo'], $pagina['nicknames']);

						// VERIFICA PARA O PÁGINA PRINCIPAL ATUAL, SE EXISTE A PÁGINA COM NICKNAME REQUERIDA VIA URL
						if($subPagina){

							prev($paginas); // PONTEIRO RETORNA A PÁGINA PRINCIPAL ANÁLISADA
							$paginaPrincipal = key($paginas); // NOME DA PÁGINA PRINCIPAL
							$controller 	 = $pagina['controller']; // CONTROLLER DA PÁGINA PRINCIPAL. DEVE SER COMPÁTIVEL PARA AS DEMAIS PÁGINAS RENOMEADAS
						}
					}
				}

				if(isset($paginas[$modulo['modulo']])){

					if(!$acao){

						$resultado = $paginas[$modulo['modulo']]['controller'];
					}else{

						$resultado['controller'] = $paginas[$modulo['modulo']]['controller'];
						$resultado['acao']       = $modulo['acao'];

						if(isset($modulo['id'])){

							$resultado['id'] = $modulo['id'];
						}
					}

				// VERIFICAÇÃO DE SUBPÁGINAS É REALIZADA EM CADA PÁGINA PRINCIPAL
				}elseif($subPagina){

					$resultado['controller'] = $controller;
					$resultado['acao']       = $modulo['acao'];

					if(isset($modulo['id'])){

						$resultado['id'] = $modulo['id'];
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

			$subPagina       = 2;
			$subPaginaNome   = '';
			$paginaPrincipal = '';

			foreach ($paginas as $pagina) {

				if(is_array($pagina['nicknames'])){

					$subPagina = in_array($modulo['modulo'], $pagina['nicknames']);

					if($subPagina){

						prev($paginas);
						$paginaPrincipal = key($paginas);
						$subPaginaNome   = $pagina['nicknames'][array_search($modulo['modulo'], $pagina['nicknames'])];
					}
				}
			}

			if(isset($paginas[$modulo['modulo']])){

				if($modulo['modulo'] != 'logout'){

					if(file_exists('views/'.$modulo['modulo'])){

						include('views/template/view.php');
					}else{

						errorPage(ERROR_PAGE_NOT_FOUND);
					}
				}else{

					$this->logout();
				}

			// VERIFICAÇÃO DE SUBPÁGINAS É REALIZADA EM CADA PÁGINA PRINCIPAL
			}elseif ($subPagina) {

				if($subPaginaNome != 'logout'){

					if(file_exists('views/'.$paginaPrincipal.'/'.$subPaginaNome.'.php')){

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

				$acao   = explode('/', $this->modulo);
				$modulo = array('modulo' => $acao[0], 'acao' => $acao[1]);

				if(isset($acao[2])){

					$modulo['id'] = $acao[2]; 
				}
			}else{

				$modulo = array('modulo' => $this->modulo, 'acao' => '');
			}

			return $modulo;
		}

		private function logout(){

			unset($_SESSION['USER']);
			echo "<script>window.location='".URL_SITE.''."'</script>";
		}
	}

?>