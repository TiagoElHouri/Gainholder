<?php

	/**************************************
	* CONTROLLER EXEMPLO
	**************************************/

	class ExemploControl extends Controller{

		private $exemploModel;
		private $moduloModel;

		public $caminhoImagensCampo4

		public function __construct($acesso = "cms"){

			// SETANDO O MÓDULO
			$this->setModulo('exemplos');

			$permission = new Permissions();
			$this->setPaginasPermitidas($permission);

			if($this->verifyPermissionPage() || $acesso == "api" || $acesso == "site"){

				// CARREGANDO A MODEL PRINCIPAL
				$this->exemploModel   = new ExemploModel();
				$this->limite         = 10;
				$this->caminhoImagensCampo4 = "exemplos_campo4";
			}else{

				errorPage(ERROR_PERMISSION_PAGE);
				exit;
			}
		}

		//CARREGA A VIEW PRINCIPAL DO EXEMPLO
		public function index($pg = 1){

			$dados['pg']       = $pg;
			$dados['limite']   = $this->limite;
			$dados['condicao'] = "";
			$dados['url']      = URL.'exemplos/index/';
			$dados['exemplos'] = $this->listExemplos($pg);
			$this->loadView('lista.php',$dados);
		}

		// CARREGA QUAL MÉTODO IRÁ RECEBER A REQUISIÇÃO AJAX
		public function loadMethod($acao, $id){

			if($acao != null AND $id != null){

				switch($acao):

					case 'delete':
						$id = isset($_GET['id']) ? $_GET['id'] : '';
						$this->delete($id);
					break;

				endswitch;
			}
		}

		// INSERIR EXEMPLO
		//TRATA OS DADOS PARA SEREM INSERIDOS NO BANCO
		public function cadastrar(){

			$resultado['title']     = 'Cadastrar'; 
			$resultado['action']    = 'cadastrar';
			$resultado['legend']    = 'Novo';
			$resultado['name']      = 'novoExemplo';
			$resultado['resultado'] = false;

			if(isset($_REQUEST['modulo']) && $_REQUEST['modulo'] == "exemplo"){

				$dados  = $this->validarCampos(INSERT);
				$insert = $this->exemploModel->insert($dados);

				if($insert){

					$resultado['resultado'] = true;
 				}else{

					$resultado['resultado'] = false;
				}

				$resultado['mensagem']  = $insert;
				$this->loadView('formulario.php',$resultado);
			}else{

				$this->loadView('formulario.php',$resultado);
			}
		}

		// ATUALIZAR EXEMPLO
		//TRATA OS DADOS PARA SEREM EDITADOS E ATUALIZADOS NO BANCO
		public function atualizar($id){

			if($id != null AND is_numeric($id)){

				if (isset($_REQUEST['modulo']) && $_REQUEST['modulo'] == "exemplo") {

					$dados  = $this->validarCampos(UPDATE);
					$edicao = $this->exemploModel->update($dados,$id);

					$resultado['resultado'] =  false;

					if(isset($edicao['success'])){

						$resultado['mensagem']  = $edicao;
						$resultado['resultado'] =  true;
					}else{

						$resultado['mensagem']  = $edicao;
					}

					$this->editar($id,$resultado);
				}else{

					errorPage(ERROR_MODULO_INCORRECT);
				}
			}else{

				errorPage(ERROR_ID_NOT_FOUND);
			}
		}

		// DETALHA EXEMPLO
		// RECEBE UM DADO ESPECÍFICO PELO ID
		public function editar($id,$param = null){

			if($id != null AND is_numeric($id)){

				$exemplo = $this->exemploModel->getRow('id, campo1, campo2, campo3, campo4','WHERE id ='.$id);
				
				if(!isset($exemplo['error'])){

					$resultado['exemplo'] = $exemplo['success'];
				}else{

					$resultado['exemplo'] = "error";
				}
			
			}else{

				$resultado['exemplo'] = "error";
			}

			if($resultado['exemplo'] != "error"){

				$resultado['title']      = 'Editar'; 
				$resultado['action']     = 'atualizar/'.$id;
				$resultado['legend']     = 'Editar';
				$resultado['name']       = 'editarExemplo';
				$resultado['resultado']  = false;

				if($param != null){

					$resultado['resultado'] = true;
					$resultado['mensagem']  = $param['mensagem'];
					$resultado['id']        = $id;
				}

				$this->loadView('formulario.php',$resultado);
			}else{

				errorPage(ERROR_ID_NOT_FOUND);
			}
			
		}

		// LISTA EXEMPLOS
		// RECEBE UMA LISTA COM TODOS OS REGISTROS 
		public function listExemplos($pg=null,$busca=false){

			if($busca != false){

				$listar  = $this->exemploModel->getList($pg);
			}else{

				$inicio  = ($pg * $this->limite) - $this->limite;
				$busca  = " ORDER BY campo1 ASC LIMIT $inicio, $this->limite ";
				$listar = $this->exemploModel->getList($busca);
			}

			return $listar;
		}

		// DELETA EXEMPLO
		// DELETA UM REGISTRO ESPECÍFICO PELO ID
		public function delete($id){

			$resultado['resultado'] = true;
			if($id != null){

				$delete = $this->exemploModel->delete($id);

				if(!isset($delete['error'])){

					$resultado['mensagem'] = $delete['success'];	

				}else{

					$resultado['resultado'] = false;
					$resultado['mensagem']  = $delete['error'];
				}
			}else{

				$resultado['resultado'] = false;
				$resultado['mensagem']  = 'Erro ao remover.';
			}

			echo json_encode($resultado);
		}

		// TRATAMENTO DOS DADOS ANTES DO ARMAZENAMENTO
		public function validarCampos($acao){

			$dados = array();

			// VERIFICAÇÃO DO ENVIO DE IMAGENS ATRAVÉS DE CADASTROS
			if(!empty($_FILES['exemplos_campo4']['name'])){

				$imagemCampo4 = $this->exemploModel->imagemUpload($_FILES['exemplos_campo4'],$this->caminhoImagens);
			}else{

				$imagemCampo4 = "";
			}

			$dados = array(
						'exemplo' => array(
							 'campo1' => $_POST['exemploCampo1'],
							 'campo2' => $_POST['exemploCampo2'],
							 'campo3' => $_POST['exemploCampo3'],
							 'campo4' => $imagemCampo4,
							),
			);

			// CASO EXISTA ALGUMA VALIDAÇÃO ESPECÍFICA EM UMA AÇÃO
			switch($acao){

				case 1:
					// VALIDAÇÕES ESPECÍFICAS NA INSERÇÃO
				break;

				case 2:
					// VALIDAÇÕES ESPECÍFICAS NA ATUALIZAÇÃO
				break;

				default:
					// AÇÃO INDEFINIDA OU INVÁLIDA
					die('Ação indefinida');
				break;

			}

			return $dados;
		}

		public function buscar(){

			// NOMES DAS COLUNAS A SEREM PESQUISADAS
			$this->colunas   = array("campo1","");
			$this->ordenacao = "ORDER BY campo1 ASC";
			$pesquisa        = parent::buscar();

			// DADOS A SEREM RETORNADOS A PÁGINA
			$dados['pg']       = $pesquisa['indicePaginacao'];
			$dados['limite']   = $this->limite;
			$dados['condicao'] = $pesquisa['condicaoPaginacao'];
			$dados['url']      = URL."exemplos/buscar/".$pesquisa['paginaAtual']."/";
			$dados['exemplos'] = $this->listExemplos($pesquisa['busca'],true);
			$this->loadView('lista.php',$dados);
		}
	}
?>