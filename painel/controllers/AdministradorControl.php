<?php 

	/**************************************
	* CONTROLLER ADMINISTRADOR
	**************************************/

	class AdministradorControl extends Controller{

		private $administradorModel;
		private $moduloModel;
		private $usuarioModel;

		public function __construct(){

			// SETANDO O MÓDULO
			$this->setModulo('administradores');

			$permission = new Permissions();
			$this->setPaginasPermitidas($permission);
				
			//if($this->verifyPermissionPage()){
				// CARREGANDO A MODEL PRINCIPAL
				$this->administradorModel = new AdministradorModel();
				$this->moduloModel        = new ModuloModel();
				$this->usuarioModel       = new UsuarioModel();
				$this->limite             = 20;
			// }else{

			// 	errorPage(ERROR_PERMISSION_PAGE);
			// 	exit;
			// }
		}

		//CARREGA A VIEW PRINCIPAL DO MODULO
		public function index($pg = 1){

			$dados['pg']              = ''; //$pg;
			$dados['condicao']        = ''; //"WHERE u.nivelId = 1";
			$dados['url']             = ''; //URL.'administradores/index/';
			$dados['limite']          = ''; //$this->limite;
			$dados['administradores'] = ''; //$this->listAdministradores($pg);
			$this->loadView('lista.php',$dados);
		}

		// CARREGA QUAL MÉTODO IRÁ RECEBER A REQUISIÇÃO AJAX
		public function loadMethod($acao, $id){

			if($acao != null){

				switch($acao):

					case 'delete':
						$usuarioId = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : '';
						$this->delete($id,$usuarioId);
					break;

					case 'verificaEmail':

						// VALIDAÇÃO DE E-MAIL JÁ EXISTENTE NO BANCO (ADMINISTRADORES)
						$administradorEmail     = isset($_POST['emailAdmin'])     ? $_POST['emailAdmin'] : null;
						$administradorEmailEdit = isset($_POST['emailAdminEdit']) ? $_POST['emailAdminEdit'] : null;
						$administradorEmailRef  = isset($_POST['emailAdminRef'])  ? $_POST['emailAdminRef'] : null;

						$resultado = $this->verificaEmail($administradorEmail, $administradorEmailEdit, $administradorEmailRef);
						echo(json_encode($resultado));

					break;

				endswitch;
			}
		}

		//TRATA OS DADOS PARA SEREM INSERIDOS NO BANCO
		public function cadastrar(){

			$resultado['title']     		= 'Cadastrar'; 
			$resultado['action']    		= 'cadastrar';
			$resultado['legend']    		= 'Novo';
			$resultado['name']      		= 'novoAdministrador';
			$resultado['modulos']   		= $this->moduloModel->getList();			
			$resultado['modulosPermitidos'] = $this->moduloModel->getListPermissions("");
			$resultado['resultado'] 		= false;

			if(isset($_REQUEST['modulo']) && $_REQUEST['modulo'] == "administrador"){

				$dados  = $this->validarCampos(INSERT);
				$insert = $this->administradorModel->insert($dados);

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

		//TRATA OS DADOS PARA SEREM EDITADOS E ATUALIZADOS NO BANCO
		public function atualizar($id){
			if($id != null AND is_numeric($id)){

				if (isset($_REQUEST['modulo']) && $_REQUEST['modulo'] == "administrador") {

					$dados  = $this->validarCampos(UPDATE);
					$edicao = $this->administradorModel->update($dados['login'],$id);

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

		//RECEBE UM DADO ESPECÍFICO PELO ID
		public function editar($id,$param = null){

			if($id != null AND is_numeric($id)){

				$administrador = $this->administradorModel->getRow('l.id as loginId, u.id as usuarioId, email, u.nome as nomeUsuario, status, permissoes','WHERE l.id ='.$id);

				if(!isset($administrador['error'])){

					$resultado['administrador'] = $administrador['success'];
				}else{

					$resultado['administrador'] = "error";
				}
			}else{

				$resultado['administrador'] = "error";
			}

			if($resultado['administrador'] != "error"){

				$resultado['title']  = 'Editar'; 
				$resultado['action'] = 'atualizar/'.$id;
				$resultado['legend'] = 'Editar';
				$resultado['name']   = 'editarAdministrador';

				$resultado['modulos']   		= $this->moduloModel->getList();
				$resultado['modulosPermitidos'] = $this->moduloModel->getListPermissions($administrador['success']->getPermissoes());

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

		//RECEBE UMA LISTA COM TODOS OS REGISTROS
		public function listAdministradores($pg=null,$busca=false){

			if($busca != false){

				$listar  = $this->administradorModel->getList($pg);
			}else{

				$start  = ($pg * $this->limite) - $this->limite;
				$busca  = " WHERE u.nivelId = 1 ORDER BY u.nome ASC LIMIT $start, $this->limite";
				$listar = $this->administradorModel->getList($busca);
			}

			// MONTANDO LAYOUT TABELA

			// SETANDO O CABEÇALHO
			$cabecalhoTitulos = array('Nome', 'E-mail', 'Status', 'Ações');
			$this->tabela->setCabecalho($cabecalhoTitulos);
			
			// VERIFICANDO SE HOUVE RETORNO DOS DADOS
			if(!isset($listar['error'])){

				// LISTANDO OS ADMINSTRADORES E MONTANDO AS LINHAS NA TABELA
				foreach($listar as $administrador){

					$dados = array($administrador->getUsuario()->getNome(), 
									$administrador->getEmail(), 
									showStatus($administrador->getStatus()), 
									"<a href=".URL."administradores/editar/".$administrador->getId().">Editar</a>&nbsp;|
										<a data-id='".$administrador->getId()."' data-id-client='".$administrador->getUsuario()->getId()."' class='excluir' href='#'>Excluir</a>"
									);
					
					// ADICIONANDO LINHA
					$this->tabela->add_linha($dados);				
				}

			}else{
				// RESPOSTA QUANDO NÃO HOUVER RETORNO NA LISTAGEM
				$dados = array($listar['error']);
				$this->tabela->add_linha($dados);
			}
			
			// GERANDO O TEMPLATE DA TABELA COM AS INFORMAÇÕES
			$listar =  $this->tabela->generate();
		
			return $listar;
		}

		//DELETA UM REGISTRO ESPECÍFICO PELO ID
		public function delete($id,$usuarioId=null){

			$resultado['resultado'] = true;
			if($id != null){

				$delete = $this->administradorModel->delete($id);

				if(!isset($delete['error'])){

					if($usuarioId != null){

						$usuarioModel  = new UsuarioModel();
						$deleteUsuario = $usuarioModel->delete($usuarioId);
					}

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
		private function validarCampos($acao){
			$dados = array();

			$permissoes = isset($_POST['listaModulosEscolhidos']) ? serialize($_POST['listaModulosEscolhidos']) : null;	

			$dados['login']['email']    = isset($_POST['emailAdmin']) ? $_POST['emailAdmin'] : $_POST['emailAdminEdit'];

			if(!empty($_POST['senhaAdmin'])){

				$dados['login']['senha'] =  md5($_POST['senhaAdmin']);
			}

			$dados['login']['permissoes'] = $permissoes;
			$dados['login']['status']     = $_POST['acessoAdmin'];

			// CASO EXISTA ALGUMA VALIDAÇÃO ESPECÍFICA EM UMA AÇÃO
			switch($acao){

				case 1:

					// VALIDAÇÕES ESPECÍFICAS NA INSERÇÃO
					$dados['usuario'] = array(
							'nivelId'        => $_POST['nivelAdmin'],
							'nome'           => $_POST['nomeCompletoAdmin'],
							'fotoPerfil'     => isset($_POST['fotoPerfilAdmin']) ? $_POST['fotoPerfilAdmin'] : '',
							'sexo'           => '',
							'dataNascimento' => '0000-00-00',
							'telefone'       => isset($_POST['telefoneAdmin']) ? $_POST['telefoneAdmin'] : '',
							'celular'        => '',
							'cpf'            => isset($_POST['cpfAdmin']) ? $_POST['cpfAdmin'] : ''
					);

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

		public function verificaEmail($emailAdmin, $emailAdminEdit, $emailAdminRef){

			if(!empty($emailAdmin)){

				$administrador = $this->administradorModel->getRow("l.id as loginId, u.id as usuarioId, l.email","WHERE l.email ='".$emailAdmin."' ");

				if(!isset($administrador['error'])){

					$resultado = false;
				}else{

					$resultado = true;
				}
			}elseif($emailAdminEdit != $emailAdminRef){

				$administrador = $this->administradorModel->getRow("l.id as loginId, u.id as usuarioId, l.email","WHERE l.email ='".$emailAdminEdit."' ");

				if(!isset($administrador['error'])){

					$resultado = false;
				}else{

					$resultado = true;
				}

			}else{

				$resultado = true;
			}

			return $resultado;
		}

		public function buscar(){

			// NOMES DAS COLUNAS A SEREM PESQUISADAS
			$this->colunas   = array("u.nome","l.email","");
			$this->ordenacao = "ORDER BY u.nome ASC";
			$pesquisa        = parent::buscar();

			// DADOS A SEREM RETORNADOS A PÁGINA
			$dados['pg']              = $pesquisa['indicePaginacao'];
			$dados['condicao']        = $pesquisa['condicaoPaginacao'];
			$dados['limite']          = $this->limite;
			$dados['url']             = URL."administradores/buscar/".$pesquisa['paginaAtual']."/";
			$dados['limite']          = $this->limite;
			$dados['administradores'] = $this->listAdministradores($pesquisa['busca'],true);
			$this->loadView('lista.php',$dados);
		}
	}
?>